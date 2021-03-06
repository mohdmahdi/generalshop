<?php

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

//Route::get('units-test' , 'DataImportController@importUnits');

Route::get('cities',function(){

    return \App\City::with(['country' , 'state'])->paginate(50);
});

Route::get('countries',function(){

    return \App\Country::with(['cities' , 'states'])->paginate(5);
});

Route::get('states',function(){

    return \App\State::with(['Country' , 'cities'])->paginate(5);
});




Route::get('products',function(){

    return \App\Product::paginate(100);
});

Route::get('images',function(){

    return \App\Image::paginate(100);
});



Route::get('/', function () {
    return view('welcome');
});

Route::get('tag-test',function(){

    $tag = \App\Tag::find(5);

    return $tag->products;
});


Route::get('role-test',function(){

    $users = \App\User::find(501);

    return $users->roles;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email-test' , function (){

    return 'hello';
})->middleware(['auth', 'user_is_support']);

Route::group(['auth','user_is_admin'] , function(){

    //units

    Route::get ('units', 'UnitController@index')->name('units');
    Route::post ('units', 'UnitController@store');
    Route::delete ('units', 'UnitController@delete');
    Route::put ('units', 'UnitController@update');
    Route::get('search-units', 'UnitController@search')->name('search-units');
    //categories
    Route::get ('categories', 'categoryController@index')->name('categories');
    Route::post ('categories', 'categoryController@store');
    Route::delete ('categories', 'categoryController@delete');
    Route::put('categories','categoryController@update');
    Route::get('search-categories', 'categoryController@search')->name('search-categories');


    //products
    Route::get ('products', 'productController@index')->name('products');

    Route::get ('new-product', 'productController@newProduct')->name('new-product');
    Route::post ('new-product', 'productController@store');
    Route::Post('delete-image' , 'productController@deleteImage')->name('delete-image');
    Route::get ('update-product/{id}', 'productController@newProduct')->name('update-product-form');
    Route::put ('update-product', 'productController@update')->name('update-product');

    Route::delete ('products/{id}', 'productController@delete');


    //Tags
    Route::get ('tags', 'tagController@index')->name('tags');
    Route::post ('tags', 'tagController@store');
    Route::delete ('tags', 'tagController@delete');
    Route::put('tags','tagController@update');
    Route::get('search-tags', 'tagController@search')->name('search-tags');


    //payments
    //Orders

    //Countries
    Route::get ('countries', 'countryController@index')->name('countries');
    //Cities
    Route::get ('cities', 'cityController@index')->name('cities');
    //States
    Route::get ('states', 'stateController@index')->name('states');


    //Reviews

    Route::get ('reviews', 'reviewController@index')->name('reviews');
    //Tickets
    Route::get ('tickets', 'ticketController@index')->name('tickets');

    //Roles
    Route::get ('roles', 'roleController@index')->name('roles');

});