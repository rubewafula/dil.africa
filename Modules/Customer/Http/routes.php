<?php

Route::group(['prefix' => 'shop', 'middleware' => ['web'], 'namespace' => 'Modules\Customer\Http\Controllers'], function()
{
    Route::get('/', 'CustomerController@index');
    Route::get('/product/detail/{slug}', 'CustomerController@product_detail')->name('product/detail');
    Route::get('/product/detail/{slug}/{price_id}', 'CustomerController@product_price_detail');
    Route::get('/sign-in', 'CustomerController@sign_in')->name('sign-in');
    Route::get('/sign-up', 'CustomerController@sign_up')->name('sign-up');
    Route::get('/agent/sign-up', 'CustomerController@agent_sign_up')->name('agent/sign-up');
    Route::get('/profile', 'CustomerController@profile')->name('profile');
    Route::get('/profile/edit/{id}', 'CustomerController@profile_edit')->name('profile/edit');
    Route::get('/change-password', 'CustomerController@change_password')->name('change-password');
    Route::post('/change-password', 'CustomerController@saveNewPassword')->name('change-password');
    Route::post('/update-profile', 'CustomerController@update_profile')->name('update-profile');
    Route::get('/checkout', 'CustomerController@checkout')->name('checkout');
    Route::get('/checkout/delivery', 'CustomerController@delivery')->name('checkout/delivery');
    Route::get('/checkout/agent/delivery', 'CustomerController@deliveryAgent')->name('checkout/agent/delivery');
    Route::get('/my-account', 'CustomerController@my_account')->name('my-account');
    Route::get('/continue-payment', 'CustomerController@continue_payment')->name('continue-payment');
    Route::get('/pickup/continue-payment/{user_address_id}', 'CustomerController@continue_payment')->name('continue-payment');
    Route::post('/address/makedefault', 'CustomerController@make_default_address')->name('address/makedefault');
    Route::post('/load_product_price', 'CustomerController@load_product_price')->name('load_product_price');
    Route::post('/station/makedefault', 'CustomerController@make_default_pickup')->name('station/makedefault');
    Route::post('/delivery-type', 'CustomerController@setDeliveryType')->name('delivery-type');
    Route::get('/checkout/delivery/update/{id}', 'CustomerController@delivery_update')->name('checkout/delivery/update');
    Route::get('/address/edit/{id}', 'CustomerController@address_edit')->name('address/edit');
    Route::get('/checkout/payment', 'CustomerController@payment')->name('checkout/payment');
    Route::get('/checkout/order-review', 'CustomerController@order_review')->name('checkout/order-review');
    Route::get('/checkout/guest', 'CustomerController@guest_checkout')->name('checkout/guest');
    Route::get('/checkout/guest/update/{id}', 'CustomerController@guest_update')->name('checkout/guest/update');
    Route::post('/checkout/register-guest', 'CustomerController@register_guest')->name('checkout/register-guest');
    Route::post('/checkout/save-address', 'CustomerController@saveAddress')->name('checkout/save-address');
    Route::post('/checkout/agent/save-address', 'CustomerController@saveAddressAgent')->name('checkout/agent/save-address');
    Route::post('/address/update', 'CustomerController@updateAddress');
    Route::post('/checkout/save-pickup-station', 'CustomerController@savePickupLocation')->name('checkout/save-pickup-station');
    Route::post('/checkout/agent/save-pickup-station', 'CustomerController@savePickupLocationAgent')->name('checkout/agent/save-pickup-station');
    Route::post('/register-customer', 'CustomerController@registerCustomer')->name('register-customer');
    Route::post('/register-agent', 'CustomerController@registerAgent')->name('register-agent');
    Route::post('/checkout/payment-method', 'CustomerController@payment_method')->name('checkout/payment-method');
    Route::post('/checkout/complete-transaction', 'CustomerController@complete_transaction')->name('checkout/complete-transaction');
    Route::get('/register', 'CustomerController@load_register')->name('register');
    Route::get('/agent/register', 'CustomerController@load_register_agent')->name('agent/register');
    Route::get('/contact-us', 'CustomerController@contact_us')->name('contact-us');
    Route::get('/terms-conditions', 'CustomerController@terms_conditions')->name('terms-conditions');
    Route::get('/faq', 'CustomerController@faq')->name('faq');
    Route::get('/track-order', 'CustomerController@track_order')->name('track_order');
    Route::post('/track-order', 'CustomerController@getOrderTrackDetails')->name('track_order');
    Route::get('/shipping', 'CustomerController@shipping')->name('shipping');
    Route::get('/become-seller', 'CustomerController@become_seller')->name('become-seller');
    Route::get('/become-agent', 'CustomerController@become_agent')->name('become-agent');
    Route::get('/logistics-partner', 'CustomerController@logistics_partner')->name('logistics-partner');
    Route::get('/return-policy', 'CustomerController@return_policy')->name('return-policy');
    Route::get('/about-us', 'CustomerController@about_us')->name('about-us');
    Route::get('/privacy-policy', 'CustomerController@privacy_policy')->name('privacy-policy');
    Route::get('/cart', 'CustomerController@cart')->name('cart');
    Route::post('/cart/update', 'CustomerController@updateCart')->name('cart/update');
    Route::post('/apply-voucher', 'CustomerController@applyVoucher')->name('apply-voucher');
    Route::get('/cart/remove/{id}', 'CustomerController@remove_from_cart')->name('/cart/remove');  
    Route::get('/transaction/success/{id}', 'CustomerController@tran_success')->name('/transaction/success');
    Route::get('/transaction/cancel/{id}', 'CustomerController@tran_cancel')->name('/transaction/cancel'); 
    
    Route::post('/cities', 'CustomerController@getCities')->name('cities');
    Route::post('/zones', 'CustomerController@getZones')->name('zones');
    Route::post('/areas', 'CustomerController@getAreas')->name('areas');
    Route::post('/city/areas', 'CustomerController@getCityAreas')->name('city/areas');
    Route::post('/pickup-points', 'CustomerController@getPickupPoints')->name('pickup-points');
    Route::post('save-search', 'CustomerController@saveSearchedItems')->name('save-search');
    
    Route::post('pay_by_paypal', 'PaymentController@pay_by_paypal');
    Route::get('payments/paypal_payments/{id}', 'PaymentController@getPaymentStatus');
    Route::get('history', 'CustomerController@getCustomerHistory'); 
    Route::get('wishlist', 'CustomerController@getCustomerWishlist');
    Route::post('/add_to_cart', 'CustomerController@add_to_cart')->name('add_to_cart');
    Route::get('/add_to_wishlist/{product_id}/{product_price_id}', 'CustomerController@add_to_wishlist')->name('add_to_wishlist');
    Route::post('/subscribe/newsletter', 'CustomerController@subscribe_to_newsletter')->name('subscribe/newsletter');
    Route::post('/review', 'CustomerController@submit_review')->name('review');
    
    Route::get('checkout/checkout-details', function(){
        return view('modules/customer/checkout/guest_email');
    });
    
    Route::get('checkout/mpesa-payment', function(){
        return view('modules/customer/checkout/mpesa_payment');
    });
    
    Route::post('/login', 'CustomerController@login')->name('login');
    Route::get('/confirm_account/{confirmation_token}', 'CustomerController@confirm_account')->name('confirm_account');
    Route::get('/agent/confirm_account/{confirmation_token}', 'CustomerController@agent_confirm_account')->name('agent_confirm_account');
    Route::get('/confirm-order/{confirmation_token}', 'CustomerController@confirm_order')->name('confirm-order');
    Route::get('/category/{slug}', 'CustomerController@searchByCategory')->name('category');
    Route::get('/flash-sale', 'CustomerController@searchFlashSale')->name('flash-prices');
    Route::get('/category/{slug}/{no_of_pages}/{page}', 'CustomerController@searchByCategoryPagination');
    Route::get('/campaign/{id}', 'CustomerController@searchCampaignProducts')->name('campaign');
    Route::get('/category/{slug}/{from}/{to}', 'CustomerController@filterByPriceRange');
    Route::get('/category/search/color/{slug}/{color}', 'CustomerController@filterByColor');
    Route::get('/category', 'CustomerController@getAllProducts')->name('category');
    Route::get('/brand/{slug}', 'CustomerController@searchByBrand')->name('brand');
    Route::post('/search', 'CustomerController@search')->name('search');
    Route::get('/search/default/{slug}', 'CustomerController@searchDefault')->name('search/default');
    Route::get('/search/lowest/{slug}', 'CustomerController@searchLowestPriceFirst')->name('search/lowest');
    Route::get('/search/highest/{slug}', 'CustomerController@searchHighestPriceFirst')->name('search/highest');
    Route::get('/search/name/{slug}', 'CustomerController@searchOrderByName')->name('search/name');
    
    Route::get('test_mpesatoken', 'MPESAController@access_token');
    Route::get('test_mpesaencrypt', 'MPESAController@encrypt');
    Route::get('home', 'CustomerController@home');

    Route::get('order/invoice/view/{order_id}', 'CustomerController@view_invoice');
    Route::get('order/invoice/download/{order_id}', 'CustomerController@download_invoice');

    // social media auth
    Route::get('auth/{provider}', 'AuthController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'AuthController@handleProviderCallback');

    Route::get('invoice/{id}', 'CustomerController@invoice');
    Route::get('logout', 'CustomerController@logout');

    Route::get('cart-items-added', function(){

        $cart = Session::get('cart');
        foreach($cart as $session){

            $product_price_id = $session->getProductPriceId();
            $productPrice = App\Product_price::find($product_price_id);

            echo "Product ".print_r($productPrice);
        }
    });

    Route::post('mpesa/callback', 'CustomerController@mpesaC2BConfirm');

    Route::post('mpesa/c2b/confirm', 'CustomerController@mpesaC2BConfirm');
    Route::post('mpesa/c2b/validate', 'CustomerController@mpesaC2BValidate');

    Route::get('ipay/callback', 'CustomerController@ipay');

    Route::get('upload-cities', 'CustomerController@upload_cities');
    Route::get('upload-zones', 'CustomerController@upload_zones');
    Route::get('upload-areas', 'CustomerController@upload_areas');
    Route::get('upload-shipping', 'CustomerController@upload_shipping_outsidenai_csv');
    Route::get('upload-shipping-one', 'CustomerController@upload_shipping_one_category');
    Route::get('upload_g4s_pickups', 'CustomerController@upload_g4s_pickups');

    Route::get('test_mpesa_token', 'CustomerController@test_mpesa_token');
    Route::get('test_stk', 'CustomerController@testmpesa_stk');
    Route::get('test_mpesa_security_encryption', 'CustomerController@test_mpesa_security_encryption');
    Route::get('test_mpesa_stk/{order_id}', 'CustomerController@test_mpesa_stk');
    Route::get('test_mpesa_register_confirm', 'CustomerController@test_mpesa_register_confirm_url');
    Route::get('mpesa-register-url', 'CustomerController@mpesaRegisterURL');

    Route::get('pay/ipay/{order_id}', 'CustomerController@pay_by_ipay');

    Route::get('replace-ws', 'CustomerController@replaceExtraSpaces');
    Route::get('update-prices', 'CustomerController@updateErroneousProductPrices');
    Route::get('test-pwd-generation', 'CustomerController@test_generate_credential');
    
});