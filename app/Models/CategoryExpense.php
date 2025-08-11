<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryExpense extends Model
{
    protected $table = 'category_expense';

    protected $fillable = [
        'id_category_expense',
        'category',
        'item_name',
        'price',
        'status',
    ];
}
