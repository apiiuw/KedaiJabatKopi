<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class DetailItemController extends Controller
{
    public function index(Request $request, $id_menu)
    {
        $menu = Menu::where('id_menu', $id_menu)->firstOrFail();
        $title = $menu->product_name;

        // Ambil kategori dari query string jika ada, atau dari menu ini
        $category = $request->get('category', $menu->category);

        return view('customer.pages.detail-item.index', compact('title', 'menu', 'category'));
    }

}
