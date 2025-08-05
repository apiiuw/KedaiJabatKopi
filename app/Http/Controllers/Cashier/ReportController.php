<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $title = 'Cashier Report';

        return view('cashier.pages.report.index', compact('title'));
    }
}
