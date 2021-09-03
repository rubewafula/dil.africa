<?php

namespace Modules\Logistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use  App\Trip;

use Session;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request  $request)
    {
        if(!empty($request->search))
        { 
          
           $trips =  Trip::where('name','LIKE','%'.$request->search.'%')
           ->orWhere('vehicle_id','=', Vehicle::where('registration_no', 'LIKE','%'.$request->search.'%')->first()->id)
           ->Orderby('id','DESC')->paginate(20);

        } else{

            $trips =  Trip::Orderby('id','DESC')->paginate(20);

        }
        return  view('logistics::trips.index',compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('logistics::trips.create');
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
            'name' => 'required',
            'vehicle_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        Trip::create($requestData);

        return redirect('logistics/trips')->with('flash_message', 'Trip added successfully!');
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
        $trip = Trip::findOrFail($id);

        return view('logistics::trips.show', compact('trip'));
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
        $trip = Trip::findOrFail($id);

        return view('logistics::trips.edit', compact('trip'));
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
            'name' => 'required',
            'vehicle_id' => 'required'
        ]); 
        $requestData = $request->all();
        
        $trip = Trip::findOrFail($id);
        $trip->update($requestData);

        return redirect('logistics/trips')->with('flash_message', 'Trip details updated successfully!');
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
        Trip::destroy($id);

        return redirect('logistics/trips')->with('flash_message', 'Trip deleted successfully!');
    }
}