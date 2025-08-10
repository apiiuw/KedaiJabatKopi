<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $title = 'Cashier Order';
        $date  = Carbon::now()->translatedFormat('d F Y');

        $orders = Order::with(['items.menu'])
            ->orderByRaw("FIELD(status, 'paid','on going','complete')")
            ->orderBy('created_at', 'asc')
            ->get();

        // Hitung jumlah order per status
        $countPaid      = Order::where('status', 'paid')->count();
        $countOnGoing   = Order::where('status', 'on going')->count();
        $countComplete  = Order::where('status', 'complete')->count();
        $countAll       = Order::count();

        return view('cashier.pages.order.index', compact(
            'title', 'date', 'orders',
            'countPaid', 'countOnGoing', 'countComplete', 'countAll'
        ));
    }

    public function process($id_order)
    {
        $order = Order::where('id_order', $id_order)->firstOrFail();

        if ($order->status === 'on going') {
            // Kalau sudah on going → ubah jadi complete
            $order->status = 'complete';
            $order->save();

            return back()->with('successFinish', "Order #$id_order has been finished successfully.");
        } else {
            // Kalau belum on going → ubah jadi on going
            $order->status = 'on going';
            $order->save();

            return back()->with('successOnGoing', "Order #$id_order has been processed successfully.");
        }
    }

}
