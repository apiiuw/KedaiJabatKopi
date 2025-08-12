<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DailysExpenseController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Daily Expense';

        $query = Expense::query();

        // Filter hanya hari ini
        $query->whereDate('created_at', now()->toDateString());

        // Cek filter
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
        $dir  = $request->get('dir', 'desc'); // default desc

        // Sorting
        $isSorted = false;
        $sortedBy = null;
        $sortedDirLabel = null;

        if ($sort && in_array($sort, ['created_at', 'amount'])) {
            $isSorted = true;
            $sortedBy = $sort === 'created_at' ? 'Date' : 'Total Amount';
            $sortedDirLabel = $dir === 'asc' ? 'Ascending' : 'Descending';
            $query->orderBy($sort, $dir);
        } else {
            // Default sorting terbaru tanpa dianggap sebagai "sorted"
            $query->orderBy('created_at', 'desc');
        }

        // Ambil data expenses
        $expenses = $query->get();

        $filteredCount = $expenses->count();

        // Ambil list kategori unik (hari ini saja)
        $categories = Expense::whereDate('created_at', now()->toDateString())
            ->select('category')
            ->distinct()
            ->pluck('category');

        $totalDailyExpense = $expenses->count();
        $totalDailyAmount = $expenses->sum('amount');

        $todayExpensesAll = Expense::whereDate('created_at', now()->toDateString())->get();
        $totalDailyExpenseAll = $todayExpensesAll->count();
        $totalDailyAmountAll  = $todayExpensesAll->sum('amount');

        return view('owner.pages.dailys-expense.index', compact(
            'title',
            'expenses',
            'categories',
            'totalDailyExpense',
            'totalDailyAmount',
            'totalDailyExpenseAll', 
            'totalDailyAmountAll',  
            'isFiltered',
            'isSorted',
            'filteredCount',
            'sortedBy',
            'sortedDirLabel'
        ));
    }

    public function addExpense()
    {
        $title = 'Owner Add Expense';
        $categories = CategoryExpense::select('category')->distinct()->get();

        return view('owner.pages.dailys-expense.create', compact(
            'title',
            'categories'
        ));
    }

    public function getItemsByCategory(Request $request)
    {
        $items = CategoryExpense::where('category', $request->category)
            ->pluck('item_name'); // hanya ambil nama item

        return response()->json($items);
    }


    public function getPriceByCategoryAndItem(Request $request)
    {
        $price = CategoryExpense::where('category', $request->category)
            ->where('item_name', $request->item)
            ->value('price');

        return response()->json([
            'price' => $price, // angka asli
            'price_formatted' => 'Rp ' . number_format($price, 0, ',', '.')
        ]);
    }

    public function storeExpense(Request $request)
    {
        $request->merge([
            'price' => preg_replace('/[^0-9]/', '', $request->price) / 100
        ]);

        $request->validate([
            'category' => 'required|string',
            'item' => 'required|string', 
            'price' => 'required|numeric',
            'qty' => 'required|numeric',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ], [
            'category.required' => 'Category is required.',
            'item.required' => 'Item name is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'qty.required' => 'Quantity is required.',
            'qty.numeric' => 'Quantity must be a number.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.'
        ]);

        // Generate kode unik
        do {
            $idExpenses = 'EXP' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Expense::where('id_expenses', $idExpenses)->exists());

        Expense::create([
            'id_expenses' => $idExpenses,
            'category'    => $request->category,
            'item'        => $request->item,
            'price'       => $request->price,
            'qty'         => $request->qty,
            'amount'      => $request->amount,
            'description' => $request->description
        ]);

        return redirect()
            ->route('owner.dailys-expense')
            ->with('success', 'Expense saved successfully!');
    }

    public function edit($id)
    {
        $title = 'Owner Edit Expense';
        $expense = Expense::findOrFail($id);
        return view('owner.pages.dailys-expense.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable|string|max:255'
        ]);

        $expense = Expense::findOrFail($id);

        if ($expense->description !== $request->description) {
            $expense->description = $request->description;
            $expense->save();
        }

        return redirect()
            ->route('owner.dailys-expense')
            ->with('success', 'Description updated successfully!');
    }

}
