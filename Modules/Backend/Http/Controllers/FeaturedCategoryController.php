<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Featured_category;
use Illuminate\Http\Request;

class FeaturedCategoryController extends Controller
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

        $featured_categories = Featured_category::latest()->paginate($perPage);

        return view('backend::featured_categories.index', compact('featured_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::featured_categories.create');
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
        
        Featured_category::create($requestData);

        return redirect('backend/featured-categories')->with('flash_message', 'Featured category added successfully!');
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
        $featured_category = Featured_category::findOrFail($id);

        return view('backend::featured_categories.show', compact('featured_category'));
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
        $featured_category = Featured_category::findOrFail($id);

        return view('backend::featured_categories.edit', compact('featured_category'));
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
        
        $featured_category = Featured_category::findOrFail($id);
        $featured_category->update($requestData);

        return redirect('backend/featured-categories')->with('flash_message', 'Featured category updated!');
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
        Featured_category::destroy($id);

        return redirect('backend/featured_categories')->with('flash_message', 'Featured category deleted!');
    }

}