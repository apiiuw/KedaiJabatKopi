<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('id_menu')->unique();
            $table->string('product_name');
            $table->string('category'); // Drink / Food
            $table->string('type')->nullable(); // Coffee / Snack / etc
            $table->boolean('sweetness')->default(false);
            $table->boolean('espresso')->default(false);
            $table->string('availability'); // Available / Sold Out
            $table->integer('price');
            $table->string('picture')->nullable(); // path file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
