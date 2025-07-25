<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $title = 'About Us'; // Ganti sesuai kebutuhan

        return view('customer.pages.about-us.index', compact('title'));
    }
}
