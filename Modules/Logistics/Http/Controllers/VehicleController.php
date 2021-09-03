<?php

namespace Modules\Logistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use  App\Vehicle;

use Session;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request  $request)
    {
        if(!empty($request->search))
        { 
          
           $vehicles =  Vehicle::where('registration_no','LIKE','%'.$request->search.'%')
           ->orWhere('vehicle_type','LIKE','%'.$request->search.'%')
           ->orWhere('owner_name','LIKE','%'.$request->search.'%')
           ->orWhere('capacity','LIKE','%'.$request->search.'%')
           ->Orderby('id','DESC')->paginate(20);

        } else{

            $vehicles =  Vehicle::Orderby('id','DESC')->paginate(20);

        }
        return  view('logistics::vehicles.index',compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('logistics::vehicles.create');
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
            'registration_no' => 'required',
            'vehicle_type' => 'required',
            'capacity' => 'required',
            'owner_name' => 'required'
        ]); 
        $requestData = $request->all();

        if(Vehicle::where('registration_no', $requestData['registration_no'])->first() != null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'A vehicle with the same registration number already exists. Please verify!');
            return redirect('logistics/vehicles');
        }
        
        Vehicle::create($requestData);

        return redirect('logistics/vehicles')->with('flash_message', 'Vehicle added successfully!');
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
        $vehicle = Vehicle::findOrFail($id);

        return view('logistics::vehicles.show', compact('vehicle'));
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
        $vehicle = Vehicle::findOrFail($id);

        return view('logistics::vehicles.edit', compact('vehicle'));
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
            'registration_no' => 'required',
            'vehicle_type' => 'required',
            'capacity' => 'required',
            'owner_name' => 'required'
        ]); 
        $requestData = $request->all();
        
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($requestData);

        return redirect('logistics/vehicles')->with('flash_message', 'Vehicle details updated successfully!');
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
        Vehicle::destroy($id);

        return redirect('logistics/vehicles')->with('flash_message', 'Vehicle deleted successfully!');
    }
}