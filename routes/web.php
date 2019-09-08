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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email-test' , function (){

    return 'hello';
})->middleware(['auth', 'email_verified']);
