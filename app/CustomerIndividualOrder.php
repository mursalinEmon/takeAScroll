<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerIndividualOrder extends Model
{
    protected $guarded=[];

    protected $casts = [
        'customer_individual_orders' => 'array',
    ];
}
