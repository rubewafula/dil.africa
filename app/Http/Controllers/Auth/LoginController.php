<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use  Auth;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected  function  authenticated(Request $request, $user)
    {

      //  dd($user);

        if($user->hasRole('admin'))
        {

            return redirect()->intended('backend');

        }
        if($user->hasRole('logistics'))
        {
            return redirect()->intended('logistics');
        }
         if($user->hasRole('seller'))
         {      
        
            if($user->active < 1)
            {
                
                Auth::logout();
                Session::flash('alert-class','alert-danger');
                Session::flash('flash_message','Your account has not  been  activated . Please  check  your  email  and click  on  the  activation  link');
                return redirect('seller/login');

            } else{

               // dd("Here");
             return redirect()->intended('seller');

            }

         }

        if($user->hasRole('seller_care'))
        {

           return redirect()->intended('seller');

        }
        if($user->hasRole('qc'))
        {

           return redirect()->intended('qc');

        }
        if($user->is_customer == 1)
        {
            $cart = Session::get('cart');

            if($cart != null) {

                return redirect('/shop/checkout/delivery'); 
            }else {

                return redirect('/shop/history'); 
            }
        }

    }


}