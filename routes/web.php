<?php

//use  Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use  App\User;

Route::get('/', function () {
    
   // return view('coming_soon.index');
  return view('modules/customer/home/index');

});


Route::get('page', function () {
    //return view('modules/customer/home/index');
   return view('coming_soon.index');

});
Route::get('email_subscribe',function(){

  return  view('email_subscribe');
  //echo 'here';

});

Route::get('/{category}','HomeController@searchCategoryMini');

Route::post('coming_soon/subscribe','HomeController@subscribe');
Route::post('coming_soon/inquiry','HomeController@inquiry');

//$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
       

Auth::routes();

// Route::get('login','Auth\LoginController@showLoginForm')->name('login');
// Route::post('login','Auth\LoginController@login');

// Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
// Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Route::get('/login', function () {
  
//     return view('modules/customer/sign_in');
// });

Route::get('/login', function () {
    
   return redirect('/shop/sign-in');

});

Route::get('logout',function(){

    Auth::logout();
    return  redirect('/shop');

});

Route::get('/home', 'HomeController@index')->name('home');


Route::get('create_brand',function(Request  $request){

   return  view('create_brand');

});

Route::post('create_brand',function(){

  print_r($_POST);

});

Route::get('/backend', '\Modules\Backend\Http\Controllers\BackendController@index');
Route::resource('backend/cities', 'CitiesController');
//Route::resource('backend/users', 'UsersController');

Route::resource('admin/cities', 'CitiesController');

Route::get('confirm_account/{confirmation}',function($confirmation){
    
    $user = User::where('confirmation_token',$confirmation)->first();
    if(User::where('confirmation_token',$confirmation)->exists())
    {
         User::where('confirmation_token',$confirmation)->update([
           
             'active'=>1,
             'confirmation_token'=>NULL
         ]);
         
        Session::flash('flash_message','Successful, Please  login  to contine');
        return  redirect('login');
    } else{
        // wrong  code
          
        Session::flash('flash_message','The confirmation link is invalid');
        return  redirect('login');
        
    }
     
});

Route::resource('backend/fourth_categories', 'Fourth_categoriesController');
Route::resource('backend/fifth_categories', 'Fifth_categoriesController');


Route::get('process_job',function(){

    App\Jobs\ProcessSellerOrders::dispatch();

});

//Route::resource('backend/orders', 'OrdersController');

Route::get('/test', function()
{
  $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
    $beautymail->send('emails.welcome', [], function($message)
    {
        $message
      ->from('bar@example.com')
      ->to('foo@example.com', 'John Smith')
      ->subject('Welcome!');
    });

});



Route::resource('backend/subject_types', 'Subject_typesController');

Route::get('blog', 'BlogController@all');
Route::get('blog/{url}', 'BlogController@show');
Route::get('blog/tags/{tag}', 'BlogController@tag');

Route::get('page/{url}', 'PagesController@show');

Route::resource('backend/popular_products', 'Popular_productsController');
Route::resource('backend/featured_products', 'Featured_productsController');
Route::resource('backend/top_brands', 'Top_brandsController');
Route::resource('backend/new_arrivals', 'New_arrivalsController');
Route::resource('backend/trending_products', 'Trending_productsController');

Route::get('{url}', function ($url) {
    return app(App\Http\Controllers\Cms\PagesController::class)->show($url);
})->where('url', '([A-z\d-\/_.]+)?');