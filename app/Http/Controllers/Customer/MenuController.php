<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Menu';
        $category = $request->get('category'); 

        if ($category && $category !== 'all') {
            $menus = Menu::where('category', $category)
                ->where('availability', 'available') // hanya menu yang tersedia
                ->orderBy('type')
                ->get()
                ->groupBy('type');
        } else {
            $menus = Menu::where('availability', 'available') // hanya menu yang tersedia
                ->orderBy('type')
                ->get()
                ->groupBy('type');
        }

        return view('customer.pages.menu.index', compact('title', 'menus', 'category'));
    }

}
