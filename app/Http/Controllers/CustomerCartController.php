<?php

namespace App\Http\Controllers;

use App\CustomerCart;
use App\CustomerIndividualOrder;

use App\Product;
use Illuminate\Http\Request;
use DB;
use Cart;
use App\Orders;
use App\Http\Controllers\Odrer;
use Phpml\Association\Apriori;
// use Illuminate\Support\Facades\DB;



class CustomerCartController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerCart  $customerCart
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerCart $customerCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerCart  $customerCart
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerCart $customerCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerCart  $customerCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerCart $customerCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerCart  $customerCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerCart $customerCart)
    {
        //
    }

    public function update_recommendation(){
        // dd('Test');

        $carts = DB::table('shoppingcart')->get();

        foreach($carts as $cart){
            $temp_id = $cart->identifier;
            // $temp_id = substr($temp_id, 0, strpos($temp_id, "-"));
            // dd($temp_id);
            if(strpos($temp_id, '-') !== false){
                $user_identity = substr($temp_id, 0, strpos($temp_id, "-"));
            }else{

                $user_identity = $temp_id;
            }
            preg_match_all('!\d+!', $user_identity, $matches);

            $orders = Cart::stored_data($user_identity);
            // dd($orders);
            $orders_list=array();

            foreach($orders as $order){
                $products = $order->name;
                array_push($orders_list,$order->id);

            }
            // dd($orders_list);
            $u_id =$matches[0][0];
            // dd(CustomerCart::where('id',$u_id)->first());
            // dd($matches[0][0]);
            $customer_idividual_order=CustomerIndividualOrder::create([
                "user_id" => $u_id,
                "customer_individual_orders" => $orders_list
            ]);
            if(CustomerCart::where('user_id',$u_id)->first()!=null){
                $entry = CustomerCart::where('user_id',$u_id)->first();
                $old = $entry->customer_orders;
                array_merge($old,$orders_list);
                // array_unique($old);
                // dd($old);
                $entry->update([
                    "customer_orders" => $old
                ]);
            }else{
                // dd('test');
                $customer_cart=CustomerCart::create([
                    "user_id" => $u_id,
                    "customer_orders" => $orders_list
                ]);

            }

        }

        // dd($orders_list);
        $products = array();
        $allProducts = Product::get(['id','name']);
        foreach($allProducts as $product){
            $products[$product->id] = $product->name;
        }
        $orders = CustomerCart::get('customer_orders');
        $orderList = array();
        foreach($orders as $order){
            $temp = $order->customer_orders;
            // dd($temp);
            $temp_arr = array();
            foreach ($temp as $t) {

                foreach ($products as $key => $value) {
                    if ($t == $key) {
                        $t = $value;
                        array_push($temp_arr, $t);
                    }
                }
            }
            array_push($orderList, $temp_arr);
            // dd($orderList);
            $temp_arr = [];
        }
        // dd($orderList);


        $associator = new Apriori($support = 0.03, $confidence = 0.05);
        $samples = $orderList;

        $labels  = [];
        $associator->train($samples, $labels);

        $frequent = $associator->apriori();
        $recomendation = [];
        for ($i = 2; $i <= count($frequent); $i++) {
            $temp = $frequent[$i];
            foreach ($temp as $item) {
                array_push($recomendation, $item);
            }
        }
        // dd($recomendation);
        $purchased_product_names=[];
        $recomendation_for_you=[];
        $final_rec = [];
        $final_recomendation_list=[];
        $customer_orders = CustomerCart::where('user_id', auth()->user()->id)->get();
        $customer_orders = $customer_orders[0]->customer_orders;
        foreach ($customer_orders as $order) {
            $product_name = Product::findOrfail($order);
            array_push($purchased_product_names, $product_name->name);
        }
        // dd($purchased_product_names);

        foreach ($purchased_product_names as $product) {
            foreach ($recomendation as $rec) {
                // dd($rec);
                if (in_array($product, $rec)) {
                    array_push($recomendation_for_you, $rec);
                    // $recomendation_for_you=array_unique( $recomendation_for_you);
                }
            }
        }
        // dd($recomendation_for_you);
        foreach ($recomendation_for_you as $rec) {
            $final_rec = array_merge($final_rec, $rec);
        }
        $final_rec = array_unique($final_rec);

        // dd($final_rec);
        foreach ($purchased_product_names as $val) {
            if (($key = array_search($val, $final_rec)) !== false) {
                unset($final_rec[$key]);
            }
        }
        foreach ($final_rec as $rec) {
            $Products = Product::where('name', $rec)->get();
            array_push($final_recomendation_list, $Products);
        }

        dd($final_recomendation_list);
    }


}
