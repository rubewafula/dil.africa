<?php

namespace Modules\Logistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use  App\Trip_returned_order_detail;

use Session;

class TripReturnOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request  $request)
    {
       
        $trip_returned_order_details =  Trip_returned_order_detail::Orderby('id','DESC')->get();

        return  view('logistics::trip_orders.returns.index',compact('trip_returned_order_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('logistics::trip_orders.returns.create');
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
            'order_id' => 'required',
            'order_detail_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        Trip_returned_order_detail::create($requestData);

        return redirect('logistics/trip_orders/returns')->with('flash_message', 'Return added successfully!');
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
        $trip_returned_order_detail = Trip_returned_order_detail::findOrFail($id);

        return view('logistics::trip_orders.returns.show', compact('trip_returned_order_detail'));
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
        $trip_returned_order_detail = Trip_returned_order_detail::findOrFail($id);

        return view('logistics::trip_orders.returns.edit', compact('trip_returned_order_detail'));
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
            'order_id' => 'required',
            'order_detail_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        $trip_returned_order_detail = Trip_returned_order_detail::findOrFail($id);
        $trip->update($requestData);

        return redirect('logistics/trip_orders/returns')->with('flash_message', 'Return details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Trip_returned_order_detail::destroy($id);

        return redirect('logistics/trip_orders/returns')->with('flash_message', 'Return deleted successfully!');
    }
}