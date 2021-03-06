<?php

use Illuminate\Http\Request;

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

// get Categories
Route::get('categories' , 'Api\CategroyController@index');

Route::get('categories/{id}' , 'Api\CategroyController@show');
Route::get('categories/{id}/products' , 'Api\CategroyController@products');
// get Tags
Route::get('tags' , 'Api\TagController@index');
Route::get('tags/{id}' , 'Api\TagController@show');

// get products
Route::get('products' , 'Api\ProductController@index');
Route::get('products/{id}' , 'Api\ProductController@show');

// general Routes

Route::get('countries' , 'Api\CountryController@index');
Route::get('countries/{id}/cities' , 'Api\CountryController@showCities');
Route::get('countries/{id}/states' , 'Api\CountryController@showStates');

Route::post('auth/register' , 'Api\AuthController@register');
Route::post('auth/login' , 'Api\AuthController@login');




//Route::get('users' , function (){
//    return \App\Http\Resources\UserFullResource::collection(\App\User::paginate());
//});


Route::middleware('auth:api')->group(function(){

    Route::post('carts' , 'Api\CartController@addProductToCart');
    Route::get('carts' , 'Api\CartController@index');


});






