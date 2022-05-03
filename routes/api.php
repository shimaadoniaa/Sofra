<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace'=>'Api'],function(){
    // general
    // settings

     Route::get('setting','MainController@setting');
     Route::get('cities','MainController@cities');
     Route::get('districtions','MainController@districtions');
     Route::get('offers','MainController@offers');
     Route::get('offer','MainController@offer');
    Route::get('home','MainController@Restaurants');
    Route::get('restaurant','MainController@Restaurant');
    Route::get('order','MainController@getOrder');
    Route::get('menu','MainController@menu');
    Route::get('review','MainController@getReview');
    Route::get('payment','MainController@payments');
    Route::get('category','MainController@categories');







    Route::group(['namespace'=>'Client','prefix' => 'client'],function(){
        // clients but not auth  api/client/register
        // restaurants - restaurant - products - reviews - login - register

     Route::post('register','ClientController@register');
     Route::post('login','ClientController@login');
     Route::post('reset','ClientController@resetPassword');
     Route::post('new-pass','ClientController@newpassword');




     Route::post('contact-us','ClientController@contactUs');








 Route::group(['middleware'=>'auth:client'],function(){
            // client authenticated
            // create-order - approve-order - profile - my-orders


    Route::post('order','ClientController@order');
    Route::get('orders','ClientController@orders');


    Route::post('profile-edit','ClientController@profile');
    Route::get('notification','ClientController@notification');



    Route::post('accept-order','ClientController@acceptOrder');
    Route::post('refuse-order','ClientController@refuseOrder');


     Route::post('review','ClientController@review');
     Route::post('register-token','ClientController@registerToken');
     Route::post('remove-token','ClientController@removeToken');



        });

    });


   //--------------------End-Clients----------------------------------------------


    //==================Restaurant============================================


    Route::group(['namespace'=>'Restaurant'],function(){
        // not auth
        // register - login - reset pass

     Route::post('register','RestaurantController@register');

    Route::post('login','RestaurantController@login');

    Route::post('reset','RestaurantController@reset');

    Route::post('new-pass','RestaurantController@newpassword');






        Route::group(['middleware'=>'auth:restaurant'],function(){
            // my products - add-product - add-offer - commissions - my-orders




    Route::post('edit-order','RestaurantController@editOrder');
    Route::post('order','RestaurantController@order');

    Route::post('edit-profile','RestaurantController@editProfile');
    Route::get('orders','RestaurantController@orders');



    Route::post('accept-order','RestaurantController@acceptOrder');
    Route::post('refuse-order','RestaurantController@refuseOrder');
    Route::post('confirm-order','RestaurantController@confirmOrder');



    Route::get('notification','RestaurantController@notification');


    Route::get('commission','RestaurantController@commission');

    Route::post('add-offer','RestaurantController@addOffer');
    Route::post('edit-offer','RestaurantController@editOffer');
    Route::post('delete-offer','RestaurantController@deleteOffer');

    Route::post('register-token','RestaurantController@registerToken');
    Route::post('remove-token','RestaurantController@removeToken');

        });

    });

});

 //--------------------------End-Restaurant---------------------------------------







