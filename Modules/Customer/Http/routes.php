<?php

Route::group(['prefix' => 'shop',  'namespace' => 'Modules\Customer\Http\Controllers'], function()
{
    Route::get('/', 'CustomerController@index');
    Route::get('/product/detail/{id}', 'CustomerController@product_detail')->name('product/detail');
    Route::get('/sign-in', 'CustomerController@sign_in')->name('sign-in');
    Route::get('/checkout', 'CustomerController@checkout')->name('checkout');
    Route::get('/checkout/delivery', 'CustomerController@delivery')->name('checkout/delivery');
    Route::get('/my-account', 'CustomerController@my_account')->name('my-account');
    Route::get('/continue-payment', 'CustomerController@continue_payment')->name('continue-payment');
    Route::get('/pickup/continue-payment/{user_address_id}', 'CustomerController@continue_payment')->name('continue-payment');
    Route::post('/address/makedefault', 'CustomerController@make_default_address')->name('address/makedefault');
    Route::post('/station/makedefault', 'CustomerController@make_default_pickup')->name('pickup/makedefault');
    Route::post('/delivery-type', 'CustomerController@setDeliveryType')->name('delivery-type');
    Route::get('/checkout/delivery/update/{id}', 'CustomerController@delivery_update')->name('checkout/delivery/update');
    Route::get('/checkout/payment', 'CustomerController@payment')->name('checkout/payment');
    Route::get('/checkout/order-review', 'CustomerController@order_review')->name('checkout/order-review');
    Route::get('/checkout/guest', 'CustomerController@guest_checkout')->name('checkout/guest');
    Route::get('/checkout/guest/update/{id}', 'CustomerController@guest_update')->name('checkout/guest/update');
    Route::post('/checkout/register-guest', 'CustomerController@register_guest')->name('checkout/register-guest');
    Route::post('/checkout/save-address', 'CustomerController@saveAddress')->name('checkout/save-address');
    Route::post('/checkout/save-pickup-station', 'CustomerController@savePickupLocation')->name('checkout/save-pickup-station');
    Route::post('/register-customer', 'CustomerController@registerCustomer')->name('register-customer');
    Route::post('/checkout/payment-method', 'CustomerController@payment_method')->name('checkout/payment-method');
    Route::post('/checkout/complete-transaction', 'CustomerController@complete_transaction')->name('checkout/complete-transaction');
    Route::get('/register', 'CustomerController@load_register')->name('register');
    Route::get('/contact-us', 'CustomerController@contact_us')->name('contact-us');
    Route::get('/terms-conditions', 'CustomerController@terms_conditions')->name('terms-conditions');
    Route::get('/cart', 'CustomerController@cart')->name('cart');
    Route::post('/cart/update', 'CustomerController@updateCart')->name('cart/update');
    Route::post('/apply-voucher', 'CustomerController@applyVoucher')->name('apply-voucher');
    Route::get('/cart/remove/{id}', 'CustomerController@remove_from_cart')->name('/cart/remove');  
    Route::get('/transaction/success/{id}', 'CustomerController@tran_success')->name('/transaction/success');
    Route::get('/transaction/cancel/{id}', 'CustomerController@tran_cancel')->name('/transaction/cancel'); 
    
    Route::post('/cities', 'CustomerController@getCities')->name('cities');
    Route::post('/zones', 'CustomerController@getZones')->name('zones');
    Route::post('/areas', 'CustomerController@getAreas')->name('areas');
    
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
    Route::get('/category/{category_id}', 'CustomerController@searchByCategoryId')->name('category');
    Route::post('/search', 'CustomerController@search')->name('search');
    Route::get('/search/default', 'CustomerController@searchDefault')->name('search/default');
    Route::get('/search/lowest', 'CustomerController@searchLowestPriceFirst')->name('search/lowest');
    Route::get('/search/highest', 'CustomerController@searchHighestPriceFirst')->name('search/highest');
    Route::get('/search/name', 'CustomerController@searchOrderByName')->name('search/name');
    
    Route::get('test_mpesatoken', 'MPESAController@access_token');
    Route::get('test_mpesaencrypt', 'MPESAController@encrypt');
    
    Route::get('logout', function(){
        Auth::logout();
        return redirect('/shop');
    });
    
});