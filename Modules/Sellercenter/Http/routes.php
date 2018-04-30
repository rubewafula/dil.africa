<?php

Route::group(['middleware' => 'web', 'prefix' => 'sellercenter', 'namespace' => 'Modules\Sellercenter\Http\Controllers'], function()
{
    Route::get('/', 'SellercenterController@index');
});
