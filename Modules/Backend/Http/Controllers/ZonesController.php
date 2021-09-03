<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Zone;
use Illuminate\Http\Request;

class ZonesController extends Controller
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
            $zones = Zone::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $zones = Zone::latest()->paginate($perPage);
        }

        return view('backend::zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::zones.create');
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
        
        Zone::create($requestData);

        return redirect('backend/zones')->with('flash_message', 'Zone added!');
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
        $zone = Zone::findOrFail($id);

        return view('backend::zones.show', compact('zone'));
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
        $zone = Zone::findOrFail($id);

        return view('backend::zones.edit', compact('zone'));
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
        
        $zone = Zone::findOrFail($id);
        $zone->update($requestData);

        return redirect('backend/zones')->with('flash_message', 'Zone updated!');
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
        Zone::destroy($id);

        return redirect('backend/zones')->with('flash_message', 'Zone deleted!');
    }
}
