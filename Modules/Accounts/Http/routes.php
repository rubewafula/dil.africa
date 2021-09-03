<?php

Route::group(['middleware' => ['web','accounts'], 'prefix' => 'accounts', 
	'namespace' => 'Modules\Accounts\Http\Controllers'], function()
{
    Route::get('/', 'AccountsController@index');
   // Route::get('/accounts','')
    //Route::get('vendors','SellerController@vendors');
    //Route::get('vendors/create','SellerController@create_vendor');

    Route::resource('sellers', 'SellersController');
    Route::get('sellers/manage/{id}','SellersController@manage');

    Route::get('remove_seller_logo/{id}','BackendController@remove_seller_logo');
	Route::get('remove_licence/{id}','BackendController@remove_licence');
	Route::get('remove_front_id/{id}','BackendController@remove_front_id');
	Route::get('remove_back_id/{id}','BackendController@remove_back_id');
	Route::get('new_product/{id}','SellersController@new_product');

	Route::get('load_subcategories','SellerController@load_subcategories_html');
    Route::post('start_product','SellerController@start_product');
    Route::get('check_child','SellerController@check_child');
    Route::get('products/new/{category_id}/{seller_id}','SellerController@new_product');
    Route::post('products/save','SellerController@save_products');
    Route::post('update_features','SellerController@update_features');
    Route::post('product/add_price','SellerController@add_price');
    Route::post('product/update_price','SellerController@update_price');
    Route::get('remove_pricing/{id}','SellerController@remove_pricing');
    Route::get('image/make_default/{image_id}','SellerController@make_default_image');
    Route::get('remove_image/{image_id}','SellerController@remove_image');
    Route::post('upload_images','SellerController@upload_images');
    Route::get('product/{slug}','SellerController@manage_product');
    Route::post('publish_product','SellerController@publish_product');
    Route::get('unpublish/{id}','SellerController@unpublish_product');
    Route::get('delete_product/{id}','SellerController@delete_product');
   	Route::get('remove_image/{image_id}','SellerController@remove_image');
    Route::post('product/update_price','SellerController@update_price');
    Route::get('users/{id}/edit','UsersController@edit');
    Route::post('users/{id}','UsersController@update'); 
    Route::delete('users/{id}','UsersController@delete_user'); 
    Route::get('new_user','UsersController@create');
    Route::post('users','UsersController@store');
    Route::post('create_users','UsersController@create_user');
    Route::get('orders','AccountsController@orders');
    Route::get('seller_order/{id}','AccountsController@seller_order');
    Route::get('confirm_order/{id}','AccountsController@confirm_order');
    Route::post('post_note','AccountsController@post_note');
    Route::get('cancel_order/{id}','AccountsController@cancel_order');
    Route::get('delete_note/{id}','AccountsController@delete_note');
    Route::get('products','AccountsController@products');


});




Route::group(['middleware' => ['web'], 'prefix' => 'accounts', 
    'namespace' => 'Modules\Accounts\Http\Controllers'], function()
{
    Route::get('login','AccountsController@login');


});