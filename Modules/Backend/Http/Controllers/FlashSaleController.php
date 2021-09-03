<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Flash_sale;
use App\Product;

use Session;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $products =  Flash_sale::where('expires_on', ">", date('Y-m-d H:i:s'))
                        ->where('remaining_stock', '>', '0')
                        ->where('status',  '1')
                    ->orderBy('id','DESC')->get();

        return view('backend::flash_sale.index', 
            compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('backend::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        $seller_sku_code = $requestData["product_code"];

        $product = Product::where('product_code', $seller_sku_code)->first();

        $time_format  = date("H:i:s", strtotime($requestData["expires_at"]));
        $time_from  = date("H:i:s", strtotime($requestData["active_at"]));

        $product_exists =  Flash_sale::where('remaining_stock', '>', '0')
                    ->where('status',  '1')->where('product_id', 
                     $product->id)->first();

        if($product_exists != null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'This product is already in an active 
                flash sale campaign. If you wish to add it with new details, you
                 must remove it first!');
            return redirect(url()->previous());
        }

        if($product != null) {

            $flash_sale_product = new Flash_sale();

            $discount = 0;
            $discount = $requestData["discount"];
            
            $flash_sale_product->product_id = $product->id;
            $flash_sale_product->product_code = $requestData["product_code"];
            $flash_sale_product->discount = $discount;
            $flash_sale_product->price_before = $requestData["price_before"];
            $flash_sale_product->offer_price = $requestData["offer_price"];
            $flash_sale_product->initial_stock = $requestData["initial_stock"];
            $flash_sale_product->remaining_stock = $requestData["initial_stock"];
            $flash_sale_product->active_from = $requestData["active_from"] ." " .$time_from;
            $flash_sale_product->expires_on = $requestData["expires_on"] ." " .$time_format;
            $flash_sale_product->status = 1;
            
            $flash_sale_product->save();

            // if($requestData["offer_price"] != null){

            //     $productPrice->offer_price = $requestData["offer_price"];
            //     $productPrice->offer_quantity = $requestData["initial_stock"];
            //     $productPrice->start_date = $requestData["active_from"];
            //     $productPrice->end_date = $requestData["expires_on"];

            //     $productPrice->save();

            // }
            
            Session::flash('alert-class', 'alert-success');
            Session::flash('flash_message', "Product added to flash sale successfully");

            return redirect()->back();

        }else{

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', "Invalid product SKU. Please verify and then try again!");

            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('backend::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {

        Flash_sale::destroy($id);

        return redirect('backend/flash-sale')->with('flash_message', 
            'Product removed from flash sale successfully!');
    }
}
