<?php

namespace Modules\Seller\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\User;
use  App\Notifications\UserConfirmation;
use  App\Notifications\SellerConfirmation;

use Session;
use App\Seller;
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
use Validator;

use Modules\Customer\Entities\Featured_product;
use Modules\Customer\Entities\New_arrival;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

      $user= User::find(Auth::user()->id);
      if($user->seller_id < 1)
      {
        Session::flash('alert-class','alert-danger');
        Session::flash('flash_message_error','
          Welcome '.$user->first_name.' to the  supplier section.
          You need to enter your business details to be  eligible  to  
          sell on  the  platform. Please  Enter  the  details  below  and  proceed ');
         return view('seller::manage_profile');
      }

      if($user->hasRole('seller'))
      {

        $orders = Seller_order::where(['order_status'=>'CONFIRMED', 'seller_id'=>$user->seller_id])->OrderBy('id','DESC')->get();
        return view('seller::seller_dashboard', compact('orders'));
      } 

    if($user->hasRole('seller_care'))
    {
        return view('seller::clerk_dashboard');
    }

       return  view('seller::index');

    }


  public  function  login()
  {

    Auth::logout();
    return view('seller::auth.login');
  }


  public  function  register_seller()
  {

    return view('seller::auth.register_seller');
  }


  public  function  register(Request  $request)
  {

      Auth::logout();

      $request->validate([
              'first_name' => 'required|string|max:255',
              'last_name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|string|min:6|confirmed',

      ]);

     $requestData =  $request->all();

      $requestData['confirmation_token']= bin2hex(random_bytes(10)).rand(10000000,500000000).bin2hex(random_bytes(10));
      $requestData['active']=0;
        $requestData['password']=bcrypt($request->password);
        $requestData['is_seller']=1;



     $user= User::Create($requestData);

     $user->attachRole('10');
     $user->notify(new SellerConfirmation($user));

     Session::flash('flash_message',' Thank  you for creating  your  account . Please  check  your email  and  click  on  the  activation  link  to  activate  your account');

     return  redirect('seller/login');
  }


  public function my_promotions(){

      $user = Auth::user();

      if($user == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'You must be logged in to use this functionality.');

        return redirect('/seller/login');
      }
      $seller_id = $user->seller_id;

      if($seller_id == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'You have not completed the seller onboarding process. Ensure that you have updated your profile information and accepted our seller agreement.');
      }

      $seller_products = Product::where('seller_id', $seller_id)->get();
      $seller_products_ids = [];
      foreach ($seller_products as $product) {
        array_push($seller_products_ids, $product->id);
      }
      $promoted_products = [];

      $promotions = Product_price::whereIn('product_id', $seller_products_ids)->where('offer_price', '!=', null)->get();

      return view('seller::promotions.index', compact('promotions'));
  }


  public function activate_promotion($id){

      $user = Auth::user();

      if($user == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'You must be logged in to use this functionality.');

        return redirect('/seller/login');
      }

      //TO DO: Determine that you are the promotion's owner

      $promotion = Product_price::find($id);
      $promotion->status = 1;
      $promotion->save();

      Session::flash('alert-class', 'alert-success');
      Session::flash('flash_message', 'Your promotion has been successfully activated. Thank you.');

      return redirect(url()->previous());
  }


  public function deactivate_promotion($id){

    $user = Auth::user();

    if($user == null){

      Session::flash('alert-class', 'alert-danger');
      Session::flash('flash_message', 'You must be logged in to use this functionality.');

      return redirect('/seller/login');
    }

    //TO DO: Determine that you are the promotion's owner

    $promotion = Product_price::find($id);
    $promotion->status = 0;
    $promotion->save();

    Session::flash('alert-class', 'alert-success');
    Session::flash('flash_message', 'Your promotion has been successfully deactivated. Thank you.');

    return redirect(url()->previous());

  }


  public  function  manage_profile()
  {

    return  view('seller::manage_profile');
  }



  public  function  update_account(Request  $request)
  {

    $request->validate([
      'name'=>'required',
      'country_id'=>'required',
      'telephone'=>'required',
      'logo'=>'nullable|mimes:jpeg,png,bmp|max:2000',
      'contact_person'=>'required',
      'contact_telephone'=>'required',
      'contact_email_address'=>'required|email',
      'physical_location'=>'required',
      'city_id'=>'required',
      'area_id'=>'required',
      'email_address'=>'required',
      'telephone'=>'required',
      'id_front'=>'nullable|mimes:jpeg,png,bmp,pdf|max:2000',
      'id_back'=>'nullable|mimes:jpeg,png,bmp,pdf|max:2000',
      'licence'=>'nullable|mimes:jpeg,png,bmp,pdf|max:2000',

    ]);
   
    if(!empty($request->seller_id))
    {
        $requestData= $request->all();

       $seller= Seller::findorfail(Auth::user()->seller_id);

         $requestData = $this->seller_files($request,$requestData);

        // if($request->hasFile('logo'))
        // {

        // $destinationPath = 'logos';

        //    $file=$request->file('logo');

        //    $file_ext = str_replace('#', '', $file->getClientOriginalName());
        //    $file_ext = str_replace(' ', '_', $file_ext);


        //    $filename = time() . '-' . $file_ext;
        //    $upload_success = $file->move($destinationPath, $filename);
    
        //    $requestData['logo'] = $destinationPath.'/'.$filename;

        // }

       $seller->update($requestData);

    } else{
          
          $requestData= $request->all();

         $slug= str_slug($request->name);

          if(Seller::where('username',$slug)->exists())
         {

            $slug= $slug.rand(100,600);
         }

        $requestData['username']=  $slug;

        $requestData = $this->seller_files($request,$requestData);
        $requestData = $this->generate_seller_code($request,$requestData);

      
        $seller= Seller::create($requestData);

        $user=  User::find(Auth::user()->id);

        $user->seller_id= $seller->id;
        $user->save();  

    }
        
    Session::flash('flash_message',' You have successfully updated
     your business profile information. You can now list your
      products. Thank you and Happy Selling!');

    return  redirect()->back();
  
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


  public  function terms_conditions(Request  $request)
  {

    $request->validate([
      'terms'=>'required'
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

        return redirect('/seller/login');
      }

      $seller_id = $user->seller_id;

      if($seller_id == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'You have not completed the seller onboarding process. Ensure that you have updated your profile information and accepted our seller agreement.');

        return redirect(url()->previous());
      }
      return  view('seller::product_classify');
  }


  public  function  load_profile()
  {

    return  view('seller::users.profile');
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

    $request->validate(['category'=>'required']);

    return redirect('seller/products/new/'.$request->category);
  }


  public  function  products(Request  $request)
  {

  	 if($request->has('search'))
        {

        	//echo 'here';
        	//exit;
        	//dd($request->all());
        	  $products= Product::where('seller_id',Auth::user()->seller_id)->where( function($query) use ($request){

                if(!empty($request->name))
                {

                 $query->Where('name','like','%'.$request->name.'%');
                }
                    if(!empty($request->product_code))
                {

                 $query->orWhere('product_code','like','%'.$request->product_code.'%');
                }
                if(!empty($request->publish_status))
                {
                	
                 $query->orWhere('publish_status',$request->publish_status);
                }

            })->OrderBy('id','DESC')->limit(10)->get();



        } else{
        $products= Product::where('seller_id',Auth::user()->seller_id)->OrderBy('id','DESC')->limit(30)->get();

        }

         return  view('seller::products.index',compact('products'));
   
  }

  public function  new_product($category_id)
  {

     $title=  'New Product';
     $type = 'New';
     return view('seller::products.new_product',compact('category_id','title', 'type'));

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

   public  function  generate_seller_code($request,$requestData)
   {
  
         $seller_code= Seller::max('seller_code');
         $seller_code= $seller_code + 1;
            
            $requestData['seller_code']=$seller_code;
              
           // return  $seller_code;
       return  $requestData;

   }


  public  function  save_products(Request  $request)
  {

    $request->validate([
      'name'=>'required',
      'product_description'=>'required|min:150',
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

           $requestData['slug'] = $slug;
           $requestData['publish_status']= 0;
           $requestData['product_code']=$this->generate_product_code();

           $requestData['keywords'] = preg_replace('/,\s+/', ',', $requestData['keywords']);

           $product=  Product::Create($requestData);

           $product->categories()->attach($request->category_id);
           Session::flash('alert-class','alert-success');
           Session::flash('flash_message','Add more details to '.'"'.$request->name.'"');

           return  redirect('seller/product/'.$product->slug)->withInput(['tab'=>'tab2']);

    } else{
// New  Product
       $product=  Product::findorfail($request->product_id);
      // $product->categories()->attach($request->category_id);
       Category_product::where('product_id', $request->product_id)
        ->update(['category_id' => $request->category_id]);

       $requestData['keywords'] = preg_replace('/,\s+/', ',', $requestData['keywords']);

       $product->update($requestData);
       Session::flash('flash_message','Product details updated successfully');
        return  redirect('seller/product/'.$product->slug);

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
            There is no need to Save! You may proceed to the other sections.');
          
          return  redirect('seller/product/'.$product->slug)->withInput(['tab'=>'tab2']);
       }

       $requestData['keywords'] = preg_replace('/,\s+/gm', ',', $requestData['keywords']);     

       if($requestData['product_expiry_date'] != null){

         if(date('Y-m-d') > $requestData['product_expiry_date']){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error','Product expiry date cannot be in the past. Please correct!');
            return  redirect('seller/product/'.$product->slug)->withInput(['tab'=>'tab2']);
         }
       }

       $product->update($requestData);
       Session::flash('flash_message','Product details updated successfully');
        return  redirect('seller/product/'.$product->slug)->withInput(['tab'=>'tab3']);

  }

  public  function  manage_product($slug)
  {
    
    $product= Product::where('slug',$slug)->firstorfail();

    $category_id=  $product->category_id;

    return  view('seller::products.manage_product',compact('product','category_id'));

  }

  public  function  generate_sku($seller_id)
  {

     $seller= Seller::findorfail($seller_id);
    // if()
     $sku = Product_price::where('seller_code',$seller->seller_code)->max('skuid');
     if($sku > 0 )
     {
      $sku= $sku + 1;

     } else{

      $sku=1;
     }

     return  $sku;
   
     
  }


  public  function  add_price(Request  $request)
  {
    // $request->validate([
    //     'quantity'=>'required|numeric',
    //     'standard_price'=>'required|numeric',
    //     'product_id'=>'required|numeric'
    //   ]);

     $validator = Validator::make($request->all(), [
        'quantity'=>'required|numeric',
        'standard_price'=>'required|numeric',
        'product_id'=>'required|numeric'
       
        ]);

   if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput(['tab'=>'tab3']);
        }


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
      $seller= Seller::find(Auth::user()->seller_id);
      $requestData['skuid']= $this->generate_sku($seller->id);
      $requestData['seller_code']=$seller->seller_code;

      $requestData['is_default']=1;

      $requestData['item_size_id']=2;
     // $requestData['skuid']=generate_seller_code



      $price=  Product_price::create($requestData);

      Session::flash('flash_message', 'Price was added successfully');

      return  redirect()->back()->withInput(['tab'=>'tab3']);

  }



  public function update_price(Request  $request)
  {

     $validator = Validator::make($request->all(), [
        'quantity'=>'required|numeric',
        'standard_price'=>'required|numeric',
        'product_id'=>'required|numeric'
        ]);

   if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput(['tab'=>'tab3']);
        }

        
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

    return  view('seller::orders.index',compact('seller'));
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

         Session::flash('flash_message','Product Deleted');
         return redirect()->back();

       }

  }



  public  function  upload_images(Request $request)
  {
     $request->validate([
        'product_price_id'=>'required',
        'file'=>'required',
        'file' => 'dimensions:min_width=500,max_width=2000',
        'file' => 'dimensions:min_height=500,max_height=2000'
      ]);

       $product=  Product_price::find($request->product_price_id);

         if($product->images->count() > 5)
         {
         Session::flash('flash_message','You  have exceeded maximum  images');
           return  redirect()->back()->withInput(['tab'=>'tab3']);

         }

        $destinationPath = 'assets/images/products';

        $file=$request->file('file');

        if($file == null){

           Session::flash('flash_message',' No valid file selected!');
           return  redirect()->back()->withInput(['tab'=>'tab4']);
        }

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

    Session::flash('flash_message','The selected image has been set as the default
     image successfully');
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
       Session::flash('flash_message','Please  add  Prices and  images');

       return  redirect()->back();

      }

      $product->publish_status=  4;
      $product->submitted_by =  Auth::user()->id;

      $product->publish_date=  date('Y-m-d H:i:s');

      $product->save();

      Session::flash('flash_message',' Product submitted for QC successfully');

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


  public  function  process_order(Request  $request)
  {

    $request->validate([
      'seller_order_id'=>'required'
    ]);

    $order=  Seller_order::find($request->seller_order_id);

    $order->order_status = $request->order_status;
    if($request->order_status =='REJECTED')
    {
      $order->rejection_reason_id= $request->rejection_reason_id;
    }

    $order->save();

    if($request->order_status == 'ACCEPTED'){
      
      Session::flash('flash_message','You have accepted this order. Please proceed to prepare the order in accordance with our service level expectations. Note that speed, strict adherence to our standards and quality are critical to us and ultimately affects your rating at DIL.AFRICA');
    }else if($request->order_status == 'REJECTED'){
      
      Session::flash('flash_message','You have chosen not to accept this order. If we need a clarification from you, we will get in touch with you.');
    }else if($request->order_status == 'READY_FOR_PICKING'){
      
      Session::flash('flash_message','You have marked this order as ready for picking. Please ensure that you are set and available for our logistics officer.');
    }

    return  redirect()->back();

  }

  public function  manage_order($id)
  {
       $order=  Seller_order::findorfail($id);
       return  view('seller::orders.order_detail',compact('order'));
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
         
        Session::flash('flash_message','Your  account  was successfully activated, Please login 
          to proceed with Business  setup');
        return  redirect('seller/login');
    } else{
        // wrong  code
          
        Session::flash('flash_message','The confirmation link is invalid');
        return  redirect('seller/login');
    }
  }


  public function  sales_report(Request  $request)
  {

      $user = Auth::user();

      if($user == null) {

          Session::flash('alert-class', 'alert-danger');
          Session::flash('flash_message_error', 'You must be logged in to use this functionality!');

          return redirect('/seller/login');

      }

      $seller_id = $user->seller_id;

      if($seller_id == null) {

          Session::flash('alert-class', 'alert-danger');
          Session::flash('flash_message_error', 'You have not completed setting up your business profile. Please complete before using this functionality!');

          return redirect(url()->previous());

      }

      if($request->sales_report > 0)
      {       

        $orders=Seller_order::where(function($query) use($request){
        $from= $request->from.'00:00:00';
        $to= $request->to.' 23:59:00';
          
        $query->where('created_at','>', $from);
        $query->where('created_at','<', $to);
        $query->where('seller_id','<', $seller_id);

        })->OrderBy('id','DESC')->get();

      } else{

        $orders= Seller_order::where('seller_id', $seller_id)->OrderBy('id','DESC')->get();
  
      }

      return  view('seller::reports.sales_report',compact('orders'));
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
    return view('seller::products.promote_product', compact('product_price'));
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


  public function restore_depends_on(Request $request){

    $temp_categories = \App\Temp_category::get();

    foreach ($temp_categories as $temp) {
      
       Category::where('id', $temp->id)->update(['depends_on'=>$temp->depends_on]);
    }

    Session::flash('alert-class', 'alert-success');
    Session::flash('flash_message', 'Depends on restored successfully');
    return redirect(url()->previous());
  }


  public function restore_level(Request $request){

    $temp_categories = \App\Temp_category::get();

    foreach ($temp_categories as $temp) {
      
       Category::where('id', $temp->id)->update(['level'=>$temp->level]);
    }

    Session::flash('alert-class', 'alert-success');
    Session::flash('flash_message', 'Level restored successfully');
    return redirect(url()->previous());
  }


  public function update_level_two(Request $request){

    $temp_categories = \App\Temp_category::get();

    foreach ($temp_categories as $temp) {
      
      if($temp->level == 2){

          Category::where('id', $temp->id)->update(['level_two_category'=>$temp->id]);
      }else if($temp->level == 3){

        Category::where('id', $temp->id)->update(['level_two_category'=>$temp->depends_on]);
      }

    }

    Session::flash('alert-class', 'alert-success');
    Session::flash('flash_message', 'Level two categories added successfully');
    return redirect(url()->previous());
  }


  public  function  update_features(Request  $request)
  {
   // print_r($_POST);
   // dd($_POST);
   
  $features=[];

   foreach ($_POST as $key => $value) {
    $value= trim($value);
    if(is_numeric($key) && !empty($value))
    {

      // echo $value.'<br>';
      $features[]= [
        'product_id'=>$request->product_id,
        'feature_type_id'=>$key,
        'value'=>$value
      ];
        //Product_feature::where('product_id',$request->product_id)->update($features);

    }

  }

  Product_feature::where('product_id',$request->product_id)->delete();

 // Product_feature::where('product_id',$request->product_id)->update($features);
  Product_feature::insert($features);

   // dd($features);
   // exit;


     
    //Product_feature::where('product_id',$request->product_id)->delete();
     // if(is_numeric($key))
     // {


     //       if(Product_feature::where(['feature_type_id'=>$key,'product_id'=>$request->product_id])->exists())
     //       {
     //        if(empty($value))
     //        {
     //      Product_feature::where([
     //      'product_id'=>$request->product_id,
     //      'feature_type_id'=>$key         
     //     ])->delete();

     //        }  else{

     //         Product_feature::updateorCreate([
     //      'product_id'=>$request->product_id,
     //      'feature_type_id'=>$key         
     //     ],['value'=>$value]);

     //        }         
     //       }else{

     //       if(strlen($value) > 1)
     //       {
     //     Product_feature::Create([
     //      'product_id'=>$request->product_id,
     //      'feature_type_id'=>$key         
     //     ],['value'=>$value]);

     //       }

     //       }
      
     //      }
   //}
     
     Session::flash('flash_message','Updated');
       return redirect()->back()->withInput(['tab'=>'tab2']);   

  }


  public  function  seller_codes()
  {
 
       $sellers=  Seller::get();
       foreach($sellers  as $seller)
       {

        $seller_code= Seller::max('seller_code');
        $seller_code= $seller_code + 1;
        $seller->seller_code= $seller_code;
        $seller->save();
            
       }

  }


  public  function  product_prices_skus()
  {

     $product_prices=  Product_price::where('skuid',NULL)->get();

    // dd($product_prices);


     foreach($product_prices  as $price)
     {
        
      if(Product::where('id',$price->product_id)->exists())
      {

       $sku = $this->generate_sku($price->product->seller_id);
        $price->skuid= $sku;
        $price->seller_code= $price->product->seller->seller_code;
        $price->save();

      }

     }

  }


  public function  password_update()
  {

    return view('seller::change_password');
  }


  public  function  change_passwords(Request  $request)
  {
    $request->validate([
    'password'=>'required|min:5|max:20|confirmed',

    ]);

    $user= User::find(Auth::user()->id);

     $user->password= bcrypt($user->password);
     $user->reset_pass= 0;
     $user->save();
     
     Session::flash('flash_message', ' Your  password  has  been  updated  successfully');
   
    return  redirect('seller');
      


  }

}