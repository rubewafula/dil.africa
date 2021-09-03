<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Modules\Customer\Entities\Newsletter_subscription;
use Session;
use  App\Inquiry;
use App\User;

use Modules\Customer\Notifications\SubscribeNotification;
use Modules\Customer\Entities\Product;
use Modules\Customer\Entities\Category;
use Modules\Customer\Utilities\Utilities;
use Modules\Customer\Entities\Brand;
use Modules\Customer\Entities\Product_price;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
          return view('modules/customer/home/index');

    }

    public  function  subscribe(Request  $request)
    {

        $request->validate([
          'email'=>'required'
        ]);
      
      if(Newsletter_subscription::where('email',$request->email)->exists())
      {
       Session::flash('flash_message','You\'re  already  subscribed');

      }else{
         
         Newsletter_subscription::create([
            'email'=>$request->email
    ]);

	 $user = new User();
	 $user->email = $request->email;
	 $user->notify(new SubscribeNotification($user));
         Session::flash('flash_message',' Thank you for subscribing to DIL.AFRICA. We are delighted to have you onboard and have sent you an email with more details.');

      }

      return  redirect()->back();
    }

    public function  inquiry(Request  $request)
    {
       $request->validate([
            'message'=>'required',

       ]);
       Inquiry::create($request->all());

       Session::flash('flash_message',' Your  message  was sent');

       return  redirect()->back();


    }


    public function searchCategoryMini($slug){
        
        $category = Category::where('slug', $slug)->first();

        if($category == null){

            return redirect(url('/shop'));
        }

        $category_id = $category->id;

        $title = "DIL.AFRICA - ".$category->name;

        $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

        $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
            'product_prices.product_id')->where('product_prices.status', 1)
                    ->whereIn('category_id', $all_ids);

        $products_ids_query = clone $products_query;
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            ->get(['products.id', 'name', 'product_code', 'seller_id', 
                'product_description', 'category_id', 'slug', 
            'product_id', 'standard_price', 'color', 'product_prices.size']);;

        $brands = Brand::where('category_id', $category_id)->get();
        $product_ids = $products_ids_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->get()->max('standard_price');
        $minimum_price = $product_prices_copy->get()->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)
                    ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'category', 
                'title'));
    }



}
