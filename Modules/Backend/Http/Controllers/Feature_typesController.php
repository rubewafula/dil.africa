<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Feature_type;
use Illuminate\Http\Request;

class Feature_typesController extends Controller
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
            $feature_types = Feature_type::
                Where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $feature_types = Feature_type::latest()->paginate($perPage);
        }

        return view('backend::feature_types.index', compact('feature_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::feature_types.create');
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
            'level_2_category'=>'required',
            'name'=>'required'
         ]);        
        $requestData = $request->all();
        
        Feature_type::create($requestData);

        return redirect('backend/feature_types')->with('flash_message', 'Feature_type added!');
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
        $feature_type = Feature_type::findOrFail($id);

        return view('backend::feature_types.show', compact('feature_type'));
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
        $feature_type = Feature_type::findOrFail($id);

        return view('backend::feature_types.edit', compact('feature_type'));
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
            'level_2_category'=>'required',
            'name'=>'required'
         ]);       
        
        $requestData = $request->all();
        
        $feature_type = Feature_type::findOrFail($id);
        $feature_type->update($requestData);

        return redirect('backend/feature_types')->with('flash_message', 'Feature_type updated!');
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
        Feature_type::destroy($id);

        return redirect('backend/feature_types')->with('flash_message', 'Feature_type deleted!');
    }
}
