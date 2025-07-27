<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Cart'; // Ganti sesuai kebutuhan

        return view('customer.pages.cart.index', compact('title'));
    }
}
