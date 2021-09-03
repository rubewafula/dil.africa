<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Special_shipping_rate;
use Illuminate\Http\Request;
use  Session;

class Special_shipping_ratesController extends Controller
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
            $special_shipping_rates = Special_shipping_rate::where('zone_id', 'LIKE', "%$keyword%")
                ->orWhere('item_size_id', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $special_shipping_rates = Special_shipping_rate::latest()->paginate($perPage);
        }

        return view('backend::special_shipping_rates.index', compact('special_shipping_rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::special_shipping_rates.create');
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
    		'status'=>'required',
            'order_amount' => 'required',
            'amount_charged' => 'required'
    	]);

    	if(Special_shipping_rate::where([
    		'zone_id'=>$request->zone_id,
    		'item_size_id'=>$request->item_size_id])->exists())
    	{
    		Session::flash('flash_message','The rate already  exists');
    		Session::flash('alert-class','alert-danger');

    		return  redirect()->back();


    	}
        
        $requestData = $request->all();
        
        Special_shipping_rate::create($requestData);

        return redirect('backend/special-shipping')->with('flash_message', 'Special shipping rate added!');
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
        $special_shipping_rate = Special_shipping_rate::findOrFail($id);

        return view('backend::special_shipping_rates.show', compact('special_shipping_rate'));
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
        $special_shipping_rate = Special_shipping_rate::findOrFail($id);

        return view('backend::special_shipping_rates.edit', compact('special_shipping_rate'));
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
    		'order_amount'=>'required',
            'amount_charged'=>'required',
    		'status'=>'required'
    	]);
        
        
        $requestData = $request->all();
        
        $special_shipping_rate = Special_shipping_rate::findOrFail($id);
        $special_shipping_rate->update($requestData);

        return redirect('backend/special-shipping')->with('flash_message', 'Special shipping rate updated!');
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
        Special_shipping_rate::destroy($id);

        return redirect('backend/special-shipping')->with('flash_message', 'Special shipping rate deleted!');
    }
}