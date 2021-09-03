<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\Seller_order;
use  App\Order;
use  Session;
use  App\Order_note;
use  App\Product;
use  Auth;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('accounts::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounts::create');
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
        return view('accounts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('accounts::edit');
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


    public  function orders()
    {
    
     $orders= Seller_order::WhereHas('seller',function($query){

        $query->where('account_manager',Auth::user()->id);

     })->OrderBy('id','DESC')->paginate(5);

     return  view('accounts::sellers.orders',compact('orders'));

    }


    public  function  seller_order($id)
    {
      
        
        $order= Seller_order::find($id);

        return view('accounts::sellers.seller_order',compact('order'));

    }


    public  function  confirm_order($id)
    {

        $order= Seller_order::find($id);
        $order->order_status= 'ACCEPTED';
        $order->confirmed_date= date('Y:m:d H:i:s');
        $order->save();
        Session::flash('flash_message',' You  have  confirmed  Seller  Order');
         return  redirect()->back();

    }

    public  function  post_note(Request  $request)
    {
      $request->validate([
        'note'=>'required'
      ]);

      $note= Order_note::create($request->all());
      Session::flash('flash_message','Note  was added');
      return  redirect()->back();
    }

    public  function  cancel_order($id)
    {

        $order= Seller_order::find($id);
        $order->order_status= 'CANCELLED';
        $order->cancelled_date= date('Y:m:d H:i:s');
        Session::flash('flash_message','The  order  was cancelled');
          return  redirect()->back();

    }


    public function  delete_note($id)
    {

        Order_note::destroy($id);
         Session::flash('flash_message','Order  note  was  deleted');
          return  redirect()->back();
    }


    public  function  products()
    {


        
    }



    public  function  login()
    {
     
     return  view('accounts::auth.login');


    }





}
