<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function products(){
        return $this->hasMany(Product::class);
    }

}
