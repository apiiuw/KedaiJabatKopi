<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PastOrderController extends Controller
{
        public function index()
    {
        $title = 'Cashier Past Order';

        return view('cashier.pages.past-order.index', compact('title'));
    }
}
