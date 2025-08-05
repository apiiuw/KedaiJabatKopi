<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Cashier Dashboard'; // Ganti sesuai kebutuhan

        return view('cashier.pages.dashboard.index', compact('title'));
    }
}
