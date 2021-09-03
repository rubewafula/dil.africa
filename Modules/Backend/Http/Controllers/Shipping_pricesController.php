<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Shipping_price;
use Illuminate\Http\Request;
use  Session;

class Shipping_pricesController extends Controller
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
            $shipping_prices = Shipping_price::where('zone_id', 'LIKE', "%$keyword%")
                ->orWhere('shipping_type_id', 'LIKE', "%$keyword%")
                ->orWhere('item_size_id', 'LIKE', "%$keyword%")
                ->orWhere('price_one', 'LIKE', "%$keyword%")
                ->orWhere('price_many', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $shipping_prices = Shipping_price::latest()->paginate($perPage);
        }

        return view('backend::shipping_prices.index', compact('shipping_prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::shipping_prices.create');
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

    	$request->validate([
    		'zone_id'=>'required',
    		'shipping_type_id'=>'required',
    		'item_size_id'=>'required',
    		'price_one'=>'required',
    		'price_many'=>'required'
    	]);

    	if(Shipping_price::where([
    		'zone_id'=>$request->zone_id,
    		'shipping_type_id'=>$request->shipping_type_id,
    		'item_size_id'=>$request->item_size_id])->exists())
    	{
    		Session::flash('flash_message','The price  already  exists');
    		Session::flash('alert-class','alert-danger');

    		return  redirect()->back();


    	}
        
        $requestData = $request->all();
        
        Shipping_price::create($requestData);

        return redirect('backend/shipping_prices')->with('flash_message', 'Shipping_price added!');
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
        $shipping_price = Shipping_price::findOrFail($id);

        return view('backend::shipping_prices.show', compact('shipping_price'));
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
        $shipping_price = Shipping_price::findOrFail($id);

        return view('backend::shipping_prices.edit', compact('shipping_price'));
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

    		$request->validate([
    		'zone_id'=>'required',
    		'shipping_type_id'=>'required',
    		'item_size_id'=>'required',
    		'price_one'=>'required',
    		'price_many'=>'required'
    	]);
        
        
        $requestData = $request->all();
        
        $shipping_price = Shipping_price::findOrFail($id);
        $shipping_price->update($requestData);

        return redirect('backend/shipping_prices')->with('flash_message', 'Shipping_price updated!');
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
        Shipping_price::destroy($id);

        return redirect('backend/shipping_prices')->with('flash_message', 'Shipping_price deleted!');
    }
}
