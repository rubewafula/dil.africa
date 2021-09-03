<?php

namespace Modules\Logistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use  App\Trip;
use  App\Trip_order;
use  App\Order;
use  App\Order_detail;

use Session;

class TripOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request  $request, $id)
    {

        $trip = Trip::find($id);
        $trip_orders =  Trip_order::Orderby('id','DESC')->get();

        return  view('logistics::trips.orders.index',compact('trip','trip_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {

        $trip = Trip::find($id);

        $orders = Order::where(['order_status'=>'QUALITY_PASSED'])
            ->orderBy('id', 'DESC')->get();
            
        return view('logistics::trips.orders.create', compact('trip', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'trip_id' => 'required',
            'order_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        Trip_order::create($requestData);

        return redirect('logistics/trips/orders')->with('flash_message', 'Order added to the trip successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $trip_order = Trip_order::findOrFail($id);

        return view('logistics::trips.orders.show', compact('trip_order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $trip_order = Trip_order::findOrFail($id);

        return view('logistics::trips.orders.edit', compact('trip_order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'trip_id' => 'required',
            'order_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        $trip_order = Trip_order::findOrFail($id);
        $trip_order->update($requestData);

        return redirect('logistics/trips/orders')->with('flash_message', 'Trip order details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, $order_id)
    {

        $trip_order = Trip_order::find($id);

        $order_status = Order::find($trip_order->order_id)->order_status;

        if($order_status != 'SCHEDULED'){

            return redirect('logistics/trips/orders')->with('flash_message_error', 'You cannot remove this order from the trip as it has already moved from the scheduled status!');
        }

        Trip_order::destroy($id);
        Order::where('id', $order_id)->update(['order_status' => 'QUALITY_PASSED']);

        return redirect('logistics/trips/orders')->with('flash_message', 'Trip order deleted successfully!');
    }

    public function remove_order_from_trip($id)
    {

        $trip_order = Trip_order::find($id);

        $order_status = Order::find($trip_order->order_id)->order_status;

        if($order_status != 'SCHEDULED'){

            return redirect(url()->previous())->with('flash_message_error', 'You cannot remove this order from the trip as it has already moved from the scheduled status!');
        }

        Trip_order::destroy($id);
        Order::where('id', $trip_order->order_id)->update(['order_status' => 'QUALITY_PASSED']);

        return redirect(url()->previous())->with('flash_message', 'Trip order deleted successfully!');
    }

    public function add_order_to_trip($trip_id, $order_id){

        $trip_order = Trip_order::where('trip_id', $trip_id)
            ->where('order_id', $order_id)->first();

        if($trip_order != null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'The selected order has already been added to the trip');
            return redirect(url()->previous());
        }

        $trip_order = new Trip_order();
        $trip_order->order_id = $order_id;
        $trip_order->trip_id = $trip_id;

        $trip_order->save();

        Order::where('id', $order_id)->update(['order_status' => 'SCHEDULED']);

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order added to the trip successfully');
        return redirect(url()->previous());
    }

    public function trip_order_details($id){

        $trip_order = Trip_order::find($id);

        $trip = Trip::find($trip_order->trip_id);
        $order = Order::find($trip_order->order_id);

        $order_details = Order_detail::where('order_id', $trip_order->order_id)->get();

        return view('logistics::trips.orders.details', compact('order_details', 'trip', 'order'));
    }

    public function dispatch_orders($id){

        $trip_orders = Trip_order::where('trip_id', $id)->get();

        foreach ($trip_orders as $trip_order) {
            
            Order::where('id', $trip_order->order_id)->update(['order_status' => 'DISPATCHED']);
        }

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Orders in the trip dispatched successfully');
        return redirect(url()->previous());
    }

    public function mark_order_as_delivered($id){
            
        Order::where('id', $id)->update(['order_status' => 'DELIVERED']);
        Order_detail::where('order_id', $id)->update(['delivery_status' => 'DELIVERED']);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order marked as delivered successfully');
        return redirect(url()->previous());
    }

    public function mark_orderdetail_as_delivered($id){
            
        $order_id = Order_detail::find($id)->order_id;
        Order_detail::where('id', $id)->update(['delivery_status' => 'DELIVERED']);

        Order::where('id', $order_id)->update(['order_status' => 'PARTIALLY_DELIVERED']);
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order item marked as delivered successfully');
        return redirect(url()->previous());
    }

    public function mark_order_as_returned(Request $request){
        
        $id = $request->order_id;
        $return_comments = $request->return_comments;

        Order::where('id', $id)->update(['order_status' => 'RETURNED', 'return_comments' => $return_comments]);
        Order_detail::where('order_id', $id)->update(['delivery_status' => 'RETURNED']);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order marked as returned successfully');
        return redirect(url()->previous());
    }

    public function mark_orderdetail_as_returned(Request $request){
            
        $id = $request->order_detail_id;
        $return_comments = $request->return_comments;

        $order_id = Order_detail::find($id)->order_id;
        Order_detail::where('id', $id)->update(['delivery_status' => 'RETURNED']);

        Order::where('id', $order_id)->update(['order_status' => 'PARTIALLY_RETURNED']);
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order item marked as returned successfully');
        return redirect(url()->previous());
    }
}