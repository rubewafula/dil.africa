<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sub_category;
use Illuminate\Http\Request;
use Session;
use Storage;
use File;

class Sub_categoriesController extends Controller
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
            $sub_categories = Sub_category::where('category_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $sub_categories = Sub_category::latest()->paginate($perPage);
        }

        return view('backend::sub_categories.index', compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::sub_categories.create');
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
			'cover_photo' => 'required'
		]);
        $requestData = $request->all();

          $destinationPath = 'subs';

           $file=$request->file('cover_photo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['cover_photo'] = $destinationPath.'/'.$filename;
        
        Sub_category::create($requestData);

        return redirect('backend/sub_categories')->with('flash_message', 'Sub_category added!');
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
        $sub_category = Sub_category::findOrFail($id);

        return view('backend::sub_categories.show', compact('sub_category'));
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
        $sub_category = Sub_category::findOrFail($id);

        return view('backend::sub_categories.edit', compact('sub_category'));
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
        
        $sub_category = Sub_category::findOrFail($id);


  if($request->has('cover_photo'))
  {
       $destinationPath = 'subs';

           $file=$request->file('cover_photo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['cover_photo'] = $destinationPath.'/'.$filename;
  }
          

        $sub_category->update($requestData);

        return redirect('backend/sub_categories')->with('flash_message', 'Sub_category updated!');
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
        Sub_category::destroy($id);

        return redirect('backend/sub_categories')->with('flash_message', 'Sub_category deleted!');
    }


    public function  remove_subcategory_pic($id)
    {

         $brand=Sub_category::find($id);

     
        if (File::exists(public_path($brand->cover_photo))) {
         unlink(public_path($brand->cover_photo));
}
         $brand->cover_photo='';
         $brand->save();

       Session::flash('flash_message','done');

    return  redirect()->back();


    }
}
