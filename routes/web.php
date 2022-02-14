<?php

use App\Store;
use App\Category;
// use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    // return view('welcome');
//
//    return view('front-end.landing');
//});
Route::get('/','HomeController@landing')->name('landing');
Route::get('/contact','HomeController@contact_us')->name('contact');
Route::post('/contact/message','ContactController@store')->name('contact.store');


Auth::routes(['verify'=>true]);

//admin routes

Route::get('/create-category','CategoryController@create')->name('category.create');
Route::post('/create-category','CategoryController@store')->name('category.store');
Route::get('/categories/{category}/subcategory/create','SubCategoryController@create')->name('subcategory.create');
Route::post('/categories/{category}/subcategory/create','SubCategoryController@store')->name('subcategory.store');

Route::middleware(['verified','admin'])->group( function () {
    Route::get('/admin-dashboard', 'AdminProfileController@index')->name('admin.dashboard');
    Route::get('/order-notification/{order_id}/{noti_id}', 'DeliveryController@show_order');
    Route::post('/vendor-order','DeliveryController@process_vendor_order')->name('vendor.order');
    Route::get('/admin-product-list-update', 'AdminProfileController@update_product_list')->name('admin.update-list');




});
Route::get('/admin-recommendation-update', 'CustomerCartController@update_recommendation')->name('admin.update-recommendation');

Route::post('/markasdone','DeliveryController@markasdone');


Route::middleware(['verified','vendor'])->group( function () {
    Route::get('/vendor-dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/vendor-profile', 'VendorController@show_profile')->name('vendor_profile.show');
    Route::get('/edit-vendor-profile', 'VendorController@edit_profile')->name('vendor_profile.edit');
    //sore-routes
    Route::resource('stores', StoreController::class)->except('stores.update');

    Route::post('/stores/{store}','StoreController@update')->name('stores.update');


    // electronics pruducts
    Route::get('stores/{store}/product/create','ProductController@create')->name('product.create');
    Route::post('/stores/{store}/products','ProductController@store')->name('product.store');
    Route::post('/stores/{store}/products/cars','ProductController@store_cars')->name('product.store.cars');

    Route::get('stores/{store}/products','ProductController@index')->name('products.view');
    Route::delete('products/{product}','ProductController@destroy')->name('product.delete');
    Route::get('/products/{product}/edit','ProductController@edit')->name('product.edit');
    Route::post('/products/{product}/update','ProductController@update')->name('product.update');
    Route::post('/product-image','ProductController@store_product_image')->name('prodevt.image_upload');

    // car products
    Route::get('stores/{store}/product/create-car','ProductController@car_create')->name('cars.product.create');

    //realestate products

    Route::get('stores/{store}/realestate-product/create','ProductController@create_realestate_products')->name('product.realestate.create');
    Route::post('stores/{store}/realestate-product/store','ProductController@store_realestate_products')->name('product.realestate.store');
    // Route::get('categories/{category}/{sub_cat_name}/{sub_cat}','SubCategoryController@index')->name('category.realestate.index');

//    notificationstuff
    Route::get('/vendor-order-notification/{order_id}/{noti_id}', 'DeliveryController@show_vendor_order');
    Route::post('/vendor-order-update','DeliveryController@process_vendor_order_update')->name('vendor.order.update');





});

// customer routes
Route::middleware(['verified','customer'])->group( function () {
    Route::get('/customer-dashboard','CustomerProfileController@index')->name('customer.dashboard');
    Route::get('/customer-orders','CustomerProfileController@orders')->name('customer.orders');

    Route::get('/customer-profile', 'CustomerProfileController@show_profile')->name('customer_profile.show');
    Route::get('/edit-profile', 'CustomerProfileController@edit_profile')->name('customer_profile.edit');
    //cart
    Route::get('/cart','CartController@index')->name('cart.index');
    Route::get('/cart/products/{product}/add','CartController@add_to_cart')->name('cart.add');
    Route::get('/cart/realestates/{realestate}/add','CartController@add_to_cart_realestate')->name('cart.add.realestate');

    Route::get('/cart/remove/product/{id}','CartController@remove_item')->name('cart.remove');
    Route::get('/cart-restore','CartController@restore');
    Route::get('/cart-checkout/','CartController@checkout')->name('cart.checkout');
    Route::get('/cart/{item}/update/{qty}','CartController@update_cart');

    Route::get('/send-mail/{store_id}/{product_id}', 'MailController@send_contact_request')->name('contact.mail');
    Route::post('/checkout','SslCommerzPaymentController@index')->name('ssl.pay');
    Route::post('/checkout/pay_later','SslCommerzPaymentController@paylater')->name('ssl.pay_later');


    Route::post('/address-update','CustomerProfileController@address_update');
    Route::post('/product-rating','ProductRatingController@store');
    Route::get('/product-rating/{id}','ProductRatingController@check_rating');






});


// store routes for customer
Route::get('/stores/{store}/view','StoreController@show_customer')->name('customer.shop.show');



Route::get('/chat', 'HomeController@chat')->name('chat');
Route::get('/fetch-contacts','ChatController@contacts')->name('chat.contacts');
Route::get('/messages/{id}','ChatController@fetchMessages')->name('chat.messages');
Route::post('/message/send','ChatController@storeMessage')->name('chat.storemessage');
Route::get('/unread-message/count','ChatController@unreadcount')->name('chat.unreadcount');
Route::post('/unread-message/markasseen','ChatController@markasseen');




// category
Route::get('/categories','CategoryController@index')->name('product.categories');
Route::get('/categories/cars','CategoryController@cars')->name('product.categories.car');

Route::get('/sub-category/{name}','CategoryController@fetch_sub_category')->name('product.sub-categories');

Route::get('/test/{id}','ProductController@index');


Route::get('/notifications','DeliveryController@allnotifications');

//sub actegory or products


Route::get('categories/{category}/{sub_cat_name}/{sub_cat}/{qty}','SubCategoryController@index')->name('category.products.index');
Route::get('categories/{category}/{sub_cat_name}/{sub_cat}/products/{product}','SubCategoryController@show')->name('category.products.show');
Route::get('categories/{category}/{sub_cat_name}/{sub_cat}/realestates/{realestate}','SubCategoryController@show_realestate')->name('category.realestate.products.show');

//Profiles


Route::get('/logout', function () {
    //logout user
    Auth::logout();
    // redirect to homepage
    return redirect('/');
});



View::composer(['*'], function ($view) {

    $categories=Category::all();
    $cart=Cart::count();
    $electronics_shops=Store::where('type','electronics')->get();
    $realestate_shops=Store::where('type','realestate')->get();
    $cars_shops=Store::where('type','cars')->get();
    $category_type=['Electronics','Cars','Realestate'];
    // $shops=array(['Electronics'=>$electronics_shops,'Realestate'=>$realestate_shops,'Cars'=>$cars_shops]);
// dd($shops);
    $view->with(['categories'=>$categories,'cart'=>$cart,'Electronics'=>$electronics_shops,'Realestate'=>$realestate_shops,'Cars'=>$cars_shops,'category_type']);
});




// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');

Route::post('/pay', 'SslCommerzPaymentController@index');
Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn');

Route::post('/product/search','ProductController@search_product');
Route::get('/product-search/{catid}/{subcatir}/{pid}','ProductController@search_show');
//SSLCOMMERZ END
