<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Promotion_banner;

use File;

class PromotionBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index(Request  $request)
    {

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {

            $promotion_banners = Promotion_banner::join('promotion_sections',
                'promotion_banners.promotion_section_id', '=', 'promotion_sections.id')
                ->where('promotion_sections.name', 'LIKE', "%$keyword%")
                    ->latest()->paginate($perPage);
        } else {
            $promotion_banners = Promotion_banner::latest()->paginate($perPage);
        }

        return  view('backend::promotion_banners.index', compact('promotion_banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::promotion_banners.create');
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
            'promotion_section_id' => 'required',
            'active_from' => 'required',
            'active_to' => 'required',
            'file' => 'required'
        ]); 

        $file=$request->file('file');

        $promotion_banner = new Promotion_banner();

        if($file != null) {

            $file_ext = str_replace('#', '', $file->getClientOriginalName());
            $file_ext = str_replace(' ', '_', $file_ext);

            $filename = time() . '-' . $file_ext;

            $image_path = public_path('assets/images/banners/'.$filename); 

            if(File::exists($image_path)) {
               File::delete($image_path);
            }

            if($request->promotion_section_id == 1) {

                $request->validate([
                    'file' => 'dimensions:min_width=260, max_width=270',
                    'file' => 'dimensions:min_height=360, max_height=370'
                ]);
            }elseif($request->promotion_section_id == 2) {

                $request->validate([
                    'file' => 'dimensions:min_width=870,max_width=880',
                    'file' => 'dimensions:min_height=365,max_height=370'
                ]);
            }elseif($request->promotion_section_id == 3) {

                $request->validate([
                    'file' => 'dimensions:min_width=845,max_width=850',
                    'file' => 'dimensions:min_height=165,max_height=170'
                ]);
            }

            $destinationPath = 'assets/images/banners';

            $upload_success = $file->move($destinationPath, $filename);

            $promotion_banner->url = $filename;

        }

        $promotion_banner->promotion_section_id = $request->promotion_section_id;
        $promotion_banner->active_from = $request->active_from;
        $promotion_banner->active_to = $request->active_to;
        $promotion_banner->campaign_description = $request->campaign_description;
        $promotion_banner->category_id = $request->category_id;
        $promotion_banner->product_id = $request->product_id;
        
        $promotion_banner->save();

        return redirect('backend/promotion-banners')
            ->with('flash_message', 'Promotional banner added successfully!');
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
        $promotion_banner = Promotion_banner::findOrFail($id);

        return view('backend::promotion_banners.show', compact('promotion_banner'));
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
        $promotion_banner = Promotion_banner::findOrFail($id);

        return view('backend::promotion_banners.edit', compact('promotion_banner'));
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
            'promotion_section_id' => 'required',
            'active_from' => 'required',
            'active_to' => 'required'
        ]); 

        $file=$request->file('file');

        $promotion_banner = Promotion_banner::findOrFail($id);

        if($file != null) {

            $image_path = public_path('assets/images/banners/'.$promotion_banner->url); 

            if(File::exists($image_path)) {
               File::delete($image_path);
            }

            if($request->promotion_section_id == 1) {

                $request->validate([
                    'file' => 'dimensions:min_width=260, max_width=270',
                    'file' => 'dimensions:min_height=360, max_height=370'
                ]);
            }elseif($request->promotion_section_id == 2) {

                $request->validate([
                    'file' => 'dimensions:min_width=870,max_width=880',
                    'file' => 'dimensions:min_height=365,max_height=370'
                ]);
            }elseif($request->promotion_section_id == 3) {

                $request->validate([
                    'file' => 'dimensions:min_width=845,max_width=850',
                    'file' => 'dimensions:min_height=165,max_height=170'
                ]);
            }

            $destinationPath = 'assets/images/banners';

            $file_ext = str_replace('#', '', $file->getClientOriginalName());
            $file_ext = str_replace(' ', '_', $file_ext);

            $filename = time() . '-' . $file_ext;
            $upload_success = $file->move($destinationPath, $filename);

            $promotion_banner->url = $filename;

        }

        $promotion_banner->promotion_section_id = $request->promotion_section_id;
        $promotion_banner->active_from = $request->active_from;
        $promotion_banner->active_to = $request->active_to;
        $promotion_banner->campaign_description = $request->campaign_description;
        $promotion_banner->category_id = $request->category_id;
        $promotion_banner->product_id = $request->product_id;
        
        $promotion_banner->save();

        return redirect('backend/promotion-banners')
            ->with('flash_message', 'Promotion banner details updated successfully!');
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
        Promotion_banner::destroy($id);

        return redirect('backend/promotion-banners')
            ->with('flash_message', 'Promotion banner deleted successfully!');
    }

    public  function  upload_banner(Request $request)
    {
        $request->validate([
            'file'=>'required'
        ]);

        if($request->promotion_section_id == 1) {

            $request->validate([
                'file' => 'dimensions:min_width=260, max_width=270',
                'file' => 'dimensions:min_height=360, max_height=370'
            ]);
        }elseif($request->promotion_section_id == 2) {

            $request->validate([
                'file' => 'dimensions:min_width=870,max_width=880',
                'file' => 'dimensions:min_height=365,max_height=370'
            ]);
        }elseif($request->promotion_section_id == 3) {

            $request->validate([
                'file' => 'dimensions:min_width=845,max_width=850',
                'file' => 'dimensions:min_height=165,max_height=170'
            ]);
        }

        $destinationPath = 'assets/images/banners';

        $file=$request->file('file');

        $file_ext = str_replace('#', '', $file->getClientOriginalName());
        $file_ext = str_replace(' ', '_', $file_ext);

        $filename = time() . '-' . $file_ext;
        $upload_success = $file->move($destinationPath, $filename);

        Promotion_banner::create([
           'promotion_section_id'=>$request->promotion_section_id,
           'url'=>$filename,
           'active_from'=>$request->active_from,
           'active_to'=>$request->active_to,
           'campaign_description'=>$request->campaign_description,
           'category_id'=>$request->category_id,
           'product_id'=>$request->product_id
        ]);     

        Session::flash('flash_message',' Promotion banner uploaded  successfully');

        return  redirect()->back();
    }


  public  function  remove_banner($id)
  {
    
    $banner = Promotion_banner::findorfail($id);

    $image_path = public_path('assets/images/banners/'.$banner->url);  
     if(File::exists($image_path)) {
       File::delete($image_path);
    }

    $banner->delete();

    Session::flash('flash_message','Banner removed successfully');
    return  redirect()->back();

  }

    public function activate($id)
    {

        Promotion_banner::where('id', $id)->update(['status' => 1]);

        return redirect(url()->previous())->with('flash_message', 
            'Banner activated successfully!');
    }


    public function inactivate($id)
    {

        Promotion_banner::where('id', $id)->update(['status' => 0]);

        return redirect(url()->previous())->with('flash_message', 
            'Banner inactivated successfully!');
    }
}
