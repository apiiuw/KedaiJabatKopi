<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreStatus extends Model
{
    protected $table = 'store_status'; // tambahkan ini

    protected $fillable = ['is_open'];
}
