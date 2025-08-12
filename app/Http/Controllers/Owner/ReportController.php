<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Report';

        // Ambil filter tanggal dari query string
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query Orders dengan filter tanggal jika ada
        $ordersQuery = Order::query();
        if ($startDate) {
            $ordersQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $ordersQuery->whereDate('created_at', '<=', $endDate);
        }
        $orders = $ordersQuery->with('items.menu')->get();

        // Query Expenses dengan filter tanggal
        $expensesQuery = Expense::query();
        if ($startDate) {
            $expensesQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $expensesQuery->whereDate('created_at', '<=', $endDate);
        }
        $expenses = $expensesQuery->with('categoryExpense')->get();

        // hitung total income
        $totalIncome = $orders->sum('total_amount');

        $totalExpenses = $expenses->sum('amount');

        $totalOrders = $orders->count();

        // Cari best seller menu berdasarkan total qty terjual
        $bestSeller = OrderItem::select('id_menu', DB::raw('SUM(quantity) as total_qty'))
            ->join('orders', 'order_items.id_order', '=', 'orders.id_order')
            ->when($startDate, fn($q) => $q->whereDate('orders.created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('orders.created_at', '<=', $endDate))
            ->groupBy('id_menu')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        $bestSellerName = $bestSeller?->menu?->product_name ?? '-';

        $isFiltered = ($startDate || $endDate);
        $filteredCount = $orders->count();

        return view('owner.pages.report.index', compact(
            'title',
            'orders',
            'expenses',
            'totalIncome',
            'totalExpenses',
            'totalOrders',
            'bestSellerName',
            'startDate',
            'endDate',
            'isFiltered',
            'filteredCount'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data orders dengan filter tanggal
        $ordersQuery = Order::query();
        if ($startDate) {
            $ordersQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $ordersQuery->whereDate('created_at', '<=', $endDate);
        }
        $orders = $ordersQuery->with('items.menu')->get();

        // Ambil data expenses dengan filter tanggal
        $expensesQuery = Expense::query();
        if ($startDate) {
            $expensesQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $expensesQuery->whereDate('created_at', '<=', $endDate);
        }
        $expenses = $expensesQuery->with('categoryExpense')->get();

        // Hitung total income
        $totalIncome = $orders->sum('total_amount');

        // Hitung total expenses (jumlahkan qty * price tiap expense)
        $totalExpenses = $expenses->reduce(function($carry, $item) {
            return $carry + ($item->qty * $item->price);
        }, 0);

        // Total orders
        $totalOrders = $orders->count();

        // Cari best seller menu berdasarkan total qty terjual
        $bestSeller = OrderItem::select('id_menu', DB::raw('SUM(quantity) as total_qty'))
            ->join('orders', 'order_items.id_order', '=', 'orders.id_order')
            ->when($startDate, fn($q) => $q->whereDate('orders.created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('orders.created_at', '<=', $endDate))
            ->groupBy('id_menu')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->first();

        $bestSellerName = $bestSeller?->menu?->product_name ?? '-';

        // Tanggal cetak sekarang
        $printDate = now()->format('d F Y');

        // Format periode (bila ada)
        if ($startDate && $endDate) {
            $period = date('d F Y', strtotime($startDate)) . ' - ' . date('d F Y', strtotime($endDate));
        } elseif ($startDate) {
            $period = 'From ' . date('d F Y', strtotime($startDate));
        } elseif ($endDate) {
            $period = 'Until ' . date('d F Y', strtotime($endDate));
        } else {
            $period = 'All Period';
        }

        // Data untuk PDF view
        $data = [
            'totalIncomes' => 'Rp ' . number_format($totalIncome, 0, ',', '.'),
            'totalExpenses' => 'Rp ' . number_format($totalExpenses, 0, ',', '.'),
            'totalOrders' => $totalOrders,
            'bestSeller' => $bestSellerName,
            'incomes' => $orders,
            'expenses' => $expenses,
            'printDate' => $printDate,
            'period' => $period,
        ];

        $pdf = PDF::loadView('owner.pages.report.pdf', $data);

        return $pdf->download('report-' . date('Ymd') . '.pdf');
    }
}
