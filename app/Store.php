<?php

namespace App;

use App\User;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Store extends Model
{
    protected $guarded=[];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'products_id' => 'array',
    ];

    public function user(){
        return $this->belogsTo(User::class);
    }
    public function products(){

        return $this->hasMany(Product::class,'store_id','id');
    }
    public function realestates(){

        return $this->hasMany(Realestate::class,'store_id','id');
    }
}
