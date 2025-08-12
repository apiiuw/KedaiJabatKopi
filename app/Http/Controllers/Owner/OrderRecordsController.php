<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderRecordsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Past Orders';

        $query = Order::query();

        // Flag filter/search
        $isFiltered = false;

        // Filter status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
            $isFiltered = true;
        }

        // Search
        if ($q = $request->input('q')) {
            $query->where(function ($s) use ($q) {
                $s->where('id_order', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")
                ->orWhere('table_number', 'like', "%{$q}%");
            });
            $isFiltered = true;
        }

        // Filter tanggal
        $from = $request->input('from');
        $to   = $request->input('to');

        if ($from && $to && $from > $to) {
            [$from, $to] = [$to, $from];
        }
        if ($from) { $query->whereDate('created_at', '>=', $from); $isFiltered = true; }
        if ($to)   { $query->whereDate('created_at', '<=', $to);   $isFiltered = true; }

        // ---- SORT ----
        $sort = $request->input('sort');         // 'date' | 'amount' | null
        $dir  = $request->input('dir', 'desc');  // 'asc' | 'desc' (default desc utk past)
        $dir  = in_array($dir, ['asc','desc']) ? $dir : 'desc';

        if ($sort === 'date') {
            $query->orderBy('created_at', $dir);
        } elseif ($sort === 'amount') {
            $query->orderBy('total_amount', $dir);
        } else {
            // default: terbaru dulu
            $query->orderBy('created_at', 'desc');
        }

        // Data filtered
        $orders         = (clone $query)->get();
        $filteredCount  = $orders->count();
        $totalIncomePast= (clone $query)->sum('total_amount');
        $countPastOrders= (clone $query)->count();

        // Data total tanpa filter (tetap)
        $totalIncomePastAll = Order::where('status', 'complete')
            ->whereDate('created_at', '<', Carbon::today())
            ->sum('total_amount');

        $countPastOrdersAll = Order::where('status', 'complete')
            ->whereDate('created_at', '<', Carbon::today())
            ->count();

        // Flag sort untuk toast
        $isSorted       = in_array($sort, ['date','amount']);
        $sortedBy       = $sort === 'date' ? 'Date' : ($sort === 'amount' ? 'Total Amount' : '');
        $sortedDirLabel = $dir === 'asc' ? 'Ascending' : 'Descending';

        return view('owner.pages.order-records.index', compact(
            'title','orders',
            'totalIncomePast','countPastOrders',
            'totalIncomePastAll','countPastOrdersAll',
            'isFiltered','filteredCount',
            'sort','dir','isSorted','sortedBy','sortedDirLabel'
        ));
    }
}
