<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\City;
use  App\User;
use  Auth;
use  Validator;
use  Session;
use  Modules\Backend\Notifications\PasswordChanged;
use  App\Category;
use  App\Sub_category;
use  App\Order;
use  App\Product;
use  App\Product_suspension;
use  App\Product_tag;
use  App\Tag;
use  App\Received_order;
use  App\Seller_order;
use  App\Order_detail;
use Illuminate\Support\Facades\Storage;
use  App\Seller;
use  File;
use Carbon\Carbon;

use  App\Vehicle;
use  App\Trip;
use  App\Rider;
use  App\Searched_item;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
  
        $user = Auth::user();
        
        if($user == null) {

            return view('backend::auth.login');
        } else{

          if($user->hasRole('admin')) {

            $seller_orders = Seller_order::limit(5)->orderBy('id', 'DESC')->get();
            $orders = Order::limit(4)->orderBy('id', 'DESC')->get();
            
            return view('backend::dashboard', compact('seller_orders', 'orders'));

          }else {

            return view('backend::auth.login');
          }
        }
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
    public function destroy()
    {
    }

    public  function  load_cities(Request  $request)
    {

        $cities= City::select('id','name')
        ->where('country_id',$request->country_id)->get();

        return  $cities;
    }

    public  function  profile()
    {
    
      return  view('backend::users.profile');
    }


    public function  update_profile(Request  $request)
    {

        $request->validate([
           'first_name'=>'required',
           'last_name'=>'required',
           'email'=>'required',
           'password'=>'nullable|min:5'
        ]);

       $requestData= $request->except('password');

          if(!empty($request->password))
       {

       $requestData['password']= bcrypt($request->password);

       }

      $user= User::find(Auth::user()->id);

      $user->update($requestData);
      Session::flash('flash_message','updated');

      return  redirect()->back();

  }


  public  function  load_categories(Request  $request)
    {
     
     if($request->level < 2)
     {
        // $categories=  Category::select('id','name')->where('level',1)->get();
        $categories =[];

     } else{
        
        $level = $request->level - 1;

        $categories=  Category::select('id','name')->where('level',$level)->get();

     }


     return  $categories;

    }


    public  function  filter_categories(Request  $request)
    {
     
     if($request->level < 2)
     {
        $categories =[];

     } else{
        
        $level = $request->level;

        $categories=  Category::select('id','name')->where('level',$level)->get();

     }

     return  $categories;

    }

    public  function  load_subcategories(Request  $request)
    {
        $request->validate(['category_id'=>'required']);

        $subcategories=Sub_category::select('id','name')->where('category_id',$request->category_id)->get();

        return  $subcategories;


    }


    public function  orders(Request  $request)

    {
        if(!empty($request->search))
        { 

           if(!empty($request->customer))
           {
           
            $customer = User::where(function($query) use($request){
              
              $query->where('email','LIKE','%'.$request->customer.'%')
                ->orWhere('first_name','LIKE','%'.$request->customer.'%')
                ->orWhere('last_name','LIKE','%'.$request->customer.'%');  

           })->first();
          } else{
            $customer=NULL;
          }  
          
           $orders=  Order::where(function($query) use ($request,$customer)  {

            if(!empty($request->order_reference))
            {

             $query->where('order_reference','LIKE','%'.$request->order_reference.'%');
            }

            if($request->order_status !=='-1')
            {

             $query->where('order_status',$request->order_status);
            }

            if(!empty($customer))
            {
              $query->where('user_id',$customer->id);
            }

           })->Orderby('id','DESC')->get();

        } else{

         $orders=  Order::Orderby('orders.id','DESC')->get();

        }
        return  view('backend::orders.index',compact('orders'));
    }


    public  function  manage_product($slug)
    {
      
      $product =  Product::where('slug',$slug)->first();

      $product_tags = Product_tag::where('product_id', $product->id)->get();

      return  view('backend::products.manage_product', compact('product', 'product_tags'));

    }

    public  function  update_product_admin($id,  Request  $request)
    {

    	$request->validate([
    		'seller_id'=>'required',
    		'publish_status'=>'required',
            'suspension_reason_id'=>'required_if:publish_status,==,2'
    	]);
        $requestData=$request->all();

    	$product=  Product::findorfail($id);

    	$product->update($requestData);

        if($request->publish_status ==2)
        {
            //  Suspended  product

           Product_suspension::create([
                'product_id'=>$product->id,
                'user_id'=>Auth::user()->id,
                'suspension_reason_id'=>$request->suspension_reason_id,
                'comments'=>$request->comments
            ]);

        }

    	Session::flash('flash_message','Updated ');

    	return  redirect()->back();

    }


    public  function  receive_products(Request  $request)
    {
       $request->validate([
        'seller_order_id'=>'required',
        'quantity'=>'required',
        'warehouse_id'=>'required'
       ]);

      // dd($request->all());
         $seller_order= Seller_order::find($request->seller_order_id);

       if(Received_order::where(['seller_order_id'=>$request->seller_order_id])->exists())
       {
        

       } else{


        Received_order::create([
            'order_id'=>$seller_order->order_id,
            'seller_order_id'=>$seller_order->id,
            'warehouse_id'=>$request->warehouse_id,
            'quantity'=>$request->quantity,
            'order_detail_id'=>$seller_order->order_detail_id,
            'received_by'=>Auth::user()->id,
            'product_id'=>$request->product_id

        ]);
       }  


        $order_detail= Order_detail::find($seller_order->order_detail_id);

        if($request->quantity >= $seller_order->quantity )
        {

            $seller_order->shipping_status_id= 5;

            $seller_order->save();

            $order_detail->shipping_status_id= 5;
            $order_detail->save();
               }
               //Check  if  order has  been  fulfilled 

            if(Order_detail::where(['order_id'=>$seller_order->order_id])->where('shipping_status_id','!=',5)->count() < 1)
            {
             //Order  has  been  fulfilled 

                Order::where('id',$seller_order->order_id)->update([
                    'shipping_status_id'=>5,
                    'order_status'=>'READY'
                     
                 ]);
              
            }

       Session::flash('flash_message','Product received');
       return  redirect()->back();


    }

    public  function  remove_seller_logo($id)
    {
        $seller=  Seller::findorfail($id);
     
          File::delete(public_path($seller->logo));
          $seller->logo=NULL;
          $seller->save();
          Session::flash('flash_message','Removed');
          return  redirect()->back();
       
    }



     public  function  remove_licence($id)
     {
         $seller=  Seller::findorfail($id);
   
          File::delete(public_path($seller->licence));
          $seller->licence=NULL;
          $seller->save();
          Session::flash('flash_message','Removed');
          return  redirect()->back();

     }


    public  function  remove_front_id($id)
     {
         $seller=  Seller::findorfail($id);
   
          File::delete(public_path($seller->licence));
          $seller->id_front=NULL;
          $seller->save();
          Session::flash('flash_message','Removed');
          return  redirect()->back();

     }

      public  function  remove_back_id($id)
     {
         $seller=  Seller::findorfail($id);
   
          File::delete(public_path($seller->licence));
          $seller->id_back=NULL;
          $seller->save();
          Session::flash('flash_message','Removed');
          return  redirect()->back();

     }

    public  function  products(Request  $request)
    {
   if(!empty($request->search))
        { 

           $products=  Product::where(function($query) use ($request)  {

            if(!empty($request->product_code))
            {

             $query->orwhere('product_code','LIKE','%'.$request->product_code.'%');
            }

             if($request->order_status !=='-1')
            {

             $query->orwhere('publish_status',$request->publish_status);
            }

            if(!empty($request->product))
            {
             $query->orwhere('name','LIKE','%'.$request->product.'%');
            }

           })->Orderby('id','DESC')->limit(10)->get();

        } else{


         $products =  Product::OrderBy('id','DESC')->limit(10)->get();

        }


         return  view('backend::products.index',compact('products'));

    }


    public  function  customer_searches()
    {

         $customer_searches =  Searched_item::where('ip_address', '!=', '41.60.239.82')
            ->OrderBy('id','DESC')->get();

         return  view('backend::searches', compact('customer_searches'));

    }

    public function add_product_tag(Request $request){

       $tag_name = $request->product_tag;

       $tag = Tag::where('name', $tag_name)->first();

       if($tag != null){

          $prod_tag = Product_tag::where('tag_id', $tag->id)
            ->where('product_id', $request->product_id)->first();

          if($prod_tag != null){

             Session::flash('alert-class', 'alert-danger');
             Session::flash('flash_message', 'Product tag already associated with that product');

             return redirect(url()->previous())->withInput(['tab'=>'tab5']);;
          }

          $prod_tag = new Product_tag();
          $prod_tag->product_id = $request->product_id;
          $prod_tag->tag_id = $tag->id;

          $prod_tag->save();
       }

       $product = Product::findorfail($request->product_id);

       $tag = new Tag();
       $tag->name = $tag_name;
       $tag->category_id = $product->category_id;
       $tag->user_id = Auth::user()->id;

       $tag->save();

       $prod_tag = new Product_tag();
       $prod_tag->product_id = $request->product_id;
       $prod_tag->tag_id = $tag->id;

       $prod_tag->save();

       Session::flash('alert-class', 'alert-success');
       Session::flash('flash_message', 'Product tag added to the product successfully');

       return redirect(url()->previous())->withInput(['tab'=>'tab5']);;

    }

}