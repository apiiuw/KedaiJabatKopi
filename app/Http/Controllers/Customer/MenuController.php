<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $title = 'Menu'; // Ganti sesuai kebutuhan

        return view('customer.pages.menu.index', compact('title'));
    }
}
