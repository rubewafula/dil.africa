<?php

Route::group(['middleware' => 'web', 'prefix' => 'backend', 'namespace' => 'Modules\Backend\Http\Controllers'], function()
{
    Route::get('/', 'BackendController@index');

    Route::resource('users', 'UsersController');

    // Route::get('brands',function(){

    //    return  view('backend::brands');

    // });

    //  Route::get('brand_edit',function(){

    //    return  view('backend::brand_edit');

    // });

    Route::resource('brands', 'BrandsController');
Route::resource('categories', 'CategoriesController');
Route::resource('sub_categories', 'Sub_categoriesController');
Route::resource('countries', 'CountriesController');
Route::resource('countries', 'CountriesController');
Route::resource('zones', 'ZonesController');
Route::resource('areas', 'AreasController');
Route::resource('roles', 'RolesController');
Route::resource('sellers', 'SellersController');
Route::post('load_cities','BackendController@load_cities');

});
