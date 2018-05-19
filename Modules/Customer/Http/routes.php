<?php

Route::group(['middleware' => 'web', 'prefix' => 'shop', 'namespace' => 'Modules\Customer\Http\Controllers'], function()
{
    Route::get('/', 'CustomerController@index');
    Route::get('/product/detail/{id}', 'CustomerController@product_detail')->name('product/detail');
});
