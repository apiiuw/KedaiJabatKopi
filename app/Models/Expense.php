<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'id_expenses', 'category', 'item', 'price', 'amount', 'qty', 'description'
    ];

    public function categoryExpense()
    {
        return $this->belongsTo(CategoryExpense::class);
    }

}
