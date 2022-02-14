<?php

namespace App\Http\Controllers;

use Cart;
use App\Product;
// use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CustomerProfile;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indentity = Session::get('unique'.auth()->user()->id);
        // dd($indentity);
        $cart=Cart::content();
        // $cart=Cart::instance(auth()->user()->id);
        // dd($cart);
        $address = CustomerProfile::where('user_id',auth()->user()->id)->get();
        //    dd();
        $address=$address[0]->address;
        return view('cart.cart_view',compact('cart','address'));
        // return view('cart.cart_view','cart');
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
    public function restore(){

        Cart::destroy();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
    public function add_to_cart(Request $request, Product $product){



        $product=[
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 550,
        ];
    $cartItem=Cart::add($product);
    $cartItem->associate('App\Product');

    // $cart=Cart::content();
    // dd($indentity);
    $indentity = Session::get('unique'.auth()->user()->id);
    // dd($indentity);
    $exist=DB::table('shoppingcart')
        ->where('identifier',$indentity)->get();
        if($exist->count()>0){
            DB::table('shoppingcart')
                ->where('identifier',$indentity)->delete();
            Cart::store( $indentity);
    }else{
        // dd('Testestron');
        Cart::store($indentity);

    }


    return response(['message' => "product added to the cart"]);
    }

    public function remove_item($id){
        // $content = Cart::content();
        // dd($content); foreach($content as $item){ if($item->rowId == $id){ Cart::remove($id); }; }
        // dd($id);
        Cart::remove($id);
        // dd(Cart::content());
        // $indentity=auth()->user()->name.auth()->user()->id;
        $indentity = Session::get('unique'.auth()->user()->id);


        // Cart::restore($indentity);
        // dd($indentity);
        // Cart::update($indentity);
        return response(['message' => "Product removed from the cart"]);
    }

    public function checkout(){
        // dd($address);
        return view('cart.checkOut');
    }

    public function update_cart($item,$qty){
            // dd($item,$qty);
        Cart::update($item, $qty);
        // $indentity=auth()->user()->name.auth()->user()->id;
        $indentity = Session::get('unique'.auth()->user()->id);

        Cart::restore($indentity);
        Cart::store( $indentity);
        // dd(Cart::content());
        return response(['message'=>'Product Quantity Updated']);
    }


    public function stored_data($identifier)
    {
        if ($identifier instanceof InstanceIdentifier) {
            $identifier = $identifier->getInstanceIdentifier();
        }

        $currentInstance = $this->currentInstance();

        if (!$this->storedCartInstanceWithIdentifierExists($currentInstance, $identifier)) {
            return;
        }

        $stored = $this->getConnection()->table($this->getTableName())
            ->where(['identifier'=> $identifier, 'instance' => $currentInstance])->first();

        $storedContent = unserialize(data_get($stored, 'content'));

        $this->instance(data_get($stored, 'instance'));

        $content = $this->getContent();

        foreach ($storedContent as $cartItem) {
            $content->put($cartItem->rowId, $cartItem);
        }

        $this->events->dispatch('cart.restored');
        $this->session->put($this->instance, $content);

        $this->instance($currentInstance);

        $this->createdAt = Carbon::parse(data_get($stored, 'created_at'));
        $this->updatedAt = Carbon::parse(data_get($stored, 'updated_at'));

      $data= $this->getConnection()->table($this->getTableName())->where(['identifier' => $identifier, 'instance' => $currentInstance])->get();
        return $storedContent;
    }
}
