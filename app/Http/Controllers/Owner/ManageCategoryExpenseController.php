<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryExpense;

class ManageCategoryExpenseController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Owner Manage Category Expense';

        // request inputs
        $search = $request->input('search');
        $status = $request->input('s_status');

        // detect filter state
        $isFiltered = !empty($search) || !empty($status);

        // sorting (optional) - sanitize by whitelist
        $allowedSorts = ['id_category_expense', 'category', 'item_name', 'price', 'status', 'created_at'];
        $sortedBy = $request->input('sort_by');
        $sortedDir = strtolower($request->input('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $isSorted = $sortedBy && in_array($sortedBy, $allowedSorts);

        // build query
        $query = CategoryExpense::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                ->orWhere('item_name', 'like', "%{$search}%")
                ->orWhere('id_category_expense', 'like', "%{$search}%");
            });
        }

        if (!empty($status) && strtolower($status) !== 'all') {
            $query->where('status', $status);
        }

        // get count of filtered results (needed for the toast)
        $filteredCount = $query->count();

        // apply ordering
        if ($isSorted) {
            $query->orderBy($sortedBy, $sortedDir);
            $sortedDirLabel = $sortedDir === 'desc' ? 'descending' : 'ascending';
        } else {
            // default ordering
            $query->latest('created_at');
            $sortedBy = null;
            $sortedDirLabel = null;
        }

        // get results (you can swap to paginate(...) if you want pagination)
        $categories = $query->get();

        // counters (global totals)
        $totalActive   = CategoryExpense::where('status', 'Active')->count();
        $totalDeactive = CategoryExpense::where('status', 'Deactive')->count();
        $totalAll      = CategoryExpense::count();

        return view('owner.pages.manage-category-expense.index', compact(
            'title',
            'categories',
            'totalActive',
            'totalDeactive',
            'totalAll',
            'isFiltered',
            'filteredCount',
            'isSorted',
            'sortedBy',
            'sortedDirLabel'
        ));
    }


    public function addCategory()
    {
        $title = 'Owner Add Category Expense';

         return view('owner.pages.manage-category-expense.create', compact(
            'title',
        ));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'other_category' => 'required_if:category,Other|string|nullable',
            'item_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Deactive',
        ], [
            'category.required' => 'Category is required.',
            'other_category.required_if' => 'Please enter the other category.',
            'item_name.required' => 'Item name is required.',
            'price.required' => 'Price per unit is required.',
            'price.numeric' => 'Price must be a number.',
            'status.required' => 'Status is required.',
            'status.in' => 'Invalid status value.'
        ]);

        // Jika kategori Other, ambil dari other_category
        $categoryName = $request->category === "Other" ? $request->other_category : $request->category;

        // Generate id_category_expense unik
        do {
            $randomNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $idCategory = "CATEXP" . $randomNumber;
        } while (CategoryExpense::where('id_category_expense', $idCategory)->exists());

        // Simpan ke database
        CategoryExpense::create([
            'id_category_expense' => $idCategory,
            'category' => $categoryName,
            'item_name' => $request->item_name,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('owner.manage-category-expense')
            ->with('success', 'Category expense has been successfully added.');
    }

    public function edit($id)
    {
        $title = 'Owner Edit Category Expense';
        $category = CategoryExpense::findOrFail($id);
        return view('owner.pages.manage-category-expense.edit', compact('category', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Active,Deactive',
        ]);

        $category = CategoryExpense::findOrFail($id);
        $category->status = $request->status;
        $category->save();

        return redirect()->route('owner.manage-category-expense')->with('success', 'Category status updated successfully.');
    }

    public function destroy($id)
    {
        $category = CategoryExpense::findOrFail($id);
        $category->delete();

        return redirect()->route('owner.manage-category-expense')->with('success', 'Kategori berhasil dihapus.');
    }
}
