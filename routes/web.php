<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
})->name('/');

Auth::routes();

Route::group(['namespace'=>'Admin','middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middelware'=>'auth:restaurant-web','namespace'=>'Admin'],function(){
   Route::resource('category','CategoryController');
   Route::resource('city','CityController');
   Route::resource('client','ClientController');
   Route::resource('distriction','DistrictionController');
   Route::resource('order','OrderController');
   Route::resource('offer','OfferController');
   Route::resource('restaurant','RestaurantController');
   Route::resource('contact','ContactController');
   Route::resource('payment','PaymentController');
   Route::resource('paid','paidController');
   Route::get('change-pass','UserController@changePassword')->name('change-pass');
   Route::post('change-pass','UserController@editPassword')->name('edit-password');
   //Route::get('logout','UserController@logout')->name('logout');
   Route::resource('setting','SettingController');

});
