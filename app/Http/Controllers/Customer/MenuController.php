<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $title    = 'Menu';
        $category = $request->input('category', 'all');
        $q        = trim((string) $request->input('q', ''));

        // Jika ada query dan user sedang di kategori selain "all", paksa pindah ke "all" sambil bawa q
        if ($q !== '' && $category !== 'all') {
            return redirect()->route('menu.index', ['category' => 'all', 'q' => $q]);
        }

        $menusQuery = Menu::query()
            ->where('availability', 'available'); // hanya yang tersedia

        if ($q !== '' && $category === 'all') {
            // Search hanya bekerja di halaman "all"
            $menusQuery->where(function ($s) use ($q) {
                $s->where('product_name', 'like', "%{$q}%")
                ->orWhere('type', 'like', "%{$q}%")
                ->orWhere('category', 'like', "%{$q}%");
            });
        } elseif ($category !== 'all') {
            // Filter kategori biasa (tanpa search)
            $menusQuery->where('category', $category);
        }

        $menus = $menusQuery->orderBy('type')->get()->groupBy('type');

        return view('customer.pages.menu.index', compact('title', 'menus', 'category', 'q'));
    }

}
