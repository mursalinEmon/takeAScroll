<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all();
        return response(['categories'=>$categories]);
    }
    public function cars(){
        $categories=Category::all()->where('categoryType','cars');
        return response(['categories'=>$categories]);
    }
    public function create(){
        return view('admin.create_category');
    }
    public function store(Request $request){

        $category = Category::create([
            "name"=>$request->cat_name,
            "description"=>$request->cat_description,
            "categoryType"=>$request->category_type,
        ]);
        return response(['message'=>'Category created successfully!','category'=> $category]);
    }
    public function fetch_sub_category($name){
        // dd($name);
        $category=Category::where('name',$name)->get('id')->first();

        $sub_categories=SubCategory::where('category_id',$category->id)->get();


        return response(['sub_categories'=>$sub_categories,'category_id'=>$category->id]);
    }
}
