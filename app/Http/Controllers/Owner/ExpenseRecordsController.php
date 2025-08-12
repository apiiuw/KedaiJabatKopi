<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseRecordsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Expense Records';

        $query = Expense::query();

        $isFiltered = false;
        if ($search = $request->q) {
            $isFiltered = true;
            $query->where(function ($q) use ($search) {
                $q->where('id_expenses', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('item', 'like', "%{$search}%");
            });
        }

        if ($category = $request->category) {
            $isFiltered = true;
            $query->where('category', $category);
        }

        $sort = $request->get('sort');
        $dir  = $request->get('dir', 'desc');

        $isSorted = false;
        $sortedBy = null;
        $sortedDirLabel = null;

        if ($sort && in_array($sort, ['created_at', 'amount'])) {
            $isSorted = true;
            $sortedBy = $sort === 'created_at' ? 'Date' : 'Total Amount';
            $sortedDirLabel = $dir === 'asc' ? 'Ascending' : 'Descending';
            $query->orderBy($sort, $dir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $expenses = $query->get();
        $filteredCount = $expenses->count();

        // Ambil semua kategori unik dari semua data
        $categories = Expense::select('category')
            ->distinct()
            ->pluck('category');

        // Hanya hari ini
        $totalCountExpense = $expenses->count();
        $totalCountAmount = $expenses->sum('amount');

        // Ini sekarang jadi total keseluruhan, bukan hanya hari ini
        $totalExpenseAll = Expense::count();
        $totalAmountAll  = Expense::sum('amount');

        return view('owner.pages.expense-records.index', compact(
            'title',
            'expenses',
            'categories',
            'totalCountExpense',
            'totalCountAmount',
            'totalExpenseAll',
            'totalAmountAll',
            'isFiltered',
            'isSorted',
            'filteredCount',
            'sortedBy',
            'sortedDirLabel'
        ));
    }

}
