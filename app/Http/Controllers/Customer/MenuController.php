<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $title = 'Menu'; 
        $menus = Menu::all();

        return view('customer.pages.menu.index', compact('title', 'menus'));
    }
}
