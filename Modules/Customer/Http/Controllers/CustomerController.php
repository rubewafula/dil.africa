<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;

use Modules\Customer\Entities\History_visit;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('customer::index');
    }

    
    public function product_detail(Request $request, $id)
    {
        $ip_address = $request->ip();
        
        $user_id = null;
        
        if(Auth::check()){
            
            $user_id = Auth::user()->id;
        }
        
        $history_visit = new History_visit();
        
        $history_visit->ip_address = $ip_address;
        $history_visit->product_id = $id;
        $history_visit->user_id = $user_id;
        
        $history_visit->save();
        
        $related = History_visit::where('ip_address', '!=', $ip_address)
                ->where('product_id', $id)->orderBy('id', 'DESC')->limit(10)->get();
        
        $related_products = [];
        
        foreach($related as $rel){
            
            $viewed = History_visit::where('product_id', '!=', $rel->product_id)
                    ->where('ip_address', $rel->ip_address)->limit(3)->get();
            
            array_push($related_products, $viewed);
        }
        
        return view('modules/customer/product/index',
                compact('related_products'));
    }

    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('customer::create');
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
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('customer::edit');
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