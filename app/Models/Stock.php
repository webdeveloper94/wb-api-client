<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id'];
    
    protected $attributes = [
        'is_supply' => false,
        'is_realization' => false,
    ];
    
    protected $casts = [
        'quantity' => 'integer',
        'is_supply' => 'boolean',
        'is_realization' => 'boolean',
        'quantity_full' => 'integer',
        'in_way_to_client' => 'integer',
        'in_way_from_client' => 'integer',
        'nm_id' => 'integer',
        'price' => 'float',
        'discount' => 'float',
    ];
}
