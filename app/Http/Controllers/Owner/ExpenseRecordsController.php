<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseRecordsController extends Controller
{
    public function index()
    {
        $title = 'Owner Expense Records';

         return view('owner.pages.expense-records.index', compact(
            'title',
        ));
    }
}
