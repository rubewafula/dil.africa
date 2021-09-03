<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use  App\User;
use Auth;
use  Session;
use Modules\Backend\Entities\AfricasTalkingGateway;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('seller::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($seller_id)
    {
        return view('accounts::users.create',compact('seller_id'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {


        $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email'=>'required|email|unique:users|max:100',
             'password'=>'required|min:5|max:20',
             'role_id'=>'required'
        ]);


        $requestData = $request->all();

        $requestData['password']= bcrypt($request->password);

       
        $user=   User::create($requestData);

        $user->attachRole($request->role_id);
        Session::flash('flash_message','updated successfully');

        return  redirect('accounts/sellers/manage/'.$request->seller_id);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('seller::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id,  Request  $request)
    {

        $user=  User::find($id);
        return view('accounts::users.edit',compact('user'));


    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id,Request $request)
    {

        $user=  User::find($id);


          $request->validate([
             'first_name'=>'required',
             'last_name'=>'required',
             'email' => 'unique:users,email,'.$id,
             'password'=>'nullable|min:5|max:20',
        ]);
        
        $requestData = $request->except('password');

  if(!empty($request->password))
  {
    $requestData['password']= bcrypt($request->password);

  }

        
        $user->update($requestData);

        if($request->has('role_id'))
        {

            $user->attachRole($request->role_id);
        }

	return  redirect('accounts/sellers/manage/'.$request->seller_id)->with('flash_message', 'User updated!');


    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }


      public function manage_users()
  {

    $users=  User::where('seller_id',Auth::user()->seller_id)->paginate(20);


      return  view('seller::users.manage_users',compact('users'));

  }


  public  function  create_user(Request  $request)
  {
        $request->validate([
             'first_name'=>'required',
             'email' => 'required',
             'phone'=>'required',
             'seller_id'=>'required',
             'role_id'=>'required'
        ]);



        if(User::where('email',$request->email)->exists())
        {
            $user= User::where('email',$request->email)->first();
            $user->seller_id= $request->seller_id;
            $user->attachRole($request->role_id);
            $user->save();

        } else{

            $user= User::Create([
              'first_name'=>$request->first_name,
              'last_name'=>$request->last_name,
              'email'=>$request->email,
              'phone'=>$request->phone,
              'active'=>1,
              'is_seller'=>1,
              'reset_pass'=>1,
              'password'=>bcrypt($request->phone),
              'seller_id'=>$request->seller_id

            ]);

            $user->attachRole($request->role_id);
            $user->seller_id= $request->seller_id;
            if($request->role_id == 10 )
            {
           //  Send  sms  to  seller  on profile  created
                $message= 'Thank you for registering on WWW.DIL.AFRICA. Your seller account has been created.To access  your  account use Email:'.$request->email .' Password: '.$request->password.' to start  selling today. Call 0797522522 for more info';

             //  Seller  account  ,send  them  the  password 
             $phone= $request->phone;

            $this->sendSMS($phone,$message);
       
            }
       }

       Session::flash('flash_message','User  was added  successfully');

       return  redirect()->back();
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



    public function  delete_user($id)
    {
    
        $user= User::find($id);

        if($user->hasRole('seller'))
        {
            Session::flash('alert-class','alert-error');
            Session::flash('flash_message',' You  cannot delete this  user');

        } else{

       $user->delete();

         Session::flash('flash_message','User  was  deleted successfully');

        }
      return   redirect()->back();
    }



}
