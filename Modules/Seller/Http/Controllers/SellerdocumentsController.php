<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\Seller_order;

class SellerdocumentsController extends Controller
{



     public  function  invoice($order_id)
     {
      
      $seller_order= Seller_order::findorfail($order_id);

      return  view('seller::documents.invoice',compact('seller_order'));

      
     }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('seller::index');
    }




    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('seller::create');
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
        return view('seller::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('seller::edit');
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
