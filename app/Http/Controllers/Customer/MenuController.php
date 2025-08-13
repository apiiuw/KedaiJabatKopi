<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\StoreStatus;
use App\Models\StoreSetting;
use Carbon\Carbon;

class MenuController extends Controller
{
    // public function index(Request $request)
    // {
    //     $title    = 'Menu';
    //     $category = $request->input('category', 'all');
    //     $q        = trim((string) $request->input('q', ''));

    //     // Jika ada query dan user sedang di kategori selain "all", paksa pindah ke "all" sambil bawa q
    //     if ($q !== '' && $category !== 'all') {
    //         return redirect()->route('menu.index', ['category' => 'all', 'q' => $q]);
    //     }

    //     $menusQuery = Menu::query()
    //         ->where('availability', 'available'); // hanya yang tersedia

    //     if ($q !== '' && $category === 'all') {
    //         // Search hanya bekerja di halaman "all"
    //         $menusQuery->where(function ($s) use ($q) {
    //             $s->where('product_name', 'like', "%{$q}%")
    //             ->orWhere('type', 'like', "%{$q}%")
    //             ->orWhere('category', 'like', "%{$q}%");
    //         });
    //     } elseif ($category !== 'all') {
    //         // Filter kategori biasa (tanpa search)
    //         $menusQuery->where('category', $category);
    //     }

    //     $menus = $menusQuery->orderBy('type')->get()->groupBy('type');

    //     return view('customer.pages.menu.index', compact('title', 'menus', 'category', 'q'));
    // }

    public function index(Request $request)
    {
        $title    = 'Menu';
        $category = $request->input('category', 'all');
        $q        = trim((string) $request->input('q', ''));

        // Ambil status manual dari store_status
        $storeStatus = StoreStatus::first();
        $isOpenManual = $storeStatus && $storeStatus->is_open == 1;

        // Ambil jadwal buka hari ini
        $today = strtolower(Carbon::now()->format('l')); // contoh: monday
        $settingToday = StoreSetting::where('day', $today)
            ->where('is_active', 1)
            ->first();

        $isOpenTime = false;
        if ($settingToday) {
            $now = Carbon::now()->format('H:i:s');
            $isOpenTime = $now >= $settingToday->open_time && $now <= $settingToday->close_time;
        }

        // Final status toko
        $isStoreOpen = $isOpenManual || $isOpenTime;

        // Logika menu
        if ($q !== '' && $category !== 'all') {
            return redirect()->route('menu.index', ['category' => 'all', 'q' => $q]);
        }

        $menusQuery = Menu::query()->where('availability', 'available');

        if ($q !== '' && $category === 'all') {
            $menusQuery->where(function ($s) use ($q) {
                $s->where('product_name', 'like', "%{$q}%")
                ->orWhere('type', 'like', "%{$q}%")
                ->orWhere('category', 'like', "%{$q}%");
            });
        } elseif ($category !== 'all') {
            $menusQuery->where('category', $category);
        }

        $menus = $menusQuery->orderBy('type')->get()->groupBy('type');

        return view('customer.pages.menu.index', compact('title', 'menus', 'category', 'q', 'isStoreOpen'));
    }
}
