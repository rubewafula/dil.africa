<?php

Route::group(['middleware' => ['web','seller'], 'prefix' => 'seller', 'namespace' => 'Modules\Seller\Http\Controllers'], function()
{

    Route::get('/', 'SellerController@index');
    Route::get('remove_pricing/{id}','SellerController@remove_pricing');
    Route::get('manage_profile','SellerController@manage_profile');
    Route::post('update_account','SellerController@update_account');
    Route::post('update_contacts','SellerController@update_contacts');
    Route::post('update_banking','SellerController@update_banking');
    Route::post('terms','SellerController@terms_conditions');
    Route::post('update_features','SellerController@update_features');

    Route::get('product/classify','SellerController@product_classify');

    Route::get('profile','SellerController@load_profile');
    Route::post('profile','SellerController@post_profile');
    Route::get('products','SellerController@products');
    Route::get('products/new/{category_id}','SellerController@new_product');
    Route::get('load_brands','SellerController@load_brands');

    Route::get('load_subcategories','SellerController@load_subcategories_html');
    Route::post('start_product','SellerController@start_product');
    Route::get('check_child','SellerController@check_child');
    Route::get('test_child/{id}','SellerController@check_child');
    Route::post('products/save','SellerController@save_products');
    Route::get('product/{slug}','SellerController@manage_product');
    Route::post('product/add_price','SellerController@add_price');
    Route::post('product/update_price','SellerController@update_price');
    Route::get('orders','SellerController@view_orders');
    Route::get('delete_product/{id}','SellerController@delete_product');
    Route::post('upload_images','SellerController@upload_images');
    Route::get('remove_image/{image_id}','SellerController@remove_image');
    Route::get('image/make_default/{image_id}','SellerController@make_default_image');
    Route::post('update_product_details','SellerController@update_product_details');
    Route::get('users','UsersController@manage_users');
    Route::get('new_user','UsersController@create');
    Route::post('users','UsersController@store');
    Route::get('users/{id}/edit','UsersController@edit');
    Route::post('users/{id}','UsersController@update');
    Route::post('publish_product','SellerController@publish_product');
    Route::get('unpublish/{id}','SellerController@unpublish_product');
    Route::post('process_order','SellerController@process_order');
    Route::get('manage_order/{id}', 'SellerController@manage_order');
    Route::get('code','SellerController@generate_product_code');
    Route::post('update_product_features','SellerController@product_features');
    Route::get('remove_product_feature/{id}','SellerController@remove_product_feature');
    Route::get('order_invoice/{id}','SellerdocumentsController@invoice');
    Route::get('sales_report','SellerController@sales_report');

    Route::get('pdf',function(){

    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();

    });

   Route::get('product_features/{product_id}','SellerController@load_product_features');

});

Route::group(['middleware' => ['web'],  'namespace' => 'Modules\Seller\Http\Controllers'], function()
{

    Route::get('start', 'SellerController@login');
    Route::get('seller/login', 'SellerController@login');
    Route::get('seller/register','SellerController@register_seller');
    Route::post('seller/register','SellerController@register');
    Route::get('seller/my-promotions','SellerController@my_promotions');
    Route::get('seller/confirm_account/{code}','SellerController@confirm_account');

    Route::get('seller/activate_promotion/{id}','SellerController@activate_promotion');
    Route::get('seller/deactivate_promotion/{id}','SellerController@deactivate_promotion');
    Route::get('seller/promote-product/{id}','SellerController@promote_product');
    Route::post('seller/promote_product','SellerController@addPromotionPrice');
    Route::get('seller/restore_depends_on','SellerController@restore_depends_on');
    Route::get('seller/restore_level','SellerController@restore_level');
    Route::get('seller/update_level_two','SellerController@update_level_two');
});