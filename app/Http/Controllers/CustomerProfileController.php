<?php

namespace App\Http\Controllers;

use App\CustomerProfile;
use App\Delivery;
use App\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $customer=User::where('id',auth()->user()->id)->get();

        $orders=DB::table('orders')
            ->where('email',$customer[0]->email)->get();
        $order_count=$orders->count() ;
        return view('customer.customer_dashboard',compact('customer','order_count'));

    }

    public function orders(){
        $orders=DB::table('orders')
            ->where('email',auth()->user()->email)->orderBy('created_at', 'desc')->get();
            $carts=[];
            $deliveries=[];
        foreach ($orders as $order){
            $cart=Cart::stored_data($order->cart_identifier);
            $carts[$order->id]=$cart;
            $delivery=Delivery::where('order_id',$order->id)->get();

            $temp=$delivery[0];

            $deliveries[$order->id]=$temp;
        }

        return view('customer.orders',compact('orders','carts','deliveries'));


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
     * @param  \App\CustomerProfile  $customerProfile
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerProfile $customerProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerProfile  $customerProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerProfile $customerProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerProfile  $customerProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerProfile $customerProfile)
    {
        //
    }

    public function address_update(Request $request){
        $profile=CustomerProfile::where('user_id',auth()->user()->id)->get();
//        dd($profile);
        $profile=$profile[0];
        $profile->update([
            'address'=>$request->address,
        ]);
        return response(['messgage'=>'updated successfully..!!']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerProfile  $customerProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerProfile $customerProfile)
    {
        //
    }
    public function show_profile(){
        //$id=auth()->user()->id;
        $userData=User::where('id',auth()->user()->id)->get();
        return view('front-end.profile-view.profile_view',compact('userData'));
        //dd($vendor);

    }

    public function edit_profile(){
        //$id=auth()->user()->id;
        $userData=User::where('id',auth()->user()->id)->get();
        return view('front-end.profile-view.edit_profile',compact('userData'));
        //dd($vendor);

    }
}
