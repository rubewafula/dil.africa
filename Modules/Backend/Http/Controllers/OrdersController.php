<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\Order;
use  Carbon\Carbon;
use Auth;
use  App\Notifications\CancelledOrder;
use  App\User;
use  Session;
use  App\Seller_order;
use  App\Order_note;
use  App\Seller;

use App\Outbox;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('backend::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('backend::create');
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
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('backend::edit');
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


    public  function  manage($id)
    {
     
     $order= Order::findorfail($id);
     $title= 'Manage  Order';

     return  view('backend::orders.manage_order',compact('order','title'));

    }


    public  function  cancel_order($id)
    {

      $order=  Order::findOrFail($id);
      $title='Manage  Order #'.$order->id;

      return  view('backend::customers.cancel_order',compact('order','title'));

    }


    public  function  post_cancel_order(Request  $request)
    {
        $request->validate([
            'order_id'=>'required',

        ]);
         $order=  Order::find($request->order_id);
         $requestData= $request->all();
         $requestData['order_status']='CANCELLED';
         $requestData['cancel_date']= Carbon::now();
         $requestData['cancelled_by']=Auth::user()->id;
         $order->update($requestData);

         $user= User::find($order->user_id);
         //notify  customer  of  cancelled  order
         $user->notify(new CancelledOrder($user,$order));

         //notify seller of  cancelled  order
         
         Session::flash('flash_message','Order  was cancelled');
         return  redirect('backend/orders');

    }


    public  function  accept_order($id)
    {

        $order =  Order::find($id);

        $order->order_status ='VALIDATED';
        $order->validated_on = Carbon::now();
        $order->validated_by = Auth::user()->id;

        $order->save();
         
        Session::flash('flash_message','The order has been accepted successfully');
        return  redirect('backend/orders');
    }


    public  function  post_note(Request  $request)
    {

        $request->validate([
            'note'=>'required'
        ]);
     
         Order_note::create($request->all());

        Session::flash('flash_message','Successful');

        return  redirect()->back();

    }

    public  function  delete_note($id)
    {
        Order_note::where('id',$id)->delete();

        Session::flash('flash_message','Successful');

        return  redirect()->back();

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
        $order = Order::find($order_id);

        Order::where('id', $order_id)->update(["order_status" => "CONFIRMED"]);

        $outbox = new Outbox();

        foreach($order->seller_orders()->get() as $order_detail) {

            $seller = Seller::find($order_detail->seller_id);

            if($seller == null){
                
                continue;
            }

            $user = User::where('seller_id', $seller->id)->first();

            if($user == null){
                continue;
            }

            $message = 'Dear '.$user->first_name.', You have a new order from DIL.AFRICA. Please see your order at https://dil.africa/seller. Kindly note that you need to accept the order within 1 hour.';

            $outbox->user_id = $user->id;
            $phone = $seller->telephone;

            if($phone == null){

                $phone = $user->contact_telephone;
            }

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