<?php

namespace App\Http\Controllers;

use App\ProductRating;
use Illuminate\Http\Request;

class ProductRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      ProductRating::create([
         'user_id'=>auth()->user()->id,
          'product_id'=>$request->product_id,
          'rating'=>$request->rating
      ]);
      return response(['message'=>'You FeedBack Has Been Recorded..!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRating $productRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRating $productRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRating $productRating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRating $productRating)
    {
        //
    }
    public function check_rating($id){
        $stat=true;
        $pr=ProductRating::where('product_id',$id)->where('user_id',auth()->user()->id)->get();
        if($pr->count()>0){
            $stat=false;
        }
        return response(['stat'=>$stat]);

    }
}
