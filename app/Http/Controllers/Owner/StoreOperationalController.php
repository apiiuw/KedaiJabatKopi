<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Models\StoreStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StoreOperationalController extends Controller
{
    public function index()
    {
        $title = 'Store Operational Schedule';

        // Ambil status store
        $status = StoreStatus::first();

        if ($status) {
            // Auto close jika updated_at lebih dari 1 hari
            if (Carbon::parse($status->updated_at)->lt(Carbon::now()->subDay())) {
                $status->update(['is_open' => 0]);
            }

            // Ambil setting hari ini
            $today = strtolower(Carbon::now()->format('l'));
            $settingToday = StoreSetting::where('day', $today)->first();

            if ($settingToday && $settingToday->is_active == 1) {
                // Hari ini aktif → cek jam operasional
                $now = Carbon::now()->format('H:i:s');

                if ($now >= $settingToday->open_time && $now <= $settingToday->close_time) {
                    // Auto buka
                    if ($status->is_open == 0) {
                        $status->update(['is_open' => 1]);
                    }
                } else {
                    // Auto tutup
                    if ($status->is_open == 1) {
                        $status->update(['is_open' => 0]);
                    }
                }
            } else {
                // Hari ini tidak aktif → auto tutup
                if ($status->is_open == 1) {
                    $status->update(['is_open' => 0]);
                }
            }
        }

        $is_open = $status ? $status->is_open : false;

        $days = StoreSetting::orderByRaw("
            FIELD(day, 'monday','tuesday','wednesday','thursday','friday','saturday','sunday')
        ")->get()->map(function ($item) {
            return [
                'key'    => $item->day,
                'name'   => ucfirst($item->day),
                'open'   => $item->open_time,
                'close'  => $item->close_time,
                'active' => $item->is_active,
            ];
        });

        return view('owner.pages.store-operational.index', compact(
            'title', 'is_open', 'days'
        ));
    }

    public function updateSchedule(Request $request)
    {
        foreach ($request->schedule as $dayKey => $data) {
            StoreSetting::where('day', $dayKey)->update([
                'open_time' => $data['open'] ?? null,
                'close_time' => $data['close'] ?? null,
                'is_active' => isset($data['active']) ? 1 : 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated successfully!'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $status = $request->input('is_open');

        \App\Models\StoreStatus::updateOrCreate(
            ['id' => 1], // kalau cuma satu toko
            ['is_open' => $status]
        );

        return response()->json([
            'success' => true,
            'message' => $request->is_open ? 'Store is now open' : 'Store is now closed'
        ]);
    }

}
