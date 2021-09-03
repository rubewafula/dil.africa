<?php

namespace Modules\QualityControl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\User;
use  App\Notifications\UserConfirmation;
use  App\Notifications\SellerConfirmation;
use  App\Notifications\QCFailedNotification;

use  Session;
use  App\Seller;
use Auth;
use App\Sub_category;
use App\Category;
use App\Brand;
use App\Product;
use App\Product_price;
use App\Seller_order;
use App\Product_image;
use File;
use Shipping_status;
use App\Product_feature;
use App\Category_product;
use App\Order;
use App\Qc_rejected_product;

use Modules\Customer\Entities\Featured_product;
use Modules\Customer\Entities\New_arrival;
use Modules\Customer\Entities\History_visit;

use  App\Repository;
use  App\Repository_feature;
use  App\Repository_price;
use  App\Repository_image;

class QualityControlController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

      $total_pending_review = Product::where('publish_status', 4)->count();

      $total_reviewed_today = Product::where(function ($query) {
          $query->where('qc_rejected_date',  date('Y-m-d'))
          ->orWhere('publish_date', date('Y-m-d'));
       })->where(function ($query) {
          $query->where('publish_status', 1)
          ->orWhere('publish_status', 5);
       })->count();

      $total_reviewed_yesterday = Product::where(function ($query) {
          $query->where('qc_rejected_date',  date('Y-m-d',strtotime("-1 days")))
          ->orWhere('publish_date', date('Y-m-d',strtotime("-1 days")));
       })->where(function ($query) {
          $query->where('publish_status', 1)
          ->orWhere('publish_status', 5);
       })->count();

      $total_approved_today = Product::where('publish_status', 1)
      ->where('publish_date', date('Y-m-d'))->count();

      $total_rejected_today = Product::where('publish_status', 5)
        ->where('qc_rejected_date', date('Y-m-d'))->count();

      if($request->has('search')){

          $products= Product::where('publish_status', 4)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Product::where('publish_status', 4)->OrderBy('id','DESC')->get();
        }

      return  view('qc::products.index', compact('products',
       'total_pending_review', 'total_reviewed_today', 
       'total_reviewed_yesterday', 'total_approved_today',
        'total_rejected_today'));
  }

  
  public function rejected_listings(Request $request)
  {

      if($request->has('search')){

          $products= Product::where('publish_status', 5)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Product::where('publish_status', 5)->OrderBy('id','DESC')->get();
        }

      return  view('qc::products.rejected', compact('products'));
  }


  public function  repo_pending(Request $request)
  {

      if($request->has('search')){

          $products= Repository::where('publish_status', 4)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Repository::where('publish_status', 4)->OrderBy('id','DESC')->get();
        }

      return  view('qc::repository.pending', compact('products'));
  }


  public function  repo_passed(Request $request)
  {

      if($request->has('search')){

          $products= Repository::where('publish_status', 1)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Repository::where('publish_status', 1)->OrderBy('id','DESC')->get();
        }

      return  view('qc::repository.passed', compact('products'));
  }

  public function  repo_failed(Request $request)
  {

      if($request->has('search')){

          $products= Repository::where('publish_status', 5)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Repository::where('publish_status', 5)->OrderBy('id','DESC')->get();
        }

      return  view('qc::repository.rejected', compact('products'));
  }


  public  function  login()
  {

    Auth::logout();
    return view('qc::auth.login');
  }


  public  function  manage_profile()
  {

    return  view('qc::manage_profile');
  }


  public  function  update_contacts(Request  $request)
  {

     $request->validate([
     'contact_person'=>'required',
     'contact_telephone'=>'required',
     'contact_email_address'=>'required'
     
    ]);
   
     if(!empty($request->seller_id))
    {

       $seller= Seller::findorfail(Auth::user()->seller_id);

       $seller->update($request->all());


    } else{

        $seller= Seller::create($request->all());
    }
    

    Session::flash('flash_message',' Updated');

    return  redirect()->back();

  }


  public function  update_banking(Request  $request){


     $request->validate([
       'bank_name'=>'required',
       'account_name'=>'required',
       'account_number'=>'required'
    ]);
   
    if(!empty($request->seller_id))
    {

       $seller= Seller::findorfail(Auth::user()->seller_id);

       $seller->update($request->all());


    } else{

        $seller= Seller::create($request->all());
    }
    

    Session::flash('flash_message',' Updated');

    return  redirect()->back();


  }

  public  function  product_classify()
  {

      $user = Auth::user();

      if($user == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'You must be logged in to use this functionality.');

        return redirect('/qc/login');
      }
      $seller_id = $user->seller_id;

      if($seller_id == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'The seller has not completed the seller onboarding process. Ensure that you have updated your profile information and accepted our seller agreement.');

        return redirect(url()->previous());
      }
      return  view('qc::product_classify');
  }


  public  function  load_profile()
  {

    return  view('qc::users.profile');
  }


  public  function  post_profile(Request  $request)
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


  public  function  load_subcategories(Request $request)
  {
   
   $categories=  Category::where('depends_on',$request->category_id)->get();

   $data=[];

   foreach($categories as  $category)
   {

    if(Category::check_lower_tree($category->id) == TRUE)
    {

      $data[]=['id'=>$category->id,'name'=>$category->name,'child'=>1,'level'=>$category->level];
    } else{

      $data[]=['id'=>$category->id,'name'=>$category->name,'child'=>0,'level'=>$category->level];
    }
   }
   return response($data);
  }


  public  function  load_subcategories_html(Request  $request)
  {
    $categories=  Category::where('depends_on',$request->category_id)->get();


   $data=[];

    // $single_cat = Category::where('depends_on',$request->category_id)->first();
   $level =$request->level + 1;

     $html= '<div class="level_'.$level.'">';
     $html = $html.'<div class="col-md-4"  > <div class="form-group"><label> </label> <select  name="sub_category_id" level="'.$level.'" class="form-control subcat">';  
     $html= $html.'<option  value="">Please select </option>';
     
     foreach($categories as  $category)
     {

      if(Category::check_lower_tree($category->id) == TRUE)
      {

        $data[]=['id'=>$category->id,'name'=>$category->name,'child'=>1,'level'=>$category->level];

              $html= $html.'<option value="'.$category->id.'">'.$category->name.'  > </option>';


      } else{

        $data[]=['id'=>$category->id,'name'=>$category->name,'child'=>0,'level'=>$category->level];
              $html= $html.'<option value="'.$category->id.'">'.$category->name.'</option>';

      }

   }

   $html= $html.'</select></div></div></div> ';

   return  ['data'=>$data,'html'=>$html];

  }


  public  function  check_child(Request  $request)
  {

      if(Category::check_lower_tree($request->category_id) == TRUE)
      {      
        return  response()->json(['status' => 'TRUE']);
      } else{
        return  response()->json(['status' => 'FALSE']);
      }
    }


  public  function  start_product(Request  $request)
  {
   $request->validate([
   'category'=>'required'
   ]);

    return redirect('qc/products/new/'.$request->category);
  }


  public  function  products(Request  $request)
  {


    $total_pending_review = Product::where('publish_status', 4)->count();

      $total_reviewed_today = Product::where(function ($query) {
          $query->where('qc_rejected_date',  date('Y-m-d'))
          ->orWhere('publish_date', date('Y-m-d'));
       })->where(function ($query) {
          $query->where('publish_status', 1)
          ->orWhere('publish_status', 5);
       })->count();

      $total_reviewed_yesterday = Product::where(function ($query) {
          $query->where('qc_rejected_date',  date('Y-m-d',strtotime("-1 days")))
          ->orWhere('publish_date', date('Y-m-d',strtotime("-1 days")));
       })->where(function ($query) {
          $query->where('publish_status', 1)
          ->orWhere('publish_status', 5);
       })->count();

      $total_approved_today = Product::where('publish_status', 1)
      ->where('publish_date', date('Y-m-d'))->count();

      $total_rejected_today = Product::where('publish_status', 5)
        ->where('qc_rejected_date', date('Y-m-d'))->count();

  	 if($request->has('search')){

          $products= Product::where('publish_status', 4)->where( function($query) use ($request){

            if(!empty($request->name)){

              $query->Where('name','like','%'.$request->name.'%');

            }if(!empty($request->product_code)){

             $query->orWhere('product_code','like','%'.$request->product_code.'%');
            }
          })->OrderBy('id','DESC')->get();

        } else{

          $products= Product::where('publish_status', 4)->OrderBy('id','DESC')->get();

        }

         return  view('qc::products.index', compact('products',
       'total_pending_review', 'total_reviewed_today', 
       'total_reviewed_yesterday', 'total_approved_today',
        'total_rejected_today'));
   
  }

  public function  new_product($category_id)
  {

     $title=  'New Product';
     $type = 'New';
     return view('qc::products.new_product',compact('category_id','title', 'type'));

  }

  public  function  load_brands(Request  $request)
  {
   
     $brands=Brand::select('id','name')->where('name','like','%'.$request->brand.'%')->take(5)->get();

     return $brands;

  }


   public function  generate_product_code()
   {
      $seller= Seller::find(Auth::user()->seller_id);
      $cat_code= substr($seller->name,0,3);

      //
      $product= Product::where('seller_id',Auth::user()->seller_id)->OrderBy('id','DESC')->first();
        
            if(!empty($product->product_code))
         {

             $code_entry= explode('-', $product->product_code);
                
                if($code_entry[1] > 0)
                {
                   $code_entry[1]=  $code_entry[1] + 1;
                } else{

                  $code_entry[1]=1000;
                }
          
             $product_code= strtoupper($code_entry[0]).'-'. $code_entry[1];

         } else{
         //
          $product_code= strtoupper($cat_code).$seller->id.'-1000';
         }
       
         return  $product_code;

   }


  public  function  save_products(Request  $request)
  {

    $request->validate([
      'name'=>'required',
      'product_description'=>'required',
      'tax_class'=>'required'
      
    ]);

    $requestData = $request->except('product_id','save');

    if($request->product_id <  1)
    {

         $slug= str_slug($request->name);
         if(Product::where('slug',$slug)->exists())
         {
            $slug= $slug.'-'.now();

         }

           $prod_name = preg_replace('!\s+!', ' ', trim($request->name));
           $requestData['name'] = $prod_name;

           $author = preg_replace('!\s+!', ' ', trim($request->author));
           $requestData['author'] = $author;

           $publisher = preg_replace('!\s+!', ' ', trim($request->publisher));
           $requestData['publisher'] = $publisher;
           
           $requestData['slug']= $slug;
           $requestData['publish_status']= 0;
           $requestData['product_code']=$this->generate_product_code();

           $requestData['keywords'] = preg_replace('/,\s+/', ',', $requestData['keywords']);

           $product=  Product::Create($requestData);

           $product->categories()->attach($request->category_id);
           Session::flash('alert-class','alert-success');
           Session::flash('flash_message','Add more details to '.'"'.$request->name.'"');

           return  redirect('qc/product/'.$product->slug)->withInput(['tab'=>'tab2']);

    } else{

      // New  Product
       $product=  Product::findorfail($request->product_id);
      // $product->categories()->attach($request->category_id);
       Category_product::where('product_id', $request->product_id)
        ->update(['category_id' => $request->category_id]);

       $requestData['keywords'] = preg_replace('/,\s+/', ',', $requestData['keywords']);

       $product->update($requestData);
       Session::flash('flash_message','Product details updated successfully');
        return  redirect('qc/product/'.$product->slug);

    }

  }


  public  function  update_product_details(Request  $request)
  {
  	   // $request->validate(['brand_id'=>'required']);
       $requestData = $request->all();
       $product=  Product::findorfail($request->product_id);

       if(count(array_filter($requestData)) < 5){

          Session::flash('alert-class', 'alert-danger');
          Session::flash('flash_message_error','You have not input any new values. 
            There is no need to Save!');
          
          return  redirect('qc/product/'.$product->slug)->withInput(['tab'=>'tab2']);
       }     

       if($requestData['product_expiry_date'] != null){
         if(date('Y-m-d') > $requestData['product_expiry_date']){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error','Product expiry date cannot be in the past. Please correct!');
            return  redirect('qc/product/'.$product->slug)->withInput(['tab'=>'tab2']);
         }
       }

       $product->update($requestData);
       Session::flash('flash_message','Product details updated successfully');
        return  redirect('qc/product/'.$product->slug)->withInput(['tab'=>'tab3']);

  }

  public  function  manage_product($slug)
  {
    
    $product= Product::where('slug',$slug)->firstorfail();

    $category_id=  $product->category_id;

    return  view('qc::products.manage_product',compact('product','category_id'));

  }

  public  function  manage_repo_product($slug)
  {
    
    $product= Repository::where('slug',$slug)->firstorfail();

    $category_id=  $product->category_id;

    return  view('qc::repository.manage_product',compact('product','category_id'));

  }


  public  function  seller_profiles(Request  $request)
  {

    $keyword = $request->get('search');

    if (!empty($keyword)) {

        $sellers = Seller::join('users',
            'sellers.id', '=', 'users.seller_id')
            ->where('sellers.name', 'LIKE', "%$keyword%")
              ->orWhere('users.first_name', 'LIKE', "%$keyword%")
              ->orWhere('users.last_name', 'LIKE', "%$keyword%")
              ->orWhere('users.email', 'LIKE', "%$keyword%")
              ->orWhere('users.phone', 'LIKE', "%$keyword%")
                ->get();
    } else {

        $sellers = Seller::orderBy('id', 'DESC')->get();
    }

    return  view('qc::sellers.index',compact('sellers'));

  }


  public  function  add_price(Request  $request)
  {
      $request->validate([
        'quantity'=>'required',
        'standard_price'=>'required',
        'product_id'=>'required'
      ]);

      if($request->offer_price >  $request->standard_price)
      {

        Session::flash('alert-class','alert-warning');
        Session::flash('flash_message','The offer price cannot be greater than the 
          standard price');

        return   redirect()->back()->withInput(['tab'=>'tab3']);
      }

      $requestData= $request->all();

      // if(Product_price::where('product_id',$request->product_id)->count() < 1)
      // {
      //   $requestData['is_default']=1;
      // }elseif(count(Product_price::where('product_id',$request->product_id)->where('is_default', 1)->get()) < 1){

      //   $requestData['is_default']=1;
      // }

      $requestData['is_default']=1;

      $requestData['item_size_id']=2;

      $price=  Product_price::create($requestData);

      Session::flash('flash_message', 'Price was added successfully');

      return  redirect()->back()->withInput(['tab'=>'tab3']);

  }



  public function  update_price(Request  $request)
  {

 $request->validate([
    'quantity'=>'required',
    'standard_price'=>'required',
    'product_id'=>'required'
    ]);

    if($request->offer_price >  $request->standard_price)
    {

    Session::flash('alert-class','alert-warning');
    Session::flash('flash_message','The offer  price  cannot  be  greater  than  the  standard price');

    return   redirect()->back()->withInput(['tab'=>'tab3']);
    }

     $product_price=  Product_price::find($request->product_price_id);

     $product_price->update($request->all());

         Session::flash('flash_message','Updated');
         return redirect()->back()->withInput(['tab'=>'tab3']);

  }

  public  function  view_orders()
  {
     
     //$user= 

    $seller=  Seller::find(Auth::user()->seller_id);

    return  view('qc::orders.index',compact('seller'));
  }


  public  function  delete_product($id)
  {
   
      $product=Product::findorfail($id);

       if($product->order_details->count()> 0)
       {

        Session::flash('alert-class','alert-danger');

        Session::flash('flash_message',' You  cannot delete this product since there exists orders  associated with  it');
         return redirect()->back();

       } else{

         $product->delete();

         Session::flash('flash_message','Product Deleted successfully');
         return redirect()->back();

       }

  }



  public  function  upload_images(Request $request)
  {
     $request->validate([
      'product_price_id'=>'required',
      'file'=>'required'
    ]);
    //dd($request->all());

       $product=  Product_price::find($request->product_price_id);

         if($product->images->count() > 5)
         {
         Session::flash('flash_message','You  have exceeded maximum  images');
           return  redirect()->back()->withInput(['tab'=>'tab3']);

         }

         $destinationPath = 'assets/images/products';

           $file=$request->file('file');

                $file_ext = str_replace('#', '', $file->getClientOriginalName());
                $file_ext = str_replace(' ', '_', $file_ext);


                $filename = time() . '-' . $file_ext;
                $upload_success = $file->move($destinationPath, $filename);

           if($request->default > 0)
           {

            Product_image::where('product_price_id',$request->product_price_id)->update(['default'=>0]);
           }  

         if($product->images->count() < 1)
         {

         	$request->default= 1;
         } 


           Product_image::create([
           'product_price_id'=>$request->product_price_id,
           'image_url'=>$filename,
           'default'=>$request->default,
           'product_id'=>$request->product_id
           ]);     

           Session::flash('flash_message',' Uploaded  successfully');
           return  redirect()->back()->withInput(['tab'=>'tab4']);
   
             //$file_name = $destinationPath.'/'.$filename;
  }

  public  function  remove_image($id)
  {
    
    $product_image = Product_image::findorfail($id);
    $product_id = $product_image->product_id;

    $image_path = public_path('assets/images/products/'.$product_image->image_url);  
     if(File::exists($image_path)) {
       File::delete($image_path);
    }

    $product_image->delete();

    $check_images = Product_image::where('product_id', $product_id)->get();

    if(count($check_images) < 1){

      Product::where('id', $product_id)->update(['publish_status' => 0]);

    }

    Session::flash('flash_message','Image removed successfully');
    return  redirect()->back()->withInput(['tab'=>'tab4']);

  }


  public  function make_default_image($id)
  {
    
    $product_image = Product_image::findorfail($id);

    if($product_image != null){

      Product_image::where('product_id', $product_image->product_id)
        ->update(['default' => 0]);

      $product_image->default = 1;
      $product_image->save();
    }

    Session::flash('flash_message','The selected image has been set as the default image successfully');
    return  redirect()->back()->withInput(['tab'=>'tab4']);
  }


  public function  publish_product(Request  $request)
  {
    
    $request->validate([
      'product_id'=>'required'
    ]);


    $product=  Product::findorfail($request->product_id);

      if($product->prices->count() <  1 ||  $product->images->count() < 1)
      {
       Session::flash('alert-class','alert-danger');
       Session::flash('flash_message','Prices and images have not been added');

       return  redirect()->back();

      }


      $product->publish_status=  1;

      $product->publish_date=  date('Y-m-d H:i:s');

      $product->save();


      $arrival = New_arrival::where('product_id', $product->id)->first();

      if($arrival == null) {

        $new_arrival = new New_arrival();
        $new_arrival->product_id = $product->id;
        $new_arrival->priority = 2;
        $new_arrival->save();
      }

      // $fp = Featured_product::where('product_id', $product->id)->first();

      // if($fp == null) {
        
      //   $featured = new Featured_product();
      //   $featured->product_id = $product->id;
      //   $featured->priority = 2;
      //   $featured->save();
      // }

      Session::flash('flash_message',' Published successfully');

       return  redirect()->back();


  }


  public  function  unpublish_product($id)
  {
      $product= Product::findorfail($id);

      $product->publish_status=  3;

      $product->publish_date= NULL;

      $product->save();

      New_arrival::where('product_id', $product->id)->delete();
      Featured_product::where('product_id', $product->id)->delete();

      Session::flash('flash_message',' Unpublished  successfully');

      return  redirect()->back();

  }

  public  function  product_features(Request  $request)
  {
    $request->validate([
      'product_id'=>'required',
      'feature_type_id'=>'required',
      'value'=>'required'
    ]);

    Product_feature::create($request->all());

    Session::flash('flash_message','Product feature added successfully');
    return  redirect()->back()->withInput(['tab'=>'tab2']);
    //return  TRUE;

  }

  public  function  load_product_features($product_id)
  {
  
    $features= Product_feature::select('id','name')
    ->where('product_id',$product_id)->get(); 
    return $features;
  }


  public  function  remove_product_feature($id)
  {
    Product_feature::where('id',$id)->delete();
    Session::flash('flash_message','Deleted');
  //  return  redirect()->back();
    return  redirect()->back()->withInput(['tab'=>'tab2']);
  }


  public  function  confirm_account($confirmation)
  {

    $user = User::where('confirmation_token',$confirmation)->first();
    if(User::where('confirmation_token',$confirmation)->exists())
    {
         User::where('confirmation_token',$confirmation)->update([
           
             'active'=>1,
             'confirmation_token'=>NULL
         ]);
         
        Session::flash('flash_message','Your  account  was successfully activated,Please  login  to proceed with Business  setup');
        return  redirect('qc/login');
    } else{
        // wrong  code
          
        Session::flash('flash_message','The confirmation link is invalid');
        return  redirect('qc/login');
    }
  }


  public  function  remove_pricing($id)
  {

    $product_id = Product_price::find($id)->product_id;

    Product_price::destroy($id);

    $check_prices = Product_price::where('product_id', $product_id)->get();

    if(count($check_prices) < 1){

      Product::where('id', $product_id)->update(['publish_status' => 0]);
    }

    Session::flash('flash_message','Price record removed  successfully');
    return  redirect()->back()->withInput(['tab'=>'tab3']);
  }


  public function promote_product($id){

    $product_price = Product_price::findorfail($id);
    return view('qc::products.promote_product', compact('product_price'));
  }


  public function addPromotionPrice(Request $request){


     $price_id = $request->product_price;
     $offer_price = $request->offer_price;
     $start_date = $request->start_date;
     $end_date = $request->end_date;

     $standard_price = $request->standard_price;

     if($standard_price < $offer_price){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message_error', 'Promotion price cannot be lower than the standard price. Please verify!');

        return redirect(url()->previous());
     }

     if(date('Y-m-d') > $start_date){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message_error', 'The date that the offer starts cannot be in the past. Please verify!');

        return redirect(url()->previous());
     }

     if($end_date < $start_date){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message_error', 'The date that the offer ends cannot be earlier than when the offer starts. Please verify!');

        return redirect(url()->previous());
     }

     Product_price::where('id', $price_id)
      ->update(['offer_price' => $offer_price, 
        'start_date' => $start_date, 'end_date' => $end_date]);

      Session::flash('alert-class', 'alert-success');
      Session::flash('flash_message', 'Promotion price set up successfully');

      return redirect(url()->previous());
  }


  public function customer_view(Request $request, $slug)
  {
        $ip_address = $request->ip();
        
        $user_id = null;
        $product = \App\Product::where('slug', $slug)->first();

        $prices = Product_price::where('product_id', $product->id)->get();

        if(count($prices) < 1){

          Session::flash('alert-class', 'alert-danger');
          Session::flash('flash_message', 'This product does not have any prices set. Please set up the price first!');
          return redirect(url()->previous());
        }

        if($product == null){

            return redirect(url()->previous());
        }

        if(Auth::check()){
            
            $user_id = Auth::user()->id;
        }
        $related_products = [];

        if($product != null){

            $history_visit = new History_visit();
            
            $history_visit->ip_address = $ip_address;
            $history_visit->product_id = $product->id;
            $history_visit->user_id = $user_id;
            
            $history_visit->save();
            
            $related = History_visit::orderBy('id', 'DESC')->limit(10)->get();
            
            $ids_in_array = [];
            
            foreach($related as $rel){
  
                  if(!in_array($rel->product_id, $ids_in_array)){

                      array_push($ids_in_array, $rel->product_id);
                      array_push($related_products, $rel);
                  }       
                
            }
        }
        return view('qc::customerview.index', compact('related_products',
                'product'));
    }


  public function repo_customer_view(Request $request, $slug)
  {
        $ip_address = $request->ip();
        
        $user_id = null;
        $product = Repository::where('slug', $slug)->first();

        $prices = Repository_price::where('repository_id', $product->id)->get();

        if(count($prices) < 1){

          Session::flash('alert-class', 'alert-danger');
          Session::flash('flash_message', 'This product does not have any prices set. Please set up the price first!');
          return redirect(url()->previous());
        }

        if($product == null){

            return redirect(url()->previous());
        }

        if(Auth::check()){
            
            $user_id = Auth::user()->id;
        }
        $related_products = [];

        if($product != null){

            $history_visit = new History_visit();
            
            $history_visit->ip_address = $ip_address;
            $history_visit->product_id = $product->id;
            $history_visit->user_id = $user_id;
            
            $history_visit->save();
            
            $related = History_visit::orderBy('id', 'DESC')->limit(10)->get();
            
            $ids_in_array = [];
            
            foreach($related as $rel){
  
                  if(!in_array($rel->product_id, $ids_in_array)){

                      array_push($ids_in_array, $rel->product_id);
                      array_push($related_products, $rel);
                  }       
                
            }
        }
        return view('qc::customerview.index', compact('related_products',
                'product'));
    }

    public  function  manage($id)
    {

      $seller= Seller::findOrFail($id);
      $title= 'Manage Seller '.$seller->name;

      return  view('qc::sellers.manage_seller',compact('seller','title'));
    }


    public function product_price_detail(Request $request, $slug, $price_id)
    {
        $ip_address = $request->ip();
        
        $user_id = null;
        $product = \App\Product::where('slug', $slug)->first();

        $product_price = Product_price::find($price_id);

        $prices = Product_price::where('product_id', $product->id)->get();

        if($product == null){

            return redirect('/shop');
        }

        if(Auth::check()){
            
            $user_id = Auth::user()->id;
        }
        $related_products = [];

        if($product != null){

            $history_visit = new History_visit();
            
            $history_visit->ip_address = $ip_address;
            $history_visit->product_id = $product->id;
            $history_visit->user_id = $user_id;
            
            $history_visit->save();
            
            $related = History_visit::where('ip_address', '!=', $ip_address)
                    ->where('product_id', $product->id)->orderBy('id', 'DESC')->limit(10)->get();
            
            $ids_in_array = [];
            
            foreach($related as $rel){
                
                $viewed = History_visit::where('product_id', '!=', $rel->product_id)
                        ->where('ip_address', $rel->ip_address)->limit(3)->get();
                
                foreach($viewed as $view){
                    
                    if(!in_array($view->product_id, $ids_in_array)){

                        array_push($ids_in_array, $view->product_id);
                        array_push($related_products, $view);
                    }
                }         
                
            }
        }
        return view('qc::customerview.index_detail', compact('related_products',
                'product', 'product_price', 'prices'));
    }


    public  function  quality_failed(Request  $request)
     {
           $request->validate([
               'quality_comments'=>'required'
           ]);

           Product::where('id', $request->product_id)->update([
                'publish_status'=>'5', 'qc_rejected_date' => date('Y-m-d')
           ]);

           $product = Product::find($request->product_id);

           $user = User::find($product->submitted_by);

           $qc_rejected_product = new Qc_rejected_product();
           $qc_rejected_product->product_id = $request->product_id;
           $qc_rejected_product->reviewed_by = Auth::user()->id;
           $qc_rejected_product->rejection_comment = $request->quality_comments;

           $qc_rejected_product->save();

           if($user != null) {

              $user->notify(new QCFailedNotification($product, $user, $qc_rejected_product));
              Session::flash('flash_message','Product listing rejected at quality review. An email has been sent to the author of the content communicating this decision');
           }else{

            Session::flash('flash_message','Product listing rejected at quality review.');
           }

           return  redirect()->back();
     }


     public  function undo_rejection($product_id)
     {

        Product::where('id', $product_id)->update(['publish_status'=>'4']);

        Qc_rejected_product::where('product_id', $product_id)
          ->update(['status'=>'0']);

        Session::flash('flash_message','Rejected listing undone successfully. 
          The listing is back for QC.');

         return  redirect()->back();
     }

}