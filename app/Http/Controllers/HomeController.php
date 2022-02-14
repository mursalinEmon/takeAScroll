<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductSellCount;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product_count=Product::all()->where('vendor_id',auth()->user()->id)->count();
        return view('vendor.vendor_dashboard',compact('product_count'));
    }
    public function chat(){
        return view('chat.chat');
    }
    public  function landing(){
//        featured
        $fts=Product::where('featured','yes')->get();
//        best sellers
        $bsts=[];
        $ts=ProductSellCount::orderBy('sell_count', 'DESC')->take(15)->get();
        foreach($ts as $t){
            $temp=Product::findOrFail($t->product_id);
            array_push($bsts,$temp);
        }
        $bsds=Product::where('discount','>',0)->limit(10)->get();

        return view('front-end.landing',compact('fts','bsts','bsds'));
    }

    public function contact_us(){
        return view('layouts.front-end.contact');
    }
}
