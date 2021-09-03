<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fifth_category;
use Illuminate\Http\Request;

class Fifth_categoriesController extends Controller
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
            $fifth_categories = Fifth_category::where('fourth_category_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('cover_photo', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fifth_categories = Fifth_category::latest()->paginate($perPage);
        }

        return view('backend.fifth_categories.index', compact('fifth_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.fifth_categories.create');
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
        
        Fifth_category::create($requestData);

        return redirect('backend/fifth_categories')->with('flash_message', 'Fifth_category added!');
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
        $fifth_category = Fifth_category::findOrFail($id);

        return view('backend.fifth_categories.show', compact('fifth_category'));
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
        $fifth_category = Fifth_category::findOrFail($id);

        return view('backend.fifth_categories.edit', compact('fifth_category'));
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
        
        $fifth_category = Fifth_category::findOrFail($id);
        $fifth_category->update($requestData);

        return redirect('backend/fifth_categories')->with('flash_message', 'Fifth_category updated!');
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
        Fifth_category::destroy($id);

        return redirect('backend/fifth_categories')->with('flash_message', 'Fifth_category deleted!');
    }
}
