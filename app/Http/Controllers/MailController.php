<?php

namespace App\Http\Controllers;


use App\Store;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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


public function send_contact_request($store_id,$product_id)

    {


        $store=Store::findOrFail($store_id);

        $vendor=Vendor::findOrFail($store->vendor_id);
     

        $user=User::findOrFail($vendor->user_id);
        $email=$user->email;


        $details = [
            'title' => 'Mail from takeascroll.com',
            'body' => 'This is a contact mail for your a product of your store'.'""'.$store->name.'""'.'for product ID:'.$product_id,
            'contact'=>'Contact-no:' .$user->contact_no .'      '.'email:' .$user->email
        ];

        Mail::to($email)->send(new \App\Mail\ContactMail($details));
        return back();
    }
}
