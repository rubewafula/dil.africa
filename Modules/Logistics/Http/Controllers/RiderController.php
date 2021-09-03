<?php

namespace Modules\Logistics\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Country;
use Illuminate\Http\Request;

use  App\Vehicle;
use  App\Trip;
use  App\Rider;

use Session;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request  $request)
    {
        if(!empty($request->search))
        { 
          
           $riders=  Rider::where('name','LIKE','%'.$request->search.'%')
           ->orWhere('email','LIKE','%'.$request->search.'%')
           ->orWhere('phone','LIKE','%'.$request->search.'%')
           ->orWhere('gender','LIKE','%'.$request->search.'%')
           ->orWhere('id_number','LIKE','%'.$request->search.'%')
           // ->orWhere('vehicle_id','=', Vehicle::where('registration_no', 'LIKE','%'.$request->search.'%')->first()->id)
           ->Orderby('id','DESC')->paginate(20);

        } else{

            $riders=  Rider::Orderby('id','DESC')->paginate(20);

        }
        return  view('logistics::riders.index',compact('riders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('logistics::riders.create');
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
            'name' => 'required'
        ]); 
        $requestData = $request->all();

        if(Rider::where('id_number', $requestData['id_number'])->first() != null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'A rider with the same ID number already exists. Please verify!');
            return redirect('logistics/riders');
        }
        
        Rider::create($requestData);

        return redirect('logistics/riders')->with('flash_message', 'Rider added successfully!');
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
        $rider = Rider::findOrFail($id);

        return view('logistics::riders.show', compact('rider'));
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
        $rider = Rider::findOrFail($id);

        return view('logistics::riders.edit', compact('rider'));
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
            'name' => 'required'
        ]);
        $requestData = $request->all();
        
        $rider = Rider::findOrFail($id);
        $rider->update($requestData);

        return redirect('logistics/riders')->with('flash_message', 'Rider details updated successfully!');
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
        Rider::destroy($id);

        return redirect('logistics/riders')->with('flash_message', 'Rider deleted successfully!');
    }
}