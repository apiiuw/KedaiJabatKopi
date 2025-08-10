<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Cashier Order';
        $date  = Carbon::now()->translatedFormat('d F Y');

        $query = Order::with(['items.menu'])
            ->whereDate('created_at', Carbon::today());

        // SEARCH
        if ($q = $request->input('q')) {
            $qNorm = trim($q);
            $qNum  = preg_replace('/\D/', '', $qNorm);

            $query->where(function ($s) use ($qNorm, $qNum) {
                $s->where('name', 'like', "%{$qNorm}%")
                ->orWhere('id_order', 'like', "%{$qNorm}%");

                if ($qNum !== '') {
                    $s->orWhere('table_number', $qNum)
                    ->orWhere('id_order', $qNum);
                } else {
                    $s->orWhere('table_number', 'like', "%{$qNorm}%");
                }
            });
        }

        // FILTER STATUS
        if ($status = $request->input('status')) {
            if (in_array($status, ['paid','on going','complete'])) {
                $query->where('status', $status);
            }
        }

        // SORT
        $sort = $request->input('sort');              // 'time' | 'amount' | null
        $dir  = $request->input('dir', 'asc');        // 'asc' | 'desc'
        $dir  = in_array($dir, ['asc','desc']) ? $dir : 'asc';

        if ($sort === 'time') {
            $query->orderBy('created_at', $dir);
        } elseif ($sort === 'amount') {
            $query->orderBy('total_amount', $dir);
        } else {
            // default: status -> time
            $query->orderByRaw("FIELD(status, 'paid','on going','complete')")
                ->orderBy('created_at', 'asc');
        }

        $orders = $query->get();

        // Ringkasan (tetap harian penuh)
        $countPaids     = Order::where('status','paid')->whereDate('created_at', Carbon::today())->count();
        $countOnGoing   = Order::where('status','on going')->whereDate('created_at', Carbon::today())->count();
        $countComplete  = Order::where('status','complete')->whereDate('created_at', Carbon::today())->count();
        $countAll       = Order::whereDate('created_at', Carbon::today())->count();

        // Total income mengikuti filter & search (kalau mau full harian, ganti ke query terpisah)
        $totalIncome = $orders->sum('total_amount');

        $isSorted        = in_array($sort, ['time','amount']);
        $sortedBy        = $sort === 'time' ? 'Time' : ($sort === 'amount' ? 'Total Amount' : '');
        $sortedDirLabel  = $dir === 'asc' ? 'Ascending' : 'Descending';

        $isFiltered    = $request->filled('q') || $request->filled('status');
        $filteredCount = $orders->count();

        return view('cashier.pages.order.index', compact(
            'title','date','orders',
            'countPaids','countOnGoing','countComplete','countAll','totalIncome',
            'isFiltered','filteredCount','sort','dir', 'isSorted','sortedBy','sortedDirLabel'
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
