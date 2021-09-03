<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Suspension_reason;
use Illuminate\Http\Request;

class Suspension_reasonsController extends Controller
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
            $suspension_reasons = Suspension_reason::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $suspension_reasons = Suspension_reason::latest()->paginate($perPage);
        }

        return view('backend::suspension_reasons.index', compact('suspension_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::suspension_reasons.create');
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
        
        $requestData = $request->all();
        
        Suspension_reason::create($requestData);

        return redirect('backend/suspension_reasons')->with('flash_message', 'Suspension_reason added!');
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
        $suspension_reason = Suspension_reason::findOrFail($id);

        return view('backend::suspension_reasons.show', compact('suspension_reason'));
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
        $suspension_reason = Suspension_reason::findOrFail($id);

        return view('backend::suspension_reasons.edit', compact('suspension_reason'));
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
        
        $requestData = $request->all();
        
        $suspension_reason = Suspension_reason::findOrFail($id);
        $suspension_reason->update($requestData);

        return redirect('backend/suspension_reasons')->with('flash_message', 'Suspension_reason updated!');
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
        Suspension_reason::destroy($id);

        return redirect('backend/suspension_reasons')->with('flash_message', 'Suspension_reason deleted!');
    }


    public  function  get_reasons()
    {
       $reasons=  Suspension_reason::select('name','id')->get();

       return  $reasons;

    }
}
