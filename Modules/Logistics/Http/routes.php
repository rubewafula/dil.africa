<?php

Route::group(['middleware' => 'web', 'prefix' => 'logistics', 'namespace' => 'Modules\Logistics\Http\Controllers'], function()
{
    Route::get('/', 'LogisticsController@index');
    Route::get('incoming_orders','LogisticsController@incoming_orders');
    Route::get('orders','LogisticsController@orders');
    Route::post('assign_warehouse','LogisticsController@assign_warehouse');
    Route::get('direct-shipment/{order_id}','LogisticsController@direct_shipment_view');
    Route::post('direct_shipment','LogisticsController@direct_shipment');
    Route::get('receive_order/{id}','LogisticsController@receive_order');
    Route::post('reject_at_warehouse','LogisticsController@reject_at_warehouse');
    Route::get('received_orders','LogisticsController@received_orders');
    Route::get('quality_passed/{id}','LogisticsController@quality_passed');
    Route::post('quality_failed','LogisticsController@quality_failed');
    Route::get('quality_passed_orders','LogisticsController@quality_passed_orders');
    Route::get('rejected_orders','LogisticsController@rejected_orders');
    Route::get('quality_failed_orders','LogisticsController@quality_failed_orders');
    Route::get('customer/confirmed-orders','LogisticsController@customer_confirmed_orders');
    Route::get('customer/orders','LogisticsController@customer_ready_orders');
    Route::get('customer/orders/failed','LogisticsController@customer_failed_orders');
    Route::get('customer/orders/scheduled','LogisticsController@customer_scheduled_orders');
    Route::get('customer/orders/dispatched','LogisticsController@customer_dispatched_orders');
    Route::get('customer/orders/delivered','LogisticsController@customer_delivered_orders');
    Route::get('customer/orders/returned','LogisticsController@customer_returned_orders');
    Route::get('customer/orders/partially-returned','LogisticsController@customer_partially_returned_orders');
    Route::get('customer/orders/direct-shipment','LogisticsController@direct_shipment_orders');
    Route::get('order-details/{referrer}/{order_id}','LogisticsController@order_details');
    Route::get('customer/orders/{referrer}','LogisticsController@goBack');

    Route::resource('riders','RiderController');
    Route::resource('vehicles','VehicleController');
    Route::resource('trips','TripController');
    Route::resource('trips/{id}/orders/','TripOrderController');
    Route::get('trips/orders/add-to-trip/{trip_id}/{order_id}','TripOrderController@add_order_to_trip');
    Route::post('trips/orders/remove-from-trip/{id}','TripOrderController@remove_order_from_trip');
    Route::get('trips/orders/details/{id}','TripOrderController@trip_order_details');
    Route::get('trips/orders/dispatch_orders/{id}','TripOrderController@dispatch_orders');
    Route::get('trips/orders/entire-order-delivered/{id}','TripOrderController@mark_order_as_delivered');
    Route::get('trips/orders/order-detail-delivered/{id}','TripOrderController@mark_orderdetail_as_delivered');
    Route::post('trips/orders/entire-order-returned','TripOrderController@mark_order_as_returned');
    Route::post('trips/orders/order-detail-returned','TripOrderController@mark_orderdetail_as_returned');
});