<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id_order',
        'id_user',
        'name',
        'email',
        'order_type',
        'table_number',
        'total_amount',
        'status',
        'queue_number',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }
}
