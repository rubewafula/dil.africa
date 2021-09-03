<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use Illuminate\Http\Request;
use  App\Category_size;
use  App\Category_brand;
use  Session;

class CategoriesController extends Controller
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
            $categories = Category::where('name', 'LIKE', "%$keyword%")
                               ->latest()->get();
        } else {
            $categories = Category::latest()->get();
        }

        return view('backend::categories.index', compact('categories'));
    }


    public  function  add_category_sizes(Request  $request)
    {
       $request->validate([
        'category_id'=>'required',

       ]);

       Category_size::Create($request->all());
       Session::flash('flash_message','Size added successfully to the category');
        return  redirect()->back();
    }

    public  function  remove_category_size($id)
    {
        Category_size::destroy($id);
         Session::flash('flash_message','Size removed successfully from the category');
        return  redirect()->back();
    }


    public  function  add_category_brand(Request  $request)
    {
       $request->validate([
        'category_id'=>'required',
       ]);

       if(Category_brand::where('category_id', $request->category_id)->where('brand_id', $request->brand_id)->first() != null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message','The selected category is already attached to that brand!');
            return  redirect()->back();
       }
       Category_brand::create($request->all());
       Session::flash('flash_message','Category added successfully to the brand');
       return  redirect()->back();
    }

    public  function  remove_brand_category($id)
    {
        Category_brand::destroy($id);
        Session::flash('flash_message','Category removed from the brand successfully');
        return  redirect()->back();
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::categories.create');
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
			'name' => 'required',
			//'cover_photo' => 'required'
		]);


        $requestData = $request->all();

         $slug= str_slug($request->name);
         if(\App\Category::where('slug',$slug)->exists())
         {

            $slug= $slug.rand(100,600);

         }

           $requestData['slug']= $slug;

           if($request->hasFile('cover_photo'))
           {

          $destinationPath = 'categories';

           $file=$request->file('cover_photo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);

                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['cover_photo'] = $destinationPath.'/'.$filename;
        }

          $requestData['priority'] = 1000;
          Category::create($requestData);

        return redirect('backend/categories')->with('flash_message', 'Category added!');
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
        $category = Category::findOrFail($id);

        return view('backend::categories.show', compact('category'));
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
        $category = Category::findOrFail($id);

        return view('backend::categories.edit', compact('category'));
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
			'name' => 'required',
			//'cover_photo' => 'required'
		]);
        $requestData = $request->all();

        if($request->hasFile('cover_photo'))
        {

             $destinationPath = 'categories';

           $file=$request->file('cover_photo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['cover_photo'] = $destinationPath.'/'.$filename;
        }

        
        
        $category = Category::findOrFail($id);
        $category->update($requestData);

        return redirect('backend/categories')->with('flash_message', 'Category updated!');
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
        Category::destroy($id);

        return redirect('backend/categories')->with('flash_message', 'Category deleted!');
    }
}
