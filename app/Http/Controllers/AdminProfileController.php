<?php

namespace App\Http\Controllers;

use App\AdminProfile;
use App\ProductSellCount;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Cart;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.admin_dashboard');
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
     * @param  \App\AdminProfile  $adminProfile
     * @return \Illuminate\Http\Response
     */
    public function show(AdminProfile $adminProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminProfile  $adminProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminProfile $adminProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminProfile  $adminProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminProfile $adminProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminProfile  $adminProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminProfile $adminProfile)
    {
        //
    }
    public function update_product_list(){
        $orders=DB::table('orders')->get();
        $product_count=[];
        foreach($orders as $order ){
            $cart_identifier=$order->cart_identifier;
            $cart=Cart::stored_data($cart_identifier);
            foreach($cart as $row){
                $id=$row->id;
                $qty=$row->qty;
                if(count($product_count)>0){
                    foreach($product_count as $key=>$value){
                        if($key==$id){
                            $product_count[$id]=$value+$qty;
                        }else{
                            $product_count[$id]=$qty;
                        }
                    }
                }else{
                    $product_count[$id]=$qty;
                }
            }

        }
        ProductSellCount::truncate();
        foreach($product_count as $key=>$value){
            ProductSellCount::create([
                'product_id'=>$key,
                'sell_count'=>$value
            ]);
        }
        return redirect()->back()->with(['message'=>'successfully updated..!!','stat'=>'success']);
    }
}
