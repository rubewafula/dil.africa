<?php

namespace Modules\Logistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\Seller_order;
use  App\Order;
use  Session;
use  Auth;
use  App\Order_detail;

use  App\User;

use Modules\Logistics\Notifications\QualityPassedNotification;
use Modules\Logistics\Notifications\QualityFailedNotification;

class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $user = Auth::user();
        
        if($user == null) {

            return view('logistics::auth.login');
        } else{

            if($user->hasRole('logistics')) {

                $seller_orders = Seller_order::limit(5)->orderBy('id', 'DESC')->get();
                $orders = Order::limit(4)->orderBy('id', 'DESC')->get();

                return view('logistics::index', compact('seller_orders', 'orders'));
            }else {
            
                return view('logistics::auth.login');
            }
        }
        
    }


    public  function  incoming_orders()
    {
       
        $seller_orders= Seller_order::where('order_status','SHIP_TO_WAREHOUSE')
          ->OrWhere('order_status','READY_FOR_PICKING')->OrderBy('id','DESC')->get();  

        return  view('logistics::incoming.ship_to_warehouse', compact('seller_orders'));
    }


    public  function  receive_order($id)
    {
      
      $order= Seller_order::findorfail($id);
      $order->received_by=  Auth::user()->id;
      $order->order_status= 'RECEIVED_IN_WAREHOUSE';
      $order->save();

      Session::flash('flash_message','You have successfully received this seller order into
       the warehouse');
      return  redirect()->back();

    }

    public  function  reject_at_warehouse(Request  $request)
    {
       $request->validate([
        'seller_order_id'=>'required'
       ]);

        $order= Seller_order::findorfail($request->seller_order_id);
        $order->received_by=  Auth::user()->id;
        $order->order_status= 'REJECTED_IN_WAREHOUSE';
        $order->warehouse_rejection_reason= $request->warehouse_rejection_reason;
        $order->save();
        Session::flash('flash_message','You have rejected this order successfully. An email has
         subsequently been sent to the seller informing them of this decision');
        return  redirect()->back();
    }


    public  function  received_orders()
    {

       $seller_orders=  Seller_order::where('order_status', 'RECEIVED_IN_WAREHOUSE')
        ->limit(100)->get();
       
       return  view('logistics::orders.received_in_warehouse', compact('seller_orders'));   
    }

    public  function  quality_passed($id)
    {
        $seller_order=  Seller_order::findorfail($id);
        $seller_order->order_status='QUALITY_PASSED';
        $seller_order->save();

        $validated_items= Seller_order::where(['order_id'=>$seller_order->order_id, 
          'order_status'=>'QUALITY_PASSED'])->count();

        $order= Order::findorfail($seller_order->order_id);

        $items_ordered = Order_detail::where(['order_id'=>$seller_order->order_id])->count();
        if($validated_items == $items_ordered)
        {
            $order->order_status ='QUALITY_PASSED';
            $order->save();
        }

        $user = new User();
        $user->email = $seller_order->seller->email_address;
        $user->first_name = $seller_order->seller->name;

       // $user->notify(new QualityPassedNotification($seller_order, $user));
        
        Session::flash('flash_message','This order has been marked as having passed in quality successfully. An email has been sent to the seller informing them about this.');
        return  redirect()->back();
    }

     public  function  quality_failed(Request  $request)
     {
           $request->validate([
               'quality_issue_id'=>'required',
               'seller_order_id'=>'required'
           ]);

           $seller_order= Seller_order::findorfail($request->seller_order_id);
           $seller_order->update($request->all());

           Order::where('id',$seller_order->order_id)->update([
                'order_status'=>'QUALITY_FAILED',
                'quality_comments'=>$request->quality_comments

           ]);

           $user = new User();
           $user->email = $seller_order->seller->email_address;
           $user->first_name = $seller_order->seller->name;

           $user->notify(new QualityFailedNotification($seller_order, $user));

           Session::flash('flash_message','The order has been marked as having failed in quality. An email has been sent to the seller informing them of this decision.');
           return  redirect()->back();
     }

    public  function  quality_passed_orders()
    {

    $seller_orders=  Seller_order::where('order_status','QUALITY_PASSED')->limit(15)->get();
       
        return  view('logistics::orders.quality_passed_orders',compact('seller_orders'));  

    }

    public  function rejected_orders()
    {
       
        $seller_orders= Seller_order::where('order_status','REJECTED_IN_WAREHOUSE')->OrderBy('id','DESC')->get();  

        return  view('logistics::orders.rejected_in_warehouse', compact('seller_orders'));
    }

    public  function  quality_failed_orders()
    {
       
        $seller_orders= Seller_order::where('order_status','QUALITY_FAILED')->OrderBy('id','DESC')->get();  

        return  view('logistics::orders.quality_failed_orders', compact('seller_orders'));
    }


    public  function  orders()
    {

       $orders= Seller_order::where(['order_status'=>'ACCEPTED', 'warehouse_id'=>NULL])->OrderBy('id','DESC')->get();

       return  view('logistics::validated_orders',compact('orders'));

    }


    public  function  customer_confirmed_orders()
    {

       $orders= Order::where(['order_status'=>'VALIDATED', 'warehouse_id'=>NULL])->OrderBy('id','DESC')->get();

       return  view('logistics::orders.customer_confirmed_orders',compact('orders'));

    }


    public  function  assign_warehouse(Request  $request)
    {
        $request->validate([
            'order_id'=>'required',
            'warehouse_id'=>'required'
        ]);

      $order = Order::findorfail($request->order_id);
      $order->warehouse_id= $request->warehouse_id;
      $order->save();

      Seller_order::where('order_id', $request->order_id)
        ->update(['warehouse_id' => $request->warehouse_id]);
        
      Session::flash('flash_message','Warehouse  assigned successfully');

      return  redirect()->back();
     
    }


    public  function   direct_shipment_view(Request  $request, $order_id){

        return  view('logistics::orders.direct_shipment', compact('order_id'));
    }

    public  function  direct_shipment(Request  $request)
    {
        $request->validate([
            'order_id'=>'required',
            'vehicle_id'=>'required'
        ]);

      $order = Order::findorfail($request->order_id);
      $order->order_status = 'SCHEDULED_FOR_DIRECT_SHIPMENT';
      $order->save();

      Seller_order::where('order_id', $request->order_id)
        ->update(['order_status' => 'DIRECT_SHIPMENT_TO_CUSTOMER']);
        
      Session::flash('flash_message','Seller order to be shipped to the customer directly');

      return  redirect()->back();
     
    }


    public  function  customer_ready_orders()
    {

       $orders=  Order::where(['order_status'=>'QUALITY_PASSED'])
       ->orderBy('id', 'DESC')->paginate(20);

       $referrer = '';

       return view('logistics::orders.customer_ready_orders', 
        compact('orders', 'referrer'));
    }

    public  function  customer_failed_orders()
    {

       $orders=  Order::where(['order_status'=>'QUALITY_FAILED'])
        ->orderBy('id', 'DESC')->paginate(20);

        $referrer = 'failed';

       return view('logistics::orders.customer_failed_orders', 
        compact('orders', 'referrer'));
    }

    public  function  customer_scheduled_orders()
    {

       $orders=  Order::where(['order_status'=>'SCHEDULED'])
        ->orderBy('id', 'DESC')->paginate(20);

        $referrer = 'scheduled';

       return view('logistics::orders.customer_scheduled_orders', 
        compact('orders', 'referrer'));
    }

    public  function  customer_dispatched_orders()
    {

       $orders=  Order::where(['order_status'=>'DISPATCHED'])
        ->orderBy('id', 'DESC')->paginate(20);

        $referrer = 'dispatched';

       return view('logistics::orders.customer_dispatched_orders', 
        compact('orders', 'referrer'));
    }


    public  function  customer_delivered_orders()
    {

       $orders=  Order::where(['order_status'=>'DELIVERED'])
        ->orderBy('id', 'DESC')->paginate(20);

        $referrer = 'dispatched';

       return view('logistics::orders.customer_delivered_orders', 
        compact('orders', 'referrer'));
    }


    public  function  customer_returned_orders()
    {

       $orders=  Order::where(['order_status'=>'RETURNED'])
        ->orderBy('id', 'DESC')->paginate(20);

        $referrer = 'returned';

       return view('logistics::orders.customer_returned_orders', 
        compact('orders', 'referrer'));
    }

    public  function  customer_partially_returned_orders()
    {

       $orders=  Order::where(['order_status'=>'PARTIALLY_RETURNED'])
            ->orderBy('id', 'DESC')->paginate(20);

      $referrer = 'partially-returned';

       return view('logistics::orders.customer_partially_returned_orders', 
        compact('orders', 'referrer'));
    }


    public function direct_shipment_orders()
    {

       $orders=  Order::where(['order_status'=>'SCHEDULED_FOR_DIRECT_SHIPMENT'])
            ->orderBy('id', 'DESC')->paginate(20);

       $referrer = 'direct-shipment';

       return view('logistics::orders.customer_direct_shipment_orders', compact('orders', 'referrer'));
    }


    public function goBack($referrer) {

        return redirect(url('/logistics/customer/'.$referrer));
    }



    public function order_details($referrer, $order_id){

        $order_details = Order_detail::where('order_id', 
            $order_id)->get();

        $order = Order::find($order_id);

        return view('logistics::orders.order_details', 
            compact('order_details', 'referrer', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('logistics::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('logistics::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('logistics::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}