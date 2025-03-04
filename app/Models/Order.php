<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    
    protected $attributes = [
        'is_cancel' => false,
    ];
    
    protected $casts = [
        'total_price' => 'float',
        'discount_percent' => 'float',
        'income_id' => 'integer',
        'nm_id' => 'integer',
        'is_cancel' => 'boolean',
    ];
}
