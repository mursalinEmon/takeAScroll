<?php

namespace App;

use App\Store;
use App\Category;
use App\SubCategory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=[];
    protected $casts = [
        'product_pictures' => 'array',
        'product_tags' => 'array'
    ];
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }
}
