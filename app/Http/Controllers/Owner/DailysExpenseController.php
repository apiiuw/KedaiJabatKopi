<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailysExpenseController extends Controller
{
    public function index()
    {
        $title = 'Owner Daily Expense';

         return view('owner.pages.dailys-expense.index', compact(
            'title',
        ));
    }
}
