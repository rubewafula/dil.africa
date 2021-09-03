<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Campaign;
use App\Product;
use App\Product_price;
use App\Promotion_banner;
use App\Campaign_product;

use Session;

class CampaignController extends Controller
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

            $campaigns = Campaign::where('campaign_description', 'LIKE', "%$keyword%")
            ->orWhere('active_from', 'LIKE', "%$keyword%")
             ->orWhere('active_to', 'LIKE', "%$keyword%")
              ->orWhere('remaining_stock', '=', "$keyword")
                    ->latest()->paginate($perPage);
        } else {
            $campaigns = Campaign::latest()->paginate($perPage);
        }

        return  view('backend::campaign.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::campaign.create');
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
            'active_from' => 'required',
            'active_to' => 'required'
        ]); 

        $sku = $request->product_id;

        $requestData = $request->all();

        if(strlen(trim($sku)) > 1) {
        
            $product = Product::where('product_code', $sku)->first();

            if($product == null){

                Session::flash('alert-class', 'alert-danger');
                Session::flash('flash_message', 'There is no product with the specified SKU. Please check!');
                return redirect()->back();
            }

            $requestData['product_id'] = $product->id;

        }

        $requestData['category_id'] = $requestData['depends_on'];

        Campaign::create($requestData);

        return redirect('backend/campaign')
            ->with('flash_message', 'Campaign added successfully!');
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
        $campaign = Campaign::findOrFail($id);

        return view('backend::campaign.show', compact('campaign'));
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
        $campaign = Campaign::findOrFail($id);

        return view('backend::campaign.edit', compact('campaign'));
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
            'active_from' => 'required',
            'active_to' => 'required'
        ]); 

        $campaign = Campaign::findOrFail($id);

        $requestData = $request->all();

        $campaign->update($requestData);

        return redirect('backend/campaign')
            ->with('flash_message', 'Campaign details updated successfully!');
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
        Campaign::destroy($id);

        return redirect('backend/campaign')
            ->with('flash_message', 'Campaign deleted successfully!');
    }


    public function campaign_banners(Request  $request, $id)
    {

        $campaign = Campaign::find($id);

        $campaign_banners =  Promotion_banner::where('active_from', '<=', date('Y-m-d'))
                ->where('active_to', '>=', date('Y-m-d'))->where('status', 1)
                    ->orderBy('id','DESC')->get();

        return  view('backend::campaign.banners.index', 
            compact('campaign','campaign_banners'));
    }


    public function campaign_products(Request  $request, $id)
    {

        $campaign = Campaign::find($id);

        $campaign_products =  Campaign_product::where('campaign_id', $id)
                    ->orderBy('id','DESC')->get();

        return view('backend::campaign.products.index', 
            compact('campaign','campaign_products'));
    }


    public function add_banner_to_campaign($campaign_id, $banner_id) {

        $banner = Promotion_banner::where('id', $banner_id)
            ->where('campaign_id', $campaign_id)->first();

        if($banner != null) {

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'The selected banner has already been added
             to this campaign');
            return redirect(url()->previous());
        }

        Promotion_banner::where('id', $banner_id)->update(['campaign_id' => $campaign_id]);

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Banner added to the campaign successfully');

        return redirect(url()->previous());
    }


    public function remove_banner_from_campaign($id)
    {

        Promotion_banner::where('id', $id)->update(['campaign_id' => NULL]);

        return redirect(url()->previous())->with('flash_message', 
            'Banner removed from the campaign successfully!');
    }


    public function getProductName(Request $request)
    {

        $product_code = $request->product_code;

        $seller_sku_code = substr($product_code, 1);

        // if(strpos($seller_sku_code, '-') === false){

        //     return response()->json(["status" => 0]);
        // }

        $sku_s = explode("-", $seller_sku_code);

        $seller_code = $sku_s[0];
        $skuid = $sku_s[1];

        // if(strlen($skuid) == 0){

        //     return response()->json(["status" => 0]);
        // }

        $product = null;

        $productPrice = Product_price::where('skuid', $skuid)
            ->where('seller_code', $seller_code)->first();

        if($productPrice != null) {

            $product = Product::findorfail($productPrice->product_id);
        }

        if($product == null){


            $product = Product::where('product_code', $product_code)->first();

            if($product != null){

                $productPrice = Product_price::where('product_id', $product->id)->first();
            }
        }

        if($product != null) {

            return response()->json(["status" => 1,
             "product_name" => $product->name, 
                "price_before" => $productPrice->standard_price]);
        }else{

            return response()->json(["status" => 0]);
        }
    }


    public function saveCampaignProduct(Request $request){


        $requestData = $request->all();

        $seller_sku_code = $requestData["product_code"];

        // if(strpos($seller_sku_code, '-') === false){

        //     Session::flash('alert-class', 'alert-danger');
        //     Session::flash('flash_message', "Invalid product SKU. Please verify and then try again!");

        //     return redirect()->back();
        // }

        // $sku_s = explode("-", $seller_sku_code);

        // $seller_code = $sku_s[0];
        // $skuid = $sku_s[1];

        // if(strlen($skuid) == 0){

        //     Session::flash('alert-class', 'alert-danger');
        //     Session::flash('flash_message', "Invalid product SKU. Please verify and then try again!");

        //     return redirect()->back();
        // }

        // $productPrice = Product_price::where('skuid', $skuid)
        //     ->where('seller_code', $seller_code)->first();

        // if($productPrice == null) {

        //     Session::flash('alert-class', 'alert-danger');
        //     Session::flash('flash_message', "Invalid product SKU. Please verify and then try again!");

        //     return redirect()->back();
        // }

        // $product = Product::findorfail($productPrice->product_id);

        $product = Product::where('product_code', $seller_sku_code)->first();

        if($product != null) {

            $campaign_product = new Campaign_product();

            $discount = 0;
            $discount = $requestData["discount"];
            
            $campaign_product->product_id = $product->id;
            $campaign_product->product_code = $requestData["product_code"];
            $campaign_product->campaign_id = $requestData["campaign_id"];
            $campaign_product->discount = $discount;
            $campaign_product->price_before = $requestData["price_before"];
            $campaign_product->offer_price = $requestData["offer_price"];
            $campaign_product->initial_stock = $requestData["initial_stock"];
            $campaign_product->remaining_stock = $requestData["initial_stock"];
            $campaign_product->status = 1;
            
            $campaign_product->save();

            $campaign = Campaign::findorfail($requestData["campaign_id"]);

            if($requestData["offer_price"] != null){

                $productPrice->offer_price = $requestData["offer_price"];
                $productPrice->offer_quantity = $requestData["initial_stock"];
                $productPrice->start_date = $campaign->active_from;
                $productPrice->end_date = $campaign->active_to;

                $productPrice->save();

            }
            
            Session::flash('alert-class', 'alert-success');
            Session::flash('flash_message', "Product added to the campaign successfully");

            return redirect()->back();

        }else{

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', "Invalid product SKU. Please verify and then try again!");

            return redirect()->back();
        }
    }

    public function remove_product_from_campaign($id)
    {

        $campaignProduct = Campaign_product::findorfail($id);

        $campaign_id = $campaignProduct->campaign_id;
        $product_id = $campaignProduct->product_id;

        Product_price::where('product_id', $product_id)
            ->update(['offer_quantity' => NULL, 'offer_price' => NULL,
             'start_date' => NULL, 'end_date' => NULL]);

        Campaign_product::destroy($id);

        return redirect(url()->previous())->with('flash_message', 
            'Product removed from the campaign successfully!');
    }


}