<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCart extends Model
{
    protected $guarded=[];

    protected $casts = [
        'customer_orders' => 'array',
    ];
}
