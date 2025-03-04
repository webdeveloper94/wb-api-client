<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];
    
    protected $attributes = [
        'is_supply' => false,
        'is_realization' => false,
        'is_storno' => 0,
    ];
    
    protected $casts = [
        'total_price' => 'float',
        'discount_percent' => 'float',
        'is_supply' => 'boolean',
        'is_realization' => 'boolean',
        'for_pay' => 'float',
        'finished_price' => 'float',
        'price_with_disc' => 'float',
        'is_storno' => 'integer',
    ];
}
