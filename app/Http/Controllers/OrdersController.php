<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use Illuminate\Http\Request;

use App\Outbox;
use  App\Seller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $orders = Order::where('user_id', 'LIKE', "%$keyword%")
                ->orWhere('order_status', 'LIKE', "%$keyword%")
                ->orWhere('total_value', 'LIKE', "%$keyword%")
                ->orWhere('payment_status', 'LIKE', "%$keyword%")
                ->orWhere('payment_gateway_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $orders = Order::latest()->paginate($perPage);
        }

        return view('backend.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.orders.create');
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
        
        $requestData = $request->all();
        
        Order::create($requestData);

        return redirect('backend/orders')->with('flash_message', 'Order added!');
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
        $order = Order::findOrFail($id);

        return view('backend.orders.show', compact('order'));
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
        $order = Order::findOrFail($id);

        return view('backend.orders.edit', compact('order'));
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
        
        $requestData = $request->all();
        
        $order = Order::findOrFail($id);
        $order->update($requestData);

        return redirect('backend/orders')->with('flash_message', 'Order updated!');
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
        Order::destroy($id);

        return redirect('backend/orders')->with('flash_message', 'Order deleted!');
    }

    public  function  cancel_order($id)
    {

      $order=  Order::findOrFail($id);

      return  view('backend::customers.cancel_order',compact('order'));

    }

    public  function  markaspaid(Request $request){

        $order_id = $request->order_id;

        Order::where('id', $order_id)->update(["payment_status" => "PAID"]);

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order marked as paid successfully');

        return redirect(url()->previous());
    }


    public  function  markasconfirmed(Request $request){

        $order_id = $request->order_id;
        $order = Order::findorfail($order_id);

        Order::where('id', $order_id)->update(["order_status" => "CONFIRMED"]);

        $outbox = new Outbox();

        foreach($order->seller_orders()->get() as $order_detail) {

            $seller = Seller::findorfail($order_detail->seller_id);

            if($seller == null){
                continue;
            }

            $user = User::where('seller_id', $seller->id)->first();

            if($user == null){
                continue;
            }

            $message = "Dear ".$user->first_name.", you have a new order from DIL.AFRICA. Access the order at https://dil.africa/seller and confirm within 1 hour";

            $outbox->user_id = $user->id;
            $phone = $seller->telephone;

            if($phone == null){

                $phone = $user->phone;
            }
            if($phone == null){
                continue;
            }

            $outbox->msisdn = $phone;
            $outbox->message = $message;
            $outbox->status = 0;

            $outbox->save();
        }

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Order marked as confirmed successfully');

        return redirect(url()->previous());
    }
}
