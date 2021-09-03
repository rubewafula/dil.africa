<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;

class BrandsController extends Controller
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
            $brands = Brand::where('name', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('cover_photo', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('mini_category_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $brands = Brand::latest()->paginate($perPage);
        }

        return view('backend::brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::brands.create');
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
			'cover_photo' => 'required|max:200'
		]);



        $requestData = $request->all();

         $slug= str_slug($request->name);
         if(\App\Brand::where('slug',$slug)->exists())
         {

            $slug= $slug.rand(100,600);
         }


      $requestData['slug']=  $slug;

        if($request->hasFile('cover_photo'))
        {
    

      // $imagePath = $request->file('cover_photo')->store(public_path('brands'));


      // $image = Image::make(Storage::get($imagePath))->resize(100,80)->encode();
      //  Storage::put($imagePath,$image);
           $destinationPath = 'brands';

           $file=$request->file('cover_photo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['cover_photo'] = $destinationPath.'/'.$filename;
          
         //$requestData['cover_photo'] = Storage::disk('local')->putFile('brands', new  File($request->file('cover_photo')));

          // $img = Image::make(Storage::get($requestData['cover_photo']));

          //  $img->resize(100,80); 

          //  $img->save($requestData['cover_photo']);

          // dd($img);

          // $img->save('public/bar.jpg');

        }

        Brand::create($requestData);

        return redirect('backend/brands')->with('flash_message', 'Brand added!');
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
        $brand = Brand::findOrFail($id);

        return view('backend::brands.show', compact('brand'));
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
        $brand = Brand::findOrFail($id);

        return view('backend::brands.edit', compact('brand'));
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
			'cover_photo' => 'required'
		]);
        $requestData = $request->all();
        
        $brand = Brand::findOrFail($id);
        $brand->update($requestData);

        return redirect('backend/brands')->with('flash_message', 'Brand updated!');
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
            $brand=  Brand::find($id);
          Storage::delete($brand->cover_photo);

        Brand::destroy($id);

        return redirect('backend/brands')->with('flash_message', 'Brand deleted!');
    }


    public  function  remove_brand_pic($id)
    {

         $brand=Brand::find($id);
        Storage::delete($brand->cover_photo);

    }
}