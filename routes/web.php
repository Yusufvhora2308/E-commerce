<?php

use App\Http\Controllers\Aboutcontroller;
use App\Http\Controllers\Adminaddcategory;
use App\Http\Controllers\Adminbrandcontroller;
use App\Http\Controllers\Adminorderdetail;
use App\Http\Controllers\Adminproudctcontroller;
use App\Http\Controllers\Adminsettingcontroller;
use App\Http\Controllers\Adminusercontrller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Checkoutcontroller;
use App\Http\Controllers\Contactcontroller;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\forgetpassword;
use App\Http\Controllers\Profilecontroller;
use App\Http\Controllers\ShippingChargeController;
use App\Http\Controllers\Userorderdetail;
use Illuminate\Support\Facades\Route;

use App\Models\Otp;

use Illuminate\Http\Request;

use App\Http\Controllers\Logincontroller;

use App\Http\Controllers\adminlogin;

use App\Http\Controllers\admindashboard;

use App\Http\Controllers\dashboard;

use App\Http\Controllers\Shopcontroller;

use App\Http\Controllers\WishlistController;


//ID:      rzp_test_Ryd0PIp49fcWus

//TEST KEY SECRET         DVSHbnHlwBTXu9AYIJG7fkMy

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

Route::get('/',function(){
    return view('register');
});

Route::prefix('account')->group(function(){

    Route::group(['middleware'=>'guest'],function(){
        Route::get('login',[Logincontroller::class,'index'])->name('account.login');

             Route::get('/register',[Logincontroller::class,'register'])->name('account.register');

        Route::POST('register',[Logincontroller::class,'proccessregister'])->name('account.proccessregister');

        Route::POST('authenicate',[Logincontroller::class,'authenicate'])->name('account.authenicate');

        Route::get('/forgot-password', [forgetpassword::class,'emailForm'])->name('password.forgot');
Route::post('/forgot-password', [forgetpassword::class,'generateOtp'])->name('password.generateOtp');

Route::post('/verify-otp', [forgetpassword::class,'verifyOtp'])->name('password.verifyOtp');

Route::post('/reset-password', [forgetpassword::class,'resetPassword'])->name('password.reset');

Route::get('/reset-password', [forgetpassword::class, 'showResetForm'])
    ->name('password.reset.form');


    });

    Route::group(['middleware' => 'auth'],function(){
        
        
        Route::get('logout',[Logincontroller::class,'logout'])->name('account.logout');
        
        Route::get('dashboard',[dashboard::class,'dashboard'])->name('account.dashboard');

        Route::get('/product/{id}', [dashboard::class, 'show'])->name('product.show');


     Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::post('/cart/increment/{id}', [CartController::class, 'increment'])->name('cart.increment');

Route::post('/cart/decrement/{id}', [CartController::class, 'decrement'])->name('cart.decrement');

Route::delete('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');



  Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');

    // Show wishlist page
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // Remove from wishlist
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');



        Route::get('checkout',[Checkoutcontroller::class,'checkout'])->name('checkout');

        Route::POST('checkout/place', [Checkoutcontroller::class, 'placeOrder'])->name('checkout.place');

        Route::get('order/bill/{id}', [Checkoutcontroller::class, 'bill'])->name('order.bill');


        Route::get('/shop', [ShopController::class, 'index'])->name('shop');

        Route::Get('Aboutus',[Aboutcontroller::class,'index'])->name('Aboutus');

        Route::get('Contact',[Contactcontroller::class,'index'])->name('Contact');

        Route::post('/contactinfo', [ContactController::class, 'submit'])->name('contact.submit');

        Route::get('Userprofile',[Profilecontroller::class,'index'])->name('Profile');

        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('Userchangepass',[Profilecontroller::class,'changepass'])->name('profile.password');

        Route::post('/change-password', [Profilecontroller::class, 'updatePassword'])->name('profile.updatePassword');


        Route::get('User/orders',[Userorderdetail::class,'index'])->name('userorder.detail');

        
    });
});

Route::prefix('admin')->group( function(){

    Route::group(['middleware'=>'adminguest'],function(){
        
        Route::get('login',[adminlogin::class,'index'])->name('admin.login');

        Route::POST('authenicate',[adminlogin::class,'authenicate'])->name('admin.authenicate');
    });

    Route::group(['middleware' => 'adminauth'],function(){
        
        Route::get('dashboard',[admindashboard::class,'index'])->name('admin.dashboard');


        Route::get('addproduct',[Adminproudctcontroller::class,'addproduct'])->name('admin.addproduct');

        Route::POST('productstore',[Adminproudctcontroller::class,'store'])->name('admin.productstore');

        Route::get('showproduct',[Adminproudctcontroller::class,'showproduct'])->name('admin.showproduct');

        Route::get('products/{product}/edit', [Adminproudctcontroller::class,'edit'])->name('products.edit');

        Route::put('update-product/{id}', [Adminproudctcontroller::class, 'updateproduct'])->name('products.update');

         Route::delete('delete-product/{id}', [Adminproudctcontroller::class, 'deleteproduct'])->name('products.delete');


        Route::delete('product-image/{id}', [Adminproudctcontroller::class, 'deleteImage'])->name('product.image.delete');



       
        Route::get('brand',[Adminbrandcontroller::class,'index'])->name('admin.brand');

        Route::POST('brandvalidate',[Adminbrandcontroller::class,'brandvalidate'])->name('admin.brandvalidate');

        Route::get('showbrand',[Adminbrandcontroller::class,'showbrand'])->name('admin.showbrand');

        Route::get('/admin/brand/edit/{id}', [Adminbrandcontroller::class, 'edit'])->name('admin.brand.edit');

        Route::post('/admin/brand/update/{id}', [Adminbrandcontroller::class, 'update'])->name('admin.brand.update');

        Route::delete('/admin/brand/delete/{id}', [Adminbrandcontroller::class, 'delete'])->name('admin.brand.delete');


        Route::get('addcategory',[Adminaddcategory::class,'addcategory'])->name('admin.category');

        Route::post('/admin/category', [Adminaddcategory::class, 'store'])->name('admin.categorystore');

        Route::get('showcategory',[Adminaddcategory::class,'showcategory'])->name('admin.showcategory');

        Route::get('/category/edit/{id}', [Adminaddcategory::class, 'edit'])->name('admin.category.edit');

        Route::post('/category/update/{id}', [Adminaddcategory::class, 'update'])->name('admin.category.update');

        Route::delete('/category/delete/{id}', [Adminaddcategory::class, 'destroy'])->name('admin.category.delete');


        Route::get('Userdetail', [Adminusercontrller::class, 'User'])->name('admin.userdetail');

        Route::get('/admin/users/edit/{id}', [Adminusercontrller::class, 'edit'])->name('admin.user.edit');

        Route::post('/admin/users/update/{id}', [Adminusercontrller::class, 'update'])->name('admin.user.update');

        Route::get('/admin/users/delete/{id}', [Adminusercontrller::class, 'delete'])->name('admin.user.delete');

        Route::get('/admin/user/status/{id}', [Adminusercontrller::class, 'changeStatus'])
     ->name('admin.user.status');

        // Show single user details
Route::get('/admin/user/view/{id}', [Adminusercontrller::class, 'view'])
    ->name('admin.user.view');



        Route::get('/admin/setting', [Adminsettingcontroller::class, 'index']) ->name('admin.setting');

        Route::post('/admin/change-password', [Adminsettingcontroller::class, 'update']) ->name('admin.setting.update');

// ORDER ROUTES
Route::get('/admin/orders', [Adminorderdetail::class, 'index'])->name('admin.orders');

Route::get('/admin/order/bill/{id}', [Adminorderdetail::class, 'billview'])->name('admin.order.bill');
Route::get('/admin/order/bill/download/{id}', [Adminorderdetail::class, 'billPDF'])->name('admin.order.billPDF');

Route::get('/admin/order/accept/{id}', [Adminorderdetail::class, 'accept'])->name('admin.order.accept');
Route::get('/admin/order/deliver/{id}', [Adminorderdetail::class, 'deliver'])->name('admin.order.deliver');
Route::get('/admin/order/cancel/{id}', [Adminorderdetail::class, 'cancel'])->name('admin.order.cancel');



        Route::get('/admin/shipping-charge', [ShippingChargeController::class, 'index'])->name('shipping.index');

        Route::get('/admin/shipping-charge/edit/{id}', [ShippingChargeController::class, 'edit'])->name('shipping.edit');

Route::post('/shipping/update/{id}', [ShippingChargeController::class, 'update'])->name('shipping.update');

        
        Route::get('/contacts', [FeedbackController::class, 'index'])->name('contact.index');

        Route::get('/admin/feedback/{id}', [FeedbackController::class, 'show'])
     ->name('feedback.show');




        Route::get('logout',[adminlogin::class,'logout'])->name('admin.logout');
        
    });
});





