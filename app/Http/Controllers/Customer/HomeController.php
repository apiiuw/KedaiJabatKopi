<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cart;

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

        return view('customer.pages.home.index', compact('title'));
    }
}
