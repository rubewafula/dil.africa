<?php

namespace Modules\Accounts\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seller;
use Illuminate\Http\Request;
use Modules\Accounts\Entities\AfricasTalkingGateway;
use Illuminate\Support\Facades\Log;
use  App\User;
use  Auth;

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
        $perPage = 5;

        if (!empty($keyword)) {
            $sellers = Seller::where('name', 'LIKE', "%$keyword%")
               ->orWhere('seller_code', 'LIKE', "%$keyword%")
                ->orWhere('email_address', 'LIKE', "%$keyword%")
                ->orWhere('telephone', 'LIKE', "%$keyword%")
                ->latest()->where('account_manager',Auth::user()->id)->paginate($perPage);
        } else {
            $sellers = Seller::latest()->where('account_manager',Auth::user()->id)->paginate($perPage);
        }

        return view('accounts::sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('accounts::sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector



     */


    public  function  generate_seller_code($request,$requestData)
   {
  
         $seller_code= Seller::max('seller_code');
         $seller_code= $seller_code + 1;
            
            $requestData['seller_code']=$seller_code;
              
           // return  $seller_code;
       return  $requestData;

   }
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'status'=>'required',
            'country_id'=>'required',
            'logo'=>'nullable|mimes:jpeg,png,bmp|max:2000',
            'category_id'=>'required',
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

         $requestData['account_manager']= Auth::user()->id;
        $requestData = $this->generate_seller_code($request,$requestData);

            Seller::Create($requestData);

        return redirect('accounts/sellers')->with('flash_message', 'Seller added!');
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

        return view('accounts::sellers.show', compact('seller'));
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

        return view('accounts::sellers.edit', compact('seller'));
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
       

        $requestData = $this->seller_files($request,$requestData);
        
        $seller = Seller::findOrFail($id);
        $seller->update($requestData);

        return redirect()->back()->with('flash_message', 'Seller updated!');
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

        return redirect('accounts/sellers')->with('flash_message', 'Seller deleted!');
    }


    public  function  manage($id)
    {

      $seller= Seller::findOrFail($id);
      $title= 'Manage Seller '.$seller->name;


      return  view('accounts::sellers.manage_seller',compact('seller','title'));


    }


    public  function  new_user($seller_id)
    {


         return  view('accounts::sellers.new_user',compact('seller_id'));

    }



    public  function  add_new_user(Request  $request)
    {

 $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email'=>'required|email',
             'phone'=>'required',
             'password'=>'required|min:5|max:20',
             'role_id'=>'required'
        ]);


        $requestData = $request->all();

        $requestData['password']= bcrypt($request->password);
        $requestData['is_seller'] = 1;
        $requestData['reset_pass'] = 1;
        $requestData['active'] = 1;
        
        $user=   User::create($requestData);

        $user->attachRole($request->role_id);
        
        if($request->role_id == 10 )
        {
            $message= 'Thank you for registering on WWW.DIL.AFRICA. Your seller account has been created.To access  your  account use Email:'.$request->email .' Password: '.$request->password.' to start  selling today. Call 0797522522 for more info';

             //  Seller  account  ,send  them  the  password 
             $phone= $request->phone;

            $this->sendSMS($phone,$message);
       
        }

        return  redirect('accounts/sellers')->with('flash_message', ' Seller  account was created!');;

    }






     public static function sendSMS($recipients, $message){

        $username   = "anjoroge_DIL";
        $apikey     = "1844a17f33e32617249aecd038ae288fb77bd93ca581c6a2a30ffb8c6a7e3206";

        // Specify the numbers that you want to send to in a comma-separated list
        // Please ensure you include the country code (+254 for Kenya in this case)

        // Create a new instance of our awesome gateway class
        $gateway  = new AfricasTalkingGateway($username, $apikey);

        $from = "DIL-AFRICA";

        // Any gateway error will be captured by our custom Exception class below, 
        // so wrap the call in a try-catch block
        try 
        { 
          // Thats it, hit send and we'll take care of the rest. 
          $results = $gateway->sendMessage($recipients, $message, $from);
                    
          foreach($results as $result) {
            // status is either "Success" or "error message"

            Log::info(" Number: " .$result->number." Status: " .$result->status." StatusCode: " .$result->statusCode." MessageId: " .$result->messageId." Cost: "   .$result->cost);
          }
        }
        catch ( AfricasTalkingGatewayException $e )
        {
          Log::error( "Encountered an error while sending: ".$e->getMessage());
        }
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


     public  function  new_product($seller_id)
     {

        return  view('accounts::product_classify',compact('seller_id'));



     }


}
