<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (session()->has('id_user')) {
                $cartCount = Cart::where('id_user', session('id_user'))->count();
            }

            $view->with('cartCount', $cartCount);
        });

        // Bagikan count order paid ke semua view yang ada di folder cashier
        View::composer('cashier.*', function ($view) {
            $countPaid = Order::where('status', 'paid')->count();
            $view->with('countPaid', $countPaid);
        });
    }

}
