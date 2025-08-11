<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_expense', function (Blueprint $table) {
            $table->id();
            $table->string('id_category_expense')->unique();
            $table->string('category');
            $table->string('item_name');
            $table->decimal('price', 15, 2);
            $table->enum('status', ['Active', 'Deactive']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_expense');
    }
};
