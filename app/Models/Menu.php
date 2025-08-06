<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_menu',
        'product_name',
        'category',
        'type',
        'sweetness',
        'espresso',
        'availability',
        'price',
        'picture',
    ];
}
