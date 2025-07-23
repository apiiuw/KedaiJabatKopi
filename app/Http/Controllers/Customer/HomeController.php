<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Beranda'; // Ganti sesuai kebutuhan

        return view('customer.pages.home.index', compact('title'));
    }
}
