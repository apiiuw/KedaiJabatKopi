<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'day', 'open_time', 'close_time', 'is_active'
    ];
}
