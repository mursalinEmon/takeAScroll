<?php

namespace App;

use App\Product;
use App\Realestate;
use App\SubCategory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded=[];
    public function subCategories(){
        return $this->hasMany(SubCategory::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function realestates(){
        return $this->hasMany(Realestate::class);
    }

}
