<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('id_order'); // ORDER-XXXX
            $table->string('id_menu'); // relasi ke menus.id_menu
            $table->string('category');
            $table->string('type')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // total (price x quantity)
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign key ke menus.id_menu
            $table->foreign('id_menu')->references('id_menu')->on('menus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
