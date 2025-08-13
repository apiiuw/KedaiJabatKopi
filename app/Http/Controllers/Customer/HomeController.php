<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\StoreStatus;
use App\Models\StoreSetting;

class HomeController extends Controller
{
    private function purgeCartOlderThanHour(): void
    {
        // pakai timezone app (set ke Asia/Jakarta di .env)
        $cutoff = now(config('app.timezone', 'Asia/Jakarta'))->subHour();

        // versi Eloquent (mudah dibaca)
        Cart::where('created_at', '<', $cutoff)->delete();

    }

    public function index()
    {
        $this->purgeCartOlderThanHour();
        $title = 'Home'; 

        // Ambil record store_status
        $storeStatus = StoreStatus::first();

        if ($storeStatus) {
            // Auto close jika updated_at lebih dari 1 hari
            if (Carbon::parse($storeStatus->updated_at)->lt(Carbon::now()->subDay())) {
                $storeStatus->update(['is_open' => 0]);
            }

            // Ambil pengaturan hari ini
            $today = strtolower(Carbon::now()->format('l'));
            $settingToday = StoreSetting::where('day', $today)->first();

            // Cek apakah hari ini aktif
            if ($settingToday && $settingToday->is_active == 1) {
                $now = Carbon::now()->format('H:i:s');

                if ($now >= $settingToday->open_time && $now <= $settingToday->close_time) {
                    // Auto buka jika di jam operasional
                    if ($storeStatus->is_open == 0) {
                        $storeStatus->update(['is_open' => 1]);
                    }
                } else {
                    // Auto tutup jika di luar jam operasional
                    if ($storeStatus->is_open == 1) {
                        $storeStatus->update(['is_open' => 0]);
                    }
                }
            } else {
                // Kalau hari ini tidak aktif → tutup
                if ($storeStatus->is_open == 1) {
                    $storeStatus->update(['is_open' => 0]);
                }
            }
        }

        $isStoreOpen = $storeStatus && $storeStatus->is_open == 1;

        return view('customer.pages.home.index', compact('title', 'isStoreOpen'));
    }

}
