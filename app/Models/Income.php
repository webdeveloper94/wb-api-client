<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'income_id' => 'integer',
        'quantity' => 'integer',
        'total_price' => 'float',
        'nm_id' => 'integer',
    ];
}
