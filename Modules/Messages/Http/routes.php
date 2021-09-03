<?php
use  App\User;

Route::group(['middleware' => ['web','auth'], 'prefix' => 'messages', 'namespace' => 'Modules\Messages\Http\Controllers'], function()
{
    //Route::get('/', 'MessagesController@index');
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);

  


});
