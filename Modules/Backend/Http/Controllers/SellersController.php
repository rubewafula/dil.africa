<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seller;
use Illuminate\Http\Request;

class SellersController extends Controller
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
            $sellers = Seller::where('name', 'LIKE', "%$keyword%")
                ->orWhere('logo', 'LIKE', "%$keyword%")
                ->orWhere('username', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('opening_hours', 'LIKE', "%$keyword%")
                ->orWhere('closing_hours', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $sellers = Seller::latest()->paginate($perPage);
        }

        return view('backend::sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::sellers.create');
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
            'name'=>'required',
            'status'=>'required',
            'country_id'=>'required',
            'logo'=>'nullable|mimes:jpeg,png,bmp|max:2000',
            'contact_person'=>'required',
            'contact_telephone'=>'required',
            'contact_email_address'=>'required|email',
            'physical_location'=>'required',
            'description'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'email_address'=>'required',
            'telephone'=>'required',

       ]);
        
        $requestData = $request->all();

          $slug= str_slug($request->name);

          if(\App\Seller::where('username',$slug)->exists())
         {

            $slug= $slug.rand(100,600);
         }


      $requestData['username']=  $slug;

       if($request->hasFile('logo'))
        {

        $destinationPath = 'logos';

           $file=$request->file('logo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['logo'] = $destinationPath.'/'.$filename;

        }


            Seller::create($requestData);

        return redirect('backend/sellers')->with('flash_message', 'Seller added!');
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
        $seller = Seller::findOrFail($id);

        return view('backend::sellers.show', compact('seller'));
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
        $seller = Seller::findOrFail($id);

        return view('backend::sellers.edit', compact('seller'));
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

        //  if($request->hasFile('logo'))
        // {

        // $destinationPath = 'logos';

        //    $file=$request->file('logo');

        //         $file_ext = str_replace('#', '', $file->getClientOriginalName());
        //         $file_ext = str_replace(' ', '_', $file_ext);


        //         $filename = time() . '-' . $file_ext;
        //         $upload_success = $file->move($destinationPath, $filename);
    
        //    $requestData['logo'] = $destinationPath.'/'.$filename;

        // }

        $requestData = $this->seller_files($request,$requestData);
        
        $seller = Seller::findOrFail($id);
        $seller->update($requestData);

        return redirect('backend/sellers')->with('flash_message', 'Seller updated!');
    }



      public function  seller_files($request,$requestData)
  {
        if($request->hasFile('logo'))
        {


         $destinationPath = 'logos';

           $file=$request->file('logo');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['logo'] = $destinationPath.'/'.$filename;

        }


          if($request->hasFile('id_front'))
        {


        $destinationPath = 'uploads';

           $file=$request->file('id_front');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['id_front'] = $destinationPath.'/'.$filename;

        }


          if($request->hasFile('id_back'))
        {

        $destinationPath = 'uploads';

           $file=$request->file('id_back');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['id_back'] = $destinationPath.'/'.$filename;

        }

          if($request->hasFile('licence'))
        {

        $destinationPath = 'uploads';

           $file=$request->file('licence');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);
    
           $requestData['licence'] = $destinationPath.'/'.$filename;

        }
  
     return  $requestData;

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
        Seller::destroy($id);

        return redirect('backend/sellers')->with('flash_message', 'Seller deleted!');
    }


    public  function  manage($id)
    {

      $seller= Seller::findOrFail($id);
      $title= 'Manage Seller '.$seller->name;


      return  view('backend::sellers.manage_seller',compact('seller','title'));


    }


    public  function  new_user($seller_id)
    {


         return  view('backend::sellers.new_user',compact('seller_id'));

    }



}
