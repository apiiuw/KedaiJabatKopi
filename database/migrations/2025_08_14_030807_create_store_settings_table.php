<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('day')->unique(); // monday, tuesday, ...
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Status toko disimpan terpisah supaya bisa cepat diakses
        Schema::create('store_status', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });

        // Insert data awal
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        foreach ($days as $day) {
            DB::table('store_settings')->insert([
                'day' => $day,
                'open_time' => '08:00',
                'close_time' => '17:00',
                'is_active' => $day != 'sunday',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::table('store_status')->insert([
            'is_open' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
        Schema::dropIfExists('store_status');
    }
};
