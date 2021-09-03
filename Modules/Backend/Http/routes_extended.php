<?php
Route::group(['middleware' => ['web','backend'], 'prefix' => 'backend', 'namespace' => 'Modules\Backend\Http\Controllers'], function()
{
      Route::get('accounts_management','BackendExtendedController@accounts');
      Route::post('user_roles/{id}','BackendExtendedController@user_roles');
});