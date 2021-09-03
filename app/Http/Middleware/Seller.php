<?php

namespace App\Http\Middleware;

use Closure;
use  Auth;
use  App\User;
use  Session;

class Seller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          
         if(Auth::user())
         {
         $user=  User::find(Auth::user()->id);

         if($user->hasRole('seller')|| $user->hasRole('seller_care'))
         {

                return $next($request);

             // if($user->seller_id < 1)
             // {
             //    Session::flash('alert-class','alert-info');
             //   Session::flash('flash_message','Please create  your shop  details to continue');
             //    return  redirect('seller/manage_profile');
             // }else
             // {

             // return $next($request);

             // }
         


         } else{

            Session::flash('alert-class','alert-danger');
            Session::flash('flash_message',' You\'re not  authorized  to access  this  page');
             return  redirect('/seller/login');


         }
     } else{

          Session::flash('alert-class','alert-danger');
            Session::flash('flash_message','Please  login  to  access  this  page');
             return  redirect('/seller/login');

     }
    }
}
