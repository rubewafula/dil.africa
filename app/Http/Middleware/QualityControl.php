<?php

namespace App\Http\Middleware;

use Closure;
use  Auth;
use  App\User;
use  Session;

class QualityControl
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

         if($user->hasRole('qc'))
         {

                return $next($request);


         } else{

            Session::flash('alert-class','alert-danger');
            Session::flash('flash_message',' You\'re not  authorized  to access  this  page');
             return  redirect('/qc/login');


         }
     } else{

          Session::flash('alert-class','alert-danger');
            Session::flash('flash_message','Please  login  to  access  this  page');
             return  redirect('/qc/login');

     }
    }
}
