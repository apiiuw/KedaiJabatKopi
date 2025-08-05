<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    public function index()
    {
        $title = 'Cashier Manage Menu';

        return view('cashier.pages.manage-menu.index', compact('title'));
    }
}
