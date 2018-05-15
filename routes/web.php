<?php

//use  Session;
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
    return view('modules/customer/home/index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('create_brand',function(Request  $request){

   // $value = session('key');

	  //echo  $value;
    //dd(csrf_token()	);

   
   return  view('create_brand');

});

Route::post('create_brand',function(){

  print_r($_POST);

});


Route::resource('backend/cities', 'CitiesController');