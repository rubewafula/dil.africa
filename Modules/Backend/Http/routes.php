<?php
include('routes_extended.php');
Route::group(['middleware' => ['web','backend'], 'prefix' => 'backend', 'namespace' => 'Modules\Backend\Http\Controllers'], function()
{
    Route::get('/', 'BackendController@index');

    Route::resource('users', 'UsersController');

	Route::resource('brands', 'BrandsController');
	Route::resource('categories', 'CategoriesController');
	Route::resource('sub_categories', 'Sub_categoriesController');
	Route::resource('featured-categories', 'FeaturedCategoryController');
	Route::resource('countries', 'CountriesController');
	Route::resource('countries', 'CountriesController');
	Route::resource('zones', 'ZonesController');
	Route::resource('areas', 'AreasController');
	Route::resource('roles', 'RolesController');
	Route::resource('flash-sale', 'FlashSaleController');
	Route::post('load_cities','BackendController@load_cities');
	Route::get('profile','BackendController@profile');
	Route::post('profile','BackendController@update_profile');
	Route::resource('users', 'UsersController');
	Route::post('add_new_user','SellersController@add_new_user');
	Route::get('remove_user_role/{user_id}/{role_id}','UsersController@remove_user_role');

	Route::get('remove_brand_pic/{brand_id}','BrandsController@remove_brand_pic');

	Route::resource('sellers', 'SellersController');
	 
	Route::get('load_cities','BackendController@load_cities');


	Route::resource('cities', 'CitiesController');
	Route::resource('warehouses', 'WarehousesController');
	Route::get('sellers/manage/{id}','SellersController@manage');

	Route::get('remove_subcategory_pic/{id}','Sub_categoriesController@remove_subcategory_pic');

	Route::get('load_categories','BackendController@load_categories');
	Route::get('filter_categories','BackendController@filter_categories');

	Route::get('load_subcategories','BackendController@load_subcategories');
	Route::post('add_subcat', 'Sub_categoriesController@store');
	Route::resource('payment_gateways', 'Payment_gatewaysController');
	Route::get('orders','BackendController@orders');

	Route::get('product/{slug}','BackendController@manage_product');
	Route::post('update_product_admin/{id}','BackendController@update_product_admin');
	Route::resource('suspension_reasons', 'Suspension_reasonsController');
	Route::get('load_reasons','Suspension_reasonsController@get_reasons');
	Route::get('orders/manage/{id}','OrdersController@manage');
	Route::get('customers','CustomerController@index');
	Route::get('customer/{id}','CustomerController@manage_customer');
	Route::post('notes/add_note','CustomerController@add_note');
	Route::get('delete_note/{id}','CustomerController@delete_note');
	Route::get('customer/order/{order_id}','CustomerController@order');
	Route::resource('shipping_prices', 'Shipping_pricesController');
	Route::resource('special-shipping', 'Special_shipping_ratesController');
	Route::post('receive_products','BackendController@receive_products');
	Route::get('remove_seller_logo/{id}','BackendController@remove_seller_logo');
	Route::get('remove_licence/{id}','BackendController@remove_licence');
	Route::get('remove_front_id/{id}','BackendController@remove_front_id');
	Route::get('remove_back_id/{id}','BackendController@remove_back_id');

	Route::get('sellers/manage/{id}/new_user','SellersController@new_user');
	Route::resource('feature_types', 'Feature_typesController');
	Route::get('cancel_order/{order_id}','OrdersController@cancel_order');
	Route::post('cancel_order','OrdersController@post_cancel_order');
	Route::get('accept_order/{order_id}','OrdersController@accept_order');

	Route::resource('cancellation_reasons', 'Cancellation_reasonsController');
	Route::resource('rejection_reasons', 'Rejection_reasonsController');
	Route::resource('quality_issues', 'Quality_issuesController');
	Route::resource('inquiries', 'InquiriesController');
	Route::get('products','BackendController@products');
	Route::post('add_category_sizes','CategoriesController@add_category_sizes');
	Route::get('remove_category_size/{id}','CategoriesController@remove_category_size');

	Route::post('add_category_brand','CategoriesController@add_category_brand');
	Route::get('remove_brand_category/{id}','CategoriesController@remove_brand_category');

	Route::get('riders','RidersController@index');
	Route::get('riders/create','RidersController@create');
	Route::post('riders/store','RidersController@store');
	Route::get('riders/edit','RidersController@edit');
	Route::post('riders/update','RidersController@update');
	Route::get('riders/purge/{id}','RidersController@destroy');

	Route::resource('vehicles', 'VehiclesController');
	Route::resource('campaign', 'CampaignController');

	Route::resource('promotion-banners', 'PromotionBannerController');
	Route::get('promotion-banners/activate/{id}','PromotionBannerController@activate');
	Route::get('promotion-banners/inactivate/{id}','PromotionBannerController@inactivate');
	Route::resource('hot-deals','HotDealController');
	Route::resource('flash-sale','FlashSaleController');
	Route::resource('special-offers','SpecialOfferController');

	Route::resource('campaign-groups','CampaignGroupController');
	Route::get('campaign-groups/{id}/msisdns/','CampaignGroupController@campaign_msisdns');
	Route::get('campaign-groups/{id}/sms/','CampaignGroupController@send_sms');
	Route::get('campaign-groups/msisdns/add/{id}','CampaignGroupController@add_msisdn');
    Route::post('campaign-groups/msisdns/add-msisdn','CampaignGroupController@add_msisdn_to_campaign_group');
    Route::post('campaign-groups/msisdns/remove-from-group/{id}','CampaignGroupController@remove_msisdn_from_group');
    Route::post('campaign-groups/msisdns/upload-csv','CampaignGroupController@upload_csv');
    Route::post('campaign-groups/msisdns/save-sms','CampaignGroupController@save_sms');

	Route::post('upload_banner','PromotionBannerController@upload_banner');
    Route::get('remove_banner/{id}','PromotionBannerController@remove_banner');

    Route::post('load-product-name','CampaignController@getProductName');

    Route::get('campaign/{id}/banners/','CampaignController@campaign_banners');
    Route::get('campaign/banners/add-to-campaign/{campaign_id}/{banner_id}','CampaignController@add_banner_to_campaign');
    Route::post('campaign/banners/remove-from-campaign/{id}','CampaignController@remove_banner_from_campaign');

    Route::get('campaign/{id}/products/','CampaignController@campaign_products');
    Route::post('campaign/products/add-to-campaign','CampaignController@saveCampaignProduct');
    Route::post('campaign/products/remove-from-campaign/{id}','CampaignController@remove_product_from_campaign');

    Route::get('providers','ProviderController@index');

    Route::post('post_note','OrdersController@post_note');
    Route::get('delete_note/{id}','OrdersController@delete_note');

    Route::get('customer-searches','BackendController@customer_searches');
    Route::get('waybill/{id}','CustomerController@waybill');
    Route::get('po/{order_detail_id}','CustomerController@po');
    Route::post('order/markaspaid','OrdersController@markaspaid');
    Route::post('order/markasconfirmed','OrdersController@markasconfirmed');

    Route::post('order/add-product-tag','BackendController@add_product_tag');
});