<?php

Route::group(['middleware' => ['web','qc'], 'prefix' => 'qc', 'namespace' => 'Modules\QualityControl\Http\Controllers'], function()
{

    Route::get('/', 'QualityControlController@index');
    Route::get('remove_pricing/{id}','QualityControlController@remove_pricing');
    Route::get('manage_profile','QualityControlController@manage_profile');
    Route::post('update_contacts','QualityControlController@update_contacts');
    Route::post('update_banking','QualityControlController@update_banking');
    Route::post('quality_failed','QualityControlController@quality_failed');
    Route::get('rejected/undo/{product_id}','QualityControlController@undo_rejection');

    Route::get('product/classify','QualityControlController@product_classify');
    Route::get('rejected','QualityControlController@rejected_listings');
    Route::get('repo/pending','QualityControlController@repo_pending');
    Route::get('repo/passed','QualityControlController@repo_passed');
    Route::get('repo/failed','QualityControlController@repo_failed');
    Route::get('customer-view/{slug}','QualityControlController@customer_view');
    Route::get('repository/customer-view/{slug}','QualityControlController@repo_customer_view');
    Route::get('customer-view/{slug}/{price_id}', 'QualityControlController@product_price_detail');

    Route::get('profile','QualityControlController@load_profile');
    Route::post('profile','QualityControlController@post_profile');
    Route::get('products','QualityControlController@products');
    Route::get('products/new/{category_id}','QualityControlController@new_product');
    Route::get('load_brands','QualityControlController@load_brands');
    Route::get('seller-profiles','QualityControlController@seller_profiles');

    Route::get('load_subcategories','QualityControlController@load_subcategories_html');
    Route::post('start_product','QualityControlController@start_product');
    Route::get('check_child','QualityControlController@check_child');
    Route::get('test_child/{id}','QualityControlController@check_child');
    Route::post('products/save','QualityControlController@save_products');
    Route::get('product/{slug}','QualityControlController@manage_product');
    Route::get('repo/product/{slug}','QualityControlController@manage_repo_product');
    Route::post('product/add_price','QualityControlController@add_price');
    Route::post('product/update_price','QualityControlController@update_price');
    Route::get('delete_product/{id}','QualityControlController@delete_product');
    Route::post('upload_images','QualityControlController@upload_images');
    Route::get('remove_image/{image_id}','QualityControlController@remove_image');
    Route::get('image/make_default/{image_id}','QualityControlController@make_default_image');
    Route::post('update_product_details','QualityControlController@update_product_details');
    Route::post('publish_product','QualityControlController@publish_product');
    Route::get('unpublish/{id}','QualityControlController@unpublish_product');
    Route::get('code','QualityControlController@generate_product_code');
    Route::post('update_product_features','QualityControlController@product_features');
    Route::get('remove_product_feature/{id}','QualityControlController@remove_product_feature');

    Route::get('sellers/manage/{id}','QualityControlController@manage');

    Route::get('pdf',function(){

    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();

    });

   Route::get('product_features/{product_id}','QualityControlController@load_product_features');

});

Route::group(['middleware' => ['web'],  'namespace' => 'Modules\QualityControl\Http\Controllers'], function()
{

    Route::get('qc/login', 'QualityControlController@login');
    Route::get('qc/confirm_account/{code}','QualityControlController@confirm_account');

    Route::get('qc/activate_promotion/{id}','QualityControlController@activate_promotion');
    Route::get('qc/deactivate_promotion/{id}','QualityControlController@deactivate_promotion');
    Route::get('qc/promote-product/{id}','QualityControlController@promote_product');
    Route::post('qc/promote_product','QualityControlController@addPromotionPrice');
});
