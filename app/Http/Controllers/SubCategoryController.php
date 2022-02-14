<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Realestate;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category , $sub_cat_name,$sub_cat,$qty)

    {
        if($category->categoryType==="RealEstate"){
            $products=Realestate::where('sub_category_id',$sub_cat)->paginate($qty);

            return view('front-end.product-view.realestateProductsView',compact('products','sub_cat_name','qty'));

        }
        else{
            $products=Product::where('sub_category_id',$sub_cat)->paginate($qty);
//            dd($products);
            return view('front-end.product-view.productsView',compact('products','sub_cat_name','qty'));


        }
        // dd($products);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        return view('admin.create_subcategory',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Category $category, Request $request)
    {
        SubCategory::create([
            "name"=>$request->sub_cat_name,
            "decsription"=>$request->sub_cat_description,
            "category_id"=>$category->id
        ]);

        return response(["message"=>"SubCategory created succesfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category,$sub_cat_name,$sub_cat,Product $product)
    {


        return view('front-end.product-view.productView',compact('product','sub_cat_name'));
    }
    public function show_realestate(Category $category,$sub_cat_name,$sub_cat,Realestate $realestate)
    {
                $product=$realestate;


        return view('front-end.product-view.productView',compact('product','sub_cat_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
