<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cancellation_reason;
use Illuminate\Http\Request;

class Cancellation_reasonsController extends Controller
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
            $cancellation_reasons = Cancellation_reason::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $cancellation_reasons = Cancellation_reason::latest()->paginate($perPage);
        }

        return view('backend::cancellation_reasons.index', compact('cancellation_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::cancellation_reasons.create');
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
        
        Cancellation_reason::create($requestData);

        return redirect('backend/cancellation_reasons')->with('flash_message', 'Cancellation_reason added!');
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
        $cancellation_reason = Cancellation_reason::findOrFail($id);

        return view('backend::cancellation_reasons.show', compact('cancellation_reason'));
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
        $cancellation_reason = Cancellation_reason::findOrFail($id);

        return view('backend::cancellation_reasons.edit', compact('cancellation_reason'));
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
        
        $cancellation_reason = Cancellation_reason::findOrFail($id);
        $cancellation_reason->update($requestData);

        return redirect('backend/cancellation_reasons')->with('flash_message', 'Cancellation_reason updated!');
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
        Cancellation_reason::destroy($id);

        return redirect('backend/cancellation_reasons')->with('flash_message', 'Cancellation_reason deleted!');
    }
}
