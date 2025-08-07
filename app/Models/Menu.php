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
        'description',
        'category',
        'type',
        'iced_hot',
        'sweetness',
        'espresso',
        'availability',
        'price',
        'picture',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_menu');
    }

}
