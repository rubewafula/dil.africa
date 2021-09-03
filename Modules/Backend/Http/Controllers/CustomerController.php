<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\User;
use  App\User_note;
use  Session;
use  Auth;
use  App\Order;
use  App\Seller;
use App\Order_detail;
use App\User_address;

use App\Product_price;
use App\Product;
use App\Seller_order;

use PDF;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request  $request)
    {
        $title= 'Manage  Customer';
        
        if($request->has('search'))
        {
            // Search  time 

            if(!empty($request->id))
            {

                //search  by primary  key

            $customers=  User::where(['id'=>$request->id])->OrderBy('id','DESC')->paginate(5); 

            } else{

                $customers=  User::where('is_customer',1)->where(function($query) use ($request){

                    if(!empty($request->first_name))
                    {

                     $query->Where('first_name','like','%'.$request->first_name.'%');
                    }
                        if(!empty($request->last_name))
                    {

                     $query->orWhere('last_name','like','%'.$request->last_name.'%');
                    }
                    if(!empty($request->email))
                    {

                     $query->orWhere('email',$request->email);
                    }

                        if(!empty($request->active))
                    {

                     $query->Where('active',$request->active);
                    }

                })->OrderBy('id','DESC')->paginate(5);

            }

       //     dd($customers);

        } else{


             $customers=  User::where('is_customer',1)->OrderBy('id','DESC')->paginate(5); 
        }

        return view('backend::customers.index',compact('customers','title'));

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




    public function  manage_customer($id)
    {

      $customer=User::findorfail($id);
              $title= 'Manage  Customer';


      return  view('backend::customers.manage_customer',compact('customer','title'));

    }

    public  function  add_note(Request  $request)
    {

        $request->validate([
            'note'=>'required',
            'user_id'=>'required'
        ]);
        
        User_note::create([
            'user_id'=>$request->user_id,
            'note'=>$request->note,
            'created_by'=>Auth::user()->id
        ]);

        Session::flash('flash_message','updated');

        return  redirect()->back();

    }

    public  function  delete_note($id)
    {
    
    User_note::destroy($id);
    Session::flash('flash_message','Deleted');
    return  redirect()->back();
    }

    public  function  order($id)
    {
     
     $order= Order::findorfail($id);
     $title= 'Manage Order';

     return  view('backend::customers.customer_order',compact('order','title'));
     
    }


    public  function  waybill($id)
    {
     
         $order = Order::findorfail($id);
         $title= 'Waybill - Order Reference '.$order->order_reference;

         $shipping_type = $order->shipping_type_id;

         $user_address = User_address::find($order->user_address_id);

         $pdf = PDF::loadView('backend::orders.waybill',compact('order','title', 'user_address'));
         // $pdf->setPaper('A4', 'landscape');

         return $pdf->Stream($title.'.pdf');

         // return view('backend::orders.waybill',compact('order','title', 'user_address'));
     
    }


    public  function  po($order_detail_id)
    {
     
         $order_detail = Order_detail::find($order_detail_id);
         $order_id = $order_detail->order_id;
         $order = Order::find($order_id);

         $product_price_id = $order_detail->product_price_id;

         $product_price = Product_price::find($product_price_id);

         if($product_price != null){

            $product = Product::findorfail($product_price->product_id);
            $seller = Seller::find($product->seller_id);

         }else {

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'There is no record for pricing found.');

            return redirect(url()->previous());
         }

         $seller_orders = Seller_order::where('seller_id', $seller->id)
            ->where('order_id', $order_id)->get();

         $title= 'Purchase Order - Reference '.$order->order_reference;

         $shipping_type = $order->shipping_type_id;

         $user_address = User_address::find($order->user_address_id);

         $pdf = PDF::loadView('backend::orders.po', compact('order','title', 'seller', 'seller_orders'));

         return $pdf->Stream($title.'.pdf');

         // return view('backend::orders.po',compact('order','title', 'seller', 'seller_orders'));
     
    }
}
