<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fourth_category;
use Illuminate\Http\Request;

class Fourth_categoriesController extends Controller
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
            $fourth_categories = Fourth_category::where('mini_category_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('cover_photo', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fourth_categories = Fourth_category::latest()->paginate($perPage);
        }

        return view('backend.fourth_categories.index', compact('fourth_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.fourth_categories.create');
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
        
        Fourth_category::create($requestData);

        return redirect('backend/fourth_categories')->with('flash_message', 'Fourth_category added!');
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
        $fourth_category = Fourth_category::findOrFail($id);

        return view('backend.fourth_categories.show', compact('fourth_category'));
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
        $fourth_category = Fourth_category::findOrFail($id);

        return view('backend.fourth_categories.edit', compact('fourth_category'));
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
        
        $fourth_category = Fourth_category::findOrFail($id);
        $fourth_category->update($requestData);

        return redirect('backend/fourth_categories')->with('flash_message', 'Fourth_category updated!');
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
        Fourth_category::destroy($id);

        return redirect('backend/fourth_categories')->with('flash_message', 'Fourth_category deleted!');
    }
}
