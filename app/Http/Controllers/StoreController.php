<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores=Store::all()->where('vendor_id',auth()->user()->id);

        return view('vendor.store.store_list',compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.store.create_store');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // $table->string('banner');

    public function store(Request $request)
    {
        $image="";
        $st=Store::where('vendor_id',auth()->user()->id)->where('type',$request->type)->get();

        if($st->count()!=0){
            return response(['message'=>'you already have a store in this type can\' create a new one..!!!','store'=>null]);
        }else{
            $store=Store::create([
                'name'=>$request->store_name,
                'vendor_id'=>auth()->user()->id,
                'physical_Address'=>$request->physical_Address,
                'type'=>$request->type,
                'vendor_NID'=>$request->vendor_NID,
                'description'=>$request->description,
                'banner'=>$image,
            ]);

            if($request->file('file')){
                $image = $request->file;
                $imagePath = $request->file('file');
                $imageName= time().'.'.$imagePath->getClientOriginalExtension();
                $image->move(public_path('image/'.auth()->user()->name.'/'.$store->name.'/'),$imageName);
            }


            $store->update([
                'banner'=>'image/'.auth()->user()->name.'/'.$store->name.'/'.$imageName,
            ]);
            return response(['message'=>'Store Created Successfully..!!!','store'=>$store]);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        // dd($store);
        return view('vendor.store.store_dashboard',compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {

        return view('vendor.store.edit_store',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {


        $banner=$store->banner;
        $image="";
        if($request->file('file')){

            $image = $request->file;
            $imagePath = $request->file('file');
            $imageName= time().'.'.$imagePath->getClientOriginalExtension();
            $image->move(public_path('image/'.auth()->user()->name.'/'.$store->name.'/'),$imageName);
            Storage::delete(public_path($banner));
            $banner='image/'.auth()->user()->name.'/'.$store->name.'/'.$imageName;
        }
        $store_name=$request->store_name ?$request->store_name:$store->store_name;
        $physical_Address=$request->physical_Address?$request->physical_Address:$store->physical_Address;
        $type=$request->type?$request->type:$store->type;
        $vendor_NID=$request->vendor_NID?$request->vendor_NID:$store->vendor_NID;
        $description=$request->description?$request->description:$store->description;
        $store->update([
            'name'=>  $store_name,
            'vendor_id'=>auth()->user()->id,
            'physical_Address'=>$physical_Address,
            'type'=>$type,
            'vendor_NID'=>$vendor_NID,
            'description'=>  $description,
            'banner'=>$banner,
        ]);
        return response(['message'=>'Info Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();
        return back()->with(['message'=>'Store Deleted Sucesfully..!']);
    }
    public function show_customer(Store $store){
        return view('front-end.store.show',compact('store'));
    }
}
