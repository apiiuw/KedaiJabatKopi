<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Cashier Dashboard';
        $today = Carbon::today();

        // Kartu ringkasan
        $ordersToday   = Order::whereDate('created_at', $today)->count();
        $incomeToday   = Order::whereDate('created_at', $today)->sum('total_amount');
        $onGoingCount  = Order::where('status', 'on going')->whereDate('created_at', $today)->count();
        $completeCount = Order::where('status', 'complete')->whereDate('created_at', $today)->count();

        // BEST SELLER (berdasarkan quantity) — join ke id_order (bukan id)
        $row = DB::table('order_items')
            ->join('orders', 'orders.id_order', '=', 'order_items.id_order')
            ->whereDate('orders.created_at', $today)
            // ->where('orders.status', 'complete') // aktifkan jika hanya mau yang complete
            ->select('order_items.id_menu', DB::raw('SUM(order_items.quantity) as qty'))
            ->groupBy('order_items.id_menu')
            ->orderByDesc('qty')
            ->first();

        $bestSellerName = '-';
        $bestSellerQty  = 0;

        if ($row) {
            $bestSellerName = Menu::where('id_menu', $row->id_menu)->value('product_name') ?? '-';
            $bestSellerQty  = (int) $row->qty;
        }

        // Chart per jam
        $perHour = Order::selectRaw('HOUR(created_at) as hr, SUM(total_amount) as total')
            ->whereDate('created_at', $today)
            ->groupBy('hr')->orderBy('hr')->pluck('total','hr')->toArray();

        $labels = $values = [];
        for ($h=0; $h<24; $h++) {
            $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            $values[] = (float) ($perHour[$h] ?? 0);
        }

        return view('cashier.pages.dashboard.index', compact(
            'title',
            'ordersToday','incomeToday','onGoingCount','completeCount',
            'bestSellerName','bestSellerQty',
            'labels','values'
        ));
    }
}
