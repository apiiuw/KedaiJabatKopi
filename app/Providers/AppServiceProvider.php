<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Expense;
use App\Models\StoreStatus;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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

        View::composer('cashier.*', function ($view) {
            $countPaid = Order::where('status', 'paid')
                ->whereDate('created_at', Carbon::today())
                ->count();

            $view->with('countPaid', $countPaid);
        });

        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->role === 'owner') {
                $todayExpenseCount = Expense::whereDate('created_at', Carbon::today())->count();
                $view->with('todayExpenseCount', $todayExpenseCount);
            }
        });

        // Share $isStoreOpen ke semua view
        View::composer('*', function ($view) {
            $storeStatus = StoreStatus::first();
            $isStoreOpen = false;

            if ($storeStatus) {
                // Auto close jika updated_at lebih dari 1 hari
                if (Carbon::parse($storeStatus->updated_at)->lt(Carbon::now()->subDay())) {
                    $storeStatus->update(['is_open' => 0]);
                }

                // Ambil pengaturan hari ini
                $today = strtolower(Carbon::now()->format('l'));
                $settingToday = StoreSetting::where('day', $today)->first();

                if ($settingToday && $settingToday->is_active == 1) {
                    $now = Carbon::now()->format('H:i:s');

                    if ($now >= $settingToday->open_time && $now <= $settingToday->close_time) {
                        if ($storeStatus->is_open == 0) {
                            $storeStatus->update(['is_open' => 1]);
                        }
                    } else {
                        if ($storeStatus->is_open == 1) {
                            $storeStatus->update(['is_open' => 0]);
                        }
                    }
                } else {
                    if ($storeStatus->is_open == 1) {
                        $storeStatus->update(['is_open' => 0]);
                    }
                }

                $isStoreOpen = $storeStatus->is_open == 1;
            }

            $view->with('isStoreOpen', $isStoreOpen);
        });
    }

}
