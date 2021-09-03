<?php

namespace Modules\Customer\Http\Controllers;

use Auth;
use Socialite;

use Modules\Customer\Entities\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //
    
    protected $redirectTo = '/shop/home';
    
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        
//        dd($user);

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {

        // dd($user);
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        
        $registeredUser = User::where('email', $user->email)->get();
        
        if(count($registeredUser) > 0){
            
            User::where('email', $user->email)->update(['provider' => $provider,
                'provider_id' => $user->id]);
            
            return $registeredUser->first();
        }
        
        $nickname = "";
        
        if($provider == 'facebook'){
            
            $nickname = $user->id;
        }else if($provider == 'twitter'){
            
            $nickname = $user->nickname."_".$user->id;
        }
        
        return User::create([
            'socialmedia_name'     => $user->name,
            'first_name'     => $user->name,
            'email'    => $user->email,
            'active'    => 1,
            'real_socialmedia_username'    => $user->nickname,
            'profile_path'    => $user->avatar_original,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
