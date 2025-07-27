<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailItemController extends Controller
{
    public function index()
    {
        $title = 'Detail Item'; // Ganti sesuai kebutuhan

        return view('customer.pages.detail-item.index', compact('title'));
    }
}
