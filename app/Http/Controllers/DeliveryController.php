<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\Events\DeliveryEvent;
use App\Notifications\DeliveryRequest;
use App\Odrer;
use App\Product;
use App\Store;
use App\VendorOrder;
use Auth;
use App\User;
use Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function markasdone(Request $request){
        $notifications=auth()->user()->notifications;
        foreach ($notifications as $noti){
            if($noti->id == $request->noti_id){
                $noti->markAsRead();
            }
        }
    }
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
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }
    public function show_order($order_id,$noti_id){
        $order = DB::table('orders')
            ->where('id',$order_id)->get();
        $order=$order[0];
        $cart=Cart::stored_data($order->cart_identifier);

        $stores=[];
        foreach ($cart as $row){
            array_push($stores,$row->model->store_id);
        }
        $stores=array_unique($stores);

        $store_wise_row=[];
       foreach ($stores as $store){
           $prodcts=[];
           foreach ($cart as $row){
               if($row->model->store_id == $store){
                   array_push($prodcts,$row);
               }else{

               }

           }
           $store_wise_row[$store]=$prodcts;
       }

       return view('Orders.adminOrder',compact('store_wise_row','order','noti_id'));
    }


    public function show_vendor_order($order_id,$noti_id){
       $od= DB::table('orders')
            ->where('id',$order_id)->get();
       $status=$od[0]->status;
       $tid=$od[0]->transaction_id	;
        $store=Store::where('vendor_id',auth()->user()->id)->get();
        $store_id=$store[0]->id;
        $store_name=$store[0]->name;
        $vorder=VendorOrder::where('order_id',$order_id)->where('store_id',$store_id)->get();
        $orders=[];
        foreach ($vorder as $order){
            $data=[];
            $product=Product::findOrFail($order->product_id);
           $data['product']=$product;
           $data['qty']=$order->qty;
           $data['tid']=$order->tid;
           array_push($orders,$data);
        }

       return view('Orders.vendorOrder',compact('orders','store_name','status','noti_id','tid','order_id'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
    public function allnotifications(){
        $data=[];
        $user =auth()->user();

        foreach ($user->unreadNotifications as $notification) {
            $p= $notification->data['order_id'];
            $order=DB::table('orders')
                ->where('id',$p)->get();

           if($order->count()>0){
               $order=$order[0];
               $stat=$order->status;
               $amount=$order->amount;
               $tid=$order->transaction_id;
               $user=User::where('email',$order->email)->get();
            $user=$user[0];
//            dd($user);
               array_push($data,[
                   'stat'=>$stat,
                   'amount'=>$amount,
                   'tid'=>$tid,
                   'cus'=>$user,
                   'order_id'=>$order->id,
                   'noti_id'=>$notification->id
               ]);
           }

        }
        return response(['notifications'=>$data]) ;
    }


    public function process_vendor_order(Request $request){
        $order = DB::table('orders')
            ->where('id',$request->order_id)->get();
        $order=$order[0];
        $cart=Cart::stored_data($order->cart_identifier);
        $stores=[];
        foreach ($cart as $row){
            array_push($stores,$row->model->store_id);
        }
        $stores=array_unique($stores);
        $store_wise_row=[];
        foreach ($stores as $store){
            $prodcts=[];
            foreach ($cart as $row){
                if($row->model->store_id == $store){
                    array_push($prodcts,$row);
                }else{

                }
            }
            $store_wise_row[$store]=$prodcts;
        }

       foreach ($store_wise_row as $key=>$value){
           foreach ($value as $row){

             VendorOrder::create([
                 'store_id'=>$key,
                 'order_id'=>$order->id,
                 'product_id'=>$row->model->id,
                 'qty'=>$row->qty,
                 'price'=>$row->model->price+0.00,
                 'tid'=>$order->transaction_id,
             ]);

           }

           $store=Store::findOrFail($key);


           Delivery::where('order_id',$order->id)->update([
                'delivery_status'=>'at Vendor'
            ]);
           $delivery = Delivery::where('order_id',$order->id)->get();
           $user=User::findOrFail($store->vendor_id);
           $user->notify((new DeliveryRequest($delivery[0])));
           broadcast(new DeliveryEvent($user))->toOthers();
       }

       return redirect()->route('admin.dashboard');
    }



    public function process_vendor_order_update(Request $request){
        $delivery=Delivery::where('order_id',$request->oreder_id)->get();
        $delivery=$delivery[0];
        $delivery->update([
            'delivery_status'=>'In Shipping',
        ]);
        return redirect()->route('dashboard');
    }


}
