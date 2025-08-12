<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;

class ODashboardController extends Controller
{
    public function index()
    {
        $title = 'Owner Dashboard';

        $today = Carbon::today();

        // Total income hari ini (jumlah order dengan status selesai dan tanggal hari ini)
        $incomeToday = Order::whereDate('created_at', $today)
            ->sum('total_amount'); // pastikan ada kolom total_price di orders

        // Total expense hari ini
        $expenseToday = Expense::whereDate('created_at', $today)->sum('amount'); // ganti amount sesuai kolom nominal di expense

        // Total order hari ini (semua status)
        $ordersToday = Order::whereDate('created_at', $today)->count();

        // Total user (misal semua user kecuali admin atau sesuai kebutuhan)
        $userCount = User::count();

        // Data untuk chart income dan expense per jam (24 jam)
        $hourLabels = [];
        $incomeByHour = [];
        $expenseByHour = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $hourLabels[] = sprintf('%02d:00', $hour);

            $incomeSum = Order::whereDate('created_at', $today)
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->sum('total_amount');

            $expenseSum = Expense::whereDate('created_at', $today)
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->sum('amount');

            $incomeByHour[] = (int)$incomeSum;
            $expenseByHour[] = (int)$expenseSum;
        }

        return view('owner.pages.dashboard.index', compact(
            'title',
            'incomeToday',
            'expenseToday',
            'ordersToday',
            'userCount',
            'hourLabels',
            'incomeByHour',
            'expenseByHour',
        ));
    }
}
