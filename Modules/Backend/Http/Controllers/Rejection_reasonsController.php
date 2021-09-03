<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Rejection_reason;
use Illuminate\Http\Request;

class Rejection_reasonsController extends Controller
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
            $rejection_reasons = Rejection_reason::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $rejection_reasons = Rejection_reason::latest()->paginate($perPage);
        }

        return view('backend::rejection_reasons.index', compact('rejection_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::rejection_reasons.create');
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
        
        Rejection_reason::create($requestData);

        return redirect('backend/rejection_reasons')->with('flash_message', 'Rejection_reason added!');
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
        $rejection_reason = Rejection_reason::findOrFail($id);

        return view('backend::rejection_reasons.show', compact('rejection_reason'));
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
        $rejection_reason = Rejection_reason::findOrFail($id);

        return view('backend::rejection_reasons.edit', compact('rejection_reason'));
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
        
        $rejection_reason = Rejection_reason::findOrFail($id);
        $rejection_reason->update($requestData);

        return redirect('backend/rejection_reasons')->with('flash_message', 'Rejection_reason updated!');
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
        Rejection_reason::destroy($id);

        return redirect('backend/rejection_reasons')->with('flash_message', 'Rejection_reason deleted!');
    }
}
