<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $title = 'Cashier Order';

        return view('cashier.pages.order.index', compact('title'));
    }
}
