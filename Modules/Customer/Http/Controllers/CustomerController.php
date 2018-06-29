<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Auth;
use Session;

use Modules\Customer\Entities\Product;
use Modules\Customer\Entities\History_visit;
use Modules\Customer\Entities\Cart_session;
use Modules\Customer\Entities\Product_price;
use Modules\Customer\Entities\Seller;
use Modules\Customer\Entities\Product_image;
use Modules\Customer\Entities\User;
use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\Payment_gateway;
use Modules\Customer\Entities\Shipping_cost;
use Modules\Customer\Entities\Area;
use Modules\Customer\Entities\Order;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Zone;
use Modules\Customer\Entities\Customer_wishlist;
use Modules\Customer\Entities\Brand;
use Modules\Customer\Entities\Newsletter_subscription;
use Modules\Customer\Entities\Product_review;
use Modules\Customer\Entities\Voucher;

use Modules\Customer\Notifications\UserConfirmation;

use Modules\Customer\Utilities\Utilities;
use Modules\Customer\Utilities\CartItem;
use Modules\Customer\Utilities\MiniCartItem;

use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('modules/customer/home/index');
    }

    
    public function product_detail(Request $request, $id)
    {
        $ip_address = $request->ip();
        
        $user_id = null;
        $product = Product::findorfail($id);
        
        if(Auth::check()){
            
            $user_id = Auth::user()->id;
        }
        
        $history_visit = new History_visit();
        
        $history_visit->ip_address = $ip_address;
        $history_visit->product_id = $id;
        $history_visit->user_id = $user_id;
        
        $history_visit->save();
        
        $related = History_visit::where('ip_address', '!=', $ip_address)
                ->where('product_id', $id)->orderBy('id', 'DESC')->limit(10)->get();
        
        $related_products = [];
        
        foreach($related as $rel){
            
            $viewed = History_visit::where('product_id', '!=', $rel->product_id)
                    ->where('ip_address', $rel->ip_address)->limit(3)->get();
            
            foreach($viewed as $view){
                
                array_push($related_products, $view);
            }         
            
        }
        return view('modules/customer/product/index', compact('related_products',
                'product'));
    }
    
    
    public function add_to_cart(Request $request)
    {

        $quantity = $request->quantity;
        $product_id = $request->product_ref;
        
        $cart_session = new Cart_session();
        
        if(Auth::user() != null){
            
            $user_sessions = Cart_session::where('user_id', 
                    Auth::user()->id)->get();
            $cart_session->user_id = Auth::user()->id;
        }else{
            
             $user_sessions = Cart_session::where('ip_address', 
                    $request->ip())->get();
        }
        
        $cart_session->ip_address = $request->ip();     
        $cart_session->product_price_id = $product_id;
        $cart_session->quantity = $quantity;
        
        $cart_session->save();
               
        $cart = Session::get('cart');     
        
        if($cart != null){
            
            if(array_key_exists($product_id, $cart)){
                
                $miniCartItem = $cart[$product_id];
                if($quantity == 1){
                    $miniCartItem->setQuantity($miniCartItem->getQuantity()+1);
                }else{
                    $miniCartItem->setQuantity($quantity);
                }
            }else{
                
                $miniCartItem = new MiniCartItem($product_id, $quantity);               
            }
            $cart[$product_id] = $miniCartItem;
            Session::put('cart', $cart);
        }else {
            
            $items = [];
            $miniCartItem = new MiniCartItem($product_id, $quantity); 
            $items[$product_id] = $miniCartItem;
//            array_push($items, $miniCartItem);
            Session::put('cart', $items);
        }
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Item added to your cart successfully!');

        return redirect()->intended(url('/shop/cart'));
    }


    public function updateCart(Request $request)
    {

        $data = $request->data;
               
        $cart = Session::get('cart'); 

        $items = explode(",", $data); 
        
        foreach ($items as $item) {
            
            $splitted = explode(":", $item);
            $product_id = $splitted[0];
            $quantity = $splitted[1];

            if($cart != null){
                
                if(array_key_exists($product_id, $cart)){
                    
                    $miniCartItem = $cart[$product_id];
                    $miniCartItem->setQuantity($quantity);
                }else{
                    
                    $miniCartItem = new MiniCartItem($product_id, $quantity);               
                }
                $cart[$product_id] = $miniCartItem;
                Session::put('cart', $cart);
            }else {
                
                $items = [];
                $miniCartItem = new MiniCartItem($product_id, $quantity); 
                $items[$product_id] = $miniCartItem;
                Session::put('cart', $items);
            }
        }
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Your cart has been updated successfully!');

        return response()->json(['status' => 200]);
    }


    public function applyVoucher(Request $request){

        $voucher_no = $request->voucher_no;

        $voucher_details = Voucher::where('voucher_code', $voucher_no)->first();

        if($voucher_details == null){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'The voucher number you entered is non-existent! Please verify the number.');

            return redirect('/shop/cart');
        }

        $user = $voucher_details->user_id;

        if($user != null) {

            $loggedInUser = Auth::user();

            if($loggedInUser == null){

                Session::put('page', '/shop/cart');

                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('flash_message_error', 'You must be logged in to use this voucher. Please use the login link to login.');

                return redirect('/shop/cart');
            }

            if($loggedInUser->id != $user){

                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('flash_message_error', 'The voucher number you entered is not attached to your account. Please verify.');

                return redirect('/shop/cart');
            }

        }

        $voucher_type = $voucher_details->voucher_type;

        if($voucher_details->status != 1){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'The voucher number you entered is not active. Please verify.');

            return redirect('/shop/cart');
        }

        $active_from = $voucher_details->active_from;
        $active_to = $voucher_details->active_to;

        if(!empty($active_from) and !empty($active_to)){

            if($active_from > date('Y-m-d')){

                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('flash_message_error', "This voucher's period is not yet active. Please verify.");

                return redirect('/shop/cart');

            }
            if($active_to < date('Y-m-d')){

                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('flash_message_error', "This voucher's period has already expired. Please verify.");

                return redirect('/shop/cart');

            }

            $product = $voucher_details->product_id;

            if($product != NULL){

                 $cart_products_ids = Utilities::getCartProductsIds();

                if(!in_array($product, $cart_products_ids)){

                    Session::flash('alert-class', 'alert-danger'); 
                    Session::flash('flash_message_error', 'The voucher number you entered is not applicable for any products in your cart. Please verify.');

                    return redirect('/shop/cart');
                }
            }

            $category = $voucher_details->category_id;

            if($category != NULL){

                $product_categories = Utilities::getCartCategoriesIds();

                if(!in_array($category, $product_categories)){

                    Session::flash('alert-class', 'alert-danger'); 
                    Session::flash('flash_message_error', "This voucher does not apply for any of the product categories in your cart. Please verify.");

                    return redirect('/shop/cart');
                }
            }

        }

    }

    

    public function sign_in(){
        
        return view('modules/customer/sign_in');
    }
    
    public function checkout(){
        
        return view('modules/customer/checkout/checkout');
    }
    
    public function delivery(){
          
        $userId = Session::get("userId");
        
        if($userId == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please select the checkout method'
                    . ' first to continue!');
            
            return redirect('shop/checkout');
        }
        $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        $stations = User_pickup_location::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/checkout/delivery_information',
                compact('userId', 'user_address', 'addresses', 'stations'));
    }
    
    
    public function my_account(){
          
        $user = Auth::user();       
        
        if($user == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Please login to continue!');
            
            return redirect('shop/sign-in');
        }
        
        $userId = $user->id;
        $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/checkout/delivery_information',
                compact('userId', 'user_address', 'addresses'));
    }
    
    public function delivery_update($id){
        
        $user_address = User_address::findorfail($id);
        $userId = $user_address->user_id;
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/checkout/delivery_information',
                compact('user_address', 'userId', 'addresses'));
    }
    
    public function make_default_address(Request $request){           
        
        $user_address_id = $request->address;
        $address = User_address::findorfail($user_address_id);
        $userId = $address->user_id;   
        
        User_address::where('user_id', $userId)->update(['default' => 0]);
        
        $address->default = 1;
        $address->save();
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        $stations = User_pickup_location::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Address set as your default one '
                . 'successfully');
        
        return view('modules/customer/checkout/delivery_information',
                compact('user_address', 'userId', 'addresses', 'stations'));
    }
    
    
    public function make_default_pickup(Request $request){           
        
        $user_address_id = $request->address;
        $address = User_pickup_location::findorfail($user_address_id);
        $userId = $address->user_id;   
        
        User_pickup_location::where('user_id', $userId)->update(['default' => 0]);
        
        $address->default = 1;
        $address->save();
        
        $addresses = User_address::where('user_id', $userId)->orderBy('id',
                'DESC')->get();
        
        $stations = User_pickup_location::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Pickup location set as your default one '
                . 'successfully');
        
        return view('modules/customer/checkout/delivery_information',
                compact('user_address', 'userId', 'addresses', 'stations'));
    }
    
    
    public function payment(){
        
        $userId = Session::get('userId');
        
        if($userId == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please select the checkout method'
                    . ' first to continue!');
            
            return redirect('shop/checkout');
        }
        
        $user_address_id = Session::get('user_address_id');
        if($user_address_id == null){
            
            $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Please specify the delivery address'
                    . ' first to continue!');
            
            return view('modules/customer/checkout/delivery_information',
                    compact('userId', 'user_address'));
        }
        return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id'));
    }
    
    public function order_review(){
        
        $userId = Session::get('userId');
        
        if($userId == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please select the checkout method'
                    . ' first to continue!');
            
            return redirect('shop/checkout');
        }else{
            
            
        }
        $user_address_id = Session::get('user_address_id');
        if($user_address_id == null){
            
            $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please specify the delivery address'
                    . ' first to continue!');
            
            return view('modules/customer/checkout/delivery_information',
                    compact('userId', 'user_address'));
        }
        $payment_option = Session::get('payment_option');
        if($payment_option == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please specify the payment option'
                    . ' first to continue!');
            
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id'));
        }
        return view('modules/customer/checkout/order_review');
    }
        
    public function contact_us(){
        
        return view('modules/customer/contact_us');
    }
    
    public function load_register(){
        
        return view('modules/customer/checkout/register');
    }
    
    public function guest_checkout(){
        
        return view('modules/customer/checkout/guest_email');
    }
    
    public function guest_update($id){
        
        $user = User::findorfail($id);
        return view('modules/customer/checkout/guest_email', compact('user'));
    }
       
    
    public function tran_success($id){
        
        $order = Order::findorfail($id);
        $order_id = $order->id;
        return view('modules/customer/checkout/complete_transaction',
                compact("order", 'order_id'));
    }
    
    public function tran_cancel($id){
        
        $order = Order::findorfail($id);
        $order->order_status = "PAYMENT CANCELLED";
        $order->save();
                
        return view('modules/customer/checkout/transaction_cancelled',
                compact('order'));
    }
    
    public function cart(){
        
//        if(Auth::user() != null){
//            
//            $user_sessions = Cart_session::where('user_id', 
//                    Auth::user()->id)->get();
//        }else{
//            
//            $ip_address = Utilities::getRealIpAddr();
//            $user_sessions = Cart_session::where('ip_address', $ip_address)->get();
//        }
        
        $cart = Session::get('cart');
        
//        dd($cart);
        
        $cart_items = [];
        $total = 0;
        $tax = 0;
        
        if($cart != null) {
            
            if(count($cart) > 0) {

                foreach($cart as $session){

                    $quantity = $session->getQuantity();
                    $product_price_id = $session->getProductPriceId();
                    $productPrice = Product_price::findorfail($product_price_id);
                    $price = $productPrice->offer_price;

                    if($price == null){

                        $price = $productPrice->standard_price;
                    }

                    $product_id = $productPrice->product_id;
                    $product = Product::findorfail($product_id);              
                    $seller = Seller::findorfail($product->seller_id)->name;
                    $product_image = Product_image::where('product_id', $product_id)
                            ->where('default', 1)->limit(1)->first()->image_url;
                    $product_name = $product->name;
                    $subtotal = $price * $quantity;
                    if($product->tax_class > 0){

                        $tax += ($subtotal * ($product->tax_class/100));
                    }
                    $total += $subtotal;
                    $session_id = 1;

                    $cartItem = new CartItem($product_price_id, $quantity, $seller, 
                            $product_image, $product_name, $price, $subtotal,
                            $session_id);

                    array_push($cart_items, $cartItem);
                }
            }
        }
        
        Session::put('cart_items', $cart_items);
        Session::put('tax', $tax);
        return view('modules/customer/cart', compact('cart_items', 'total',
                'tax'));
    }
    
    
    public function remove_from_cart($id){
        
//        Cart_session::destroy($id);
//        
//        if(Auth::user() != null){
//            
//            $user_sessions = Cart_session::where('user_id', 
//                    Auth::user()->id)->get();
//        }else{
//            
//            $ip_address = Utilities::getRealIpAddr();
//            $user_sessions = Cart_session::where('ip_address', $ip_address)->get();
//        }
        
        $cart = Session::get('cart');
        
        if(count($cart) > 0){
            
            array_splice($cart, $id, 1);
        }
        Session::put('cart', $cart);
        
        $cart_items = [];
        $total = 0;
        $tax = 0;
        
        if(count($cart) > 0) {
            
            foreach($cart as $session){

                $quantity = $session->getQuantity();
                $product_price_id = $session->getProductPriceId();
                $productPrice = Product_price::findorfail($product_price_id);
                $price = $productPrice->offer_price;

                if($price == null){

                    $price = $productPrice->standard_price;
                }

                $product_id = $productPrice->product_id;
                $product = Product::findorfail($product_id);              
                $seller = Seller::findorfail($product->seller_id)->name;
                $product_image = Product_image::where('product_id', $product_id)
                        ->where('default', 1)->limit(1)->first()->image_url;
                $product_name = $product->name;
                $subtotal = $price * $quantity;
                if($product->tax_class > 0){
                    
                    $tax += ($subtotal * ($product->tax_class/100));
                }
                $total += $subtotal;
                $session_id = 1;

                $cartItem = new CartItem($product_price_id, $quantity, $seller, 
                        $product_image, $product_name, $price, $subtotal,
                        $session_id);

                array_push($cart_items, $cartItem);
            }
        }
        Session::put('cart_items', $cart_items);
        Session::put('tax', $tax);
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Item removed from your cart successfully!');
        
        return view('modules/customer/cart', compact('cart_items', 'total',
                'tax'));
    }
    
       
    public function terms_conditions(){
        
        return view('modules/customer/terms_conditions');
    }

    public function register_guest(Request $request){
        
        $email = $request->email;
        $userId = 0;
        
        if(!Utilities::userExists($email)){
            
            $first_name = $request->first_name;
            $last_name = $request->last_name;      
            $password = bcrypt($first_name);
            $active = 1;

            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = $password;
            $user->active = $active;
            $user->email = $email;

            $user->save();
            $userId = $user->id;
        }else {
            
            $userId = User::where('email', $email)->first()->id;
            $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
        }
        
        Session::put('userId', $userId);
        
        return view('modules/customer/checkout/delivery_information',
                compact('userId', 'user_address'));
    }
    
    public function registerCustomer(Request $request){
        
        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $area = $request->area;
        $country = $request->country;
        $city = $request->city;
        $zone = $request->zone;
        $phone = $request->phone;
        $password = $request->password;
        $conf_password = $request->conf_password;
        
        if($password != $conf_password){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Passwords do not match. '
                    . 'Please correct!');
            
            return redirect(url()->previous());
        }
        
        $userId = 0;
        $token = bin2hex(random_bytes(10)).rand(10000000,500000000).bin2hex(random_bytes(10));
        
        if(!Utilities::userExists($email)){
            
            $first_name = $first_name;
            $last_name = $last_name;      
            $active = 0;            
            
            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = bcrypt($password);
            $user->active = $active;
            $user->email = $email;
            $user->confirmation_token = $token;
            $user->is_customer = 1;

            $user->save();
            $userId = $user->id;
            
            $user_address = new User_address();
            
            $user_address->user_id = $userId;
            $user_address->ip_address = $request->ip();
            $user_address->city_id = $city;
            $user_address->default = 1;
            $user_address->country_id = $country;
            $user_address->zone_id = $zone;
            $user_address->area_id = $area;
            $user_address->telephone = $phone;
            
            $user_address->save();
            
            $user->notify(new UserConfirmation($user));
            
        }else {
            
            $user = User::where('email', $email)->first();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = bcrypt($password);
            $user->confirmation_token = $token;

            $user->save();
            $userId = $user->id;
            
            $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();
            if($user_address == null){
                
                $user_address = new User_address();           
            }
            
            $user_address->user_id = $userId;
            $user_address->ip_address = $request->ip();
            $user_address->city_id = $city;
            $user_address->country_id = $country;
            $user_address->zone_id = $zone;
            $user_address->area_id = $area;
            $user_address->telephone = $phone;

            $user_address->save();
            
            $user->notify(new UserConfirmation($user));
                      
        }
        
        Auth::login($user);
        Session::put('userId', $userId);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'You have registered successfully!');
        
        return view('modules/customer/checkout/delivery_information',
                compact('userId', 'user_address'));
    }
    
    
    public function confirm_account($confirmation){
        
        if(User::where('confirmation_token',$confirmation)->exists())
        {
             User::where('confirmation_token',$confirmation)->update([

                 'active'=>1,
                 'confirmation_token'=>NULL
             ]);

             Session::flash('flash_message','Your account has been successfully'
                     . ' verified. Thank you for choosing DIL.Africa');
            return  redirect('/shop/wishlist');
        } else{
            // wrong  code

            Session::flash('flash_message','The confirmation link used is invalid');
            return  redirect()->intended(url()->previous());

        }
    }


    public function login(Request $request){

        $email = $request->email;
        $password = $request->password;
        
        $user = User::where('email', $email)->first();
        Session::put("userId", $user->id);
        
        if ($user && Hash::check($password, $user->password)){
            
            Auth::login($user);
            Session::put('userId', $user->id);
            
            $page = Session::get('page');
            
            Session::flash('alert-class', 'alert-success');
            Session::flash('flash_message', 'Welcome to DIL AFRICA '.$user->first_name);
            
            if($page != null){
                
                return redirect($page);
            }else{
               return redirect('/shop/checkout/delivery'); 
            }
            
        }else {
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Wrong email or password! Please try again!');
            return redirect(url()->previous());
        }
    }

    public function saveAddress(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->user_id;
        }
        
        $this->validate($request,['country' => 'required', 'zone' => 'required',
            'city' => 'required', 'area' => 'required']);
        
        $address_id = $request->user_address_id;
        $telephone = $request->telephone;
        $area = $request->area;
        $building = $request->building;
        $floor = $request->floor;
        $street = $request->street;
        $country = $request->country;
        $city = $request->city;
        $landmark = $request->landmark;
        $description = $request->description;
        $preffered = $request->default;
        
        if(strlen($address_id) == 0){

            $user_address = new User_address();

        }else {
            
            $user_address = User_address::findorfail($address_id);
        }
        $user_address->user_id = $userId;
        $user_address->telephone = $telephone;
        $user_address->area_id = $area;
        $user_address->building = $building;
        $user_address->floor = $floor;
        $user_address->street = $street;
        $user_address->country_id = $country;
        $user_address->city_id = $city;
        $user_address->landmark = $landmark;
        $user_address->description = $description;
        
        if($preffered == 1){
            
            User_address::where('user_id', $userId)->update(['default' => 0]);
        }
        $user_address->default = $preffered;
        
        $user_address->save();
        
        $user_address_id = $user_address->id;
        
        Session::put('delivery_type', 'home_office_delivery');
        Session::put('user_address_id', $user_address_id);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Address Details saved successfully!');
        
        $cart = Session::get('cart');
        if($cart != null){
            
            if(count($cart) > 0){
                
                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id'));
            }
        }
            
        return redirect(url()->previous());
    }
    
    
    public function savePickupLocation(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->user_id;
        }
        
        $request->validate(['country' => 'required', 'city' => 'required',
            'zone' => 'required', 'area' => 'required', 'pickup_location'
            => 'required']);
        
        
        $pickuplocation_id = $request->user_pickuplocation_id;
        $pickup_station = $request->pickup_location;
        $preffered = $request->default;
        
        if(strlen($pickuplocation_id) == 0){

            $user_pickuplocation = new User_pickup_location();

        }else {
            
            $user_pickuplocation = User_pickup_location::findorfail($pickuplocation_id);
        }
        $user_pickuplocation->user_id = $userId;
        $user_pickuplocation->warehouse_id = $pickup_station;
        
        if($preffered == 1){
            
            User_pickup_location::where('user_id', $userId)
                    ->update(['default' => 0]);
        }
        $user_pickuplocation->default = $preffered;
        
        $user_pickuplocation->save();
        
        $user_pickuplocation_id = $user_pickuplocation->id;
        
        Session::put('user_address_id', $user_pickuplocation_id);
        Session::put('delivery_type', 'pickup');
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Pickup station set successfully!');
        
        $cart = Session::get('cart');
        if($cart != null){
            
            if(count($cart) > 0){
                
                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_pickuplocation_id'));
            }
        }
            
        return redirect(url()->previous());
    }
    
    
    public function continue_payment() {
        
        $delivery_type = Session::get('delivery_type');
        $user_address_id = Session::get('user_address_id');
        $userId = Session::get('userId');
        
        if($delivery_type == 'pickup'){
            
            if($user_address_id == "0" || $user_address_id == ""){
            
                $user_address = User_pickup_location::where('user_id',
                        $userId)->where('default', 1)->first();
                
                if($user_address != null){
                    
                    $user_address_id = $user_address->id;
                }
                else {
                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message_error', 'No Pickup location'
                            . ' set as default! Please set'
                            . ' default address information!');
                    return redirect(url()->previous());
                }
            }
            Session::put('user_address_id', $user_address_id);
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id'));
        }
        else if($delivery_type == 'home_office_delivery'){
            
            if($user_address_id == "0" || $user_address_id == ""){
            
                $user_address = User_address::where('user_id', $userId)
                        ->where('default', 1)->first();
                
                if($user_address != null){
                    
                    $user_address_id = $user_address->id;
                }
                else {
                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message_error', 'No Address Information'
                            . ' Found or None is set as Default! Please set'
                            . ' default address information!');
                    return redirect(url()->previous());
                }
            }
            Session::put('user_address_id', $user_address_id);
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id'));
        }
    }
    

    public function payment_method(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->userId;
        }
        
        $user_address_id = Session::get('user_address_id'); 
        $transaction_cost = 0;
        
        $payment_option = $request->payment_option;
        $order_value = Utilities::getCustomerTotalCartPrice();
        
        if(Session::get('delivery_type') =='home_office_delivery')
        {
          $zone_id = Area::find(User_address::find($user_address_id)
                        ->area_id)->zone_id; 
         }else if( Session::get('delivery_type') =='pickup')
         {
            $zone_id = Area::find(User_pickup_location::find($user_address_id)
                        ->warehouse->area_id)->zone_id; 
         }
        
        $shipping_cost = Shipping_cost::where('zone_id', $zone_id)->first()->amount;
        
        if($payment_option == "PAYPAL"){
                     
            $transaction_cost = round(0.03*($order_value+$shipping_cost));
        } 
        
        Session::put('payment_option', $payment_option);
        Session::put('order_value', $order_value);
        Session::put('shipping_cost', $shipping_cost);
        Session::put('transaction_cost', $transaction_cost);
        
        return view('modules/customer/checkout/order_review',
                compact('userId', 'user_address_id', 'payment_option',
                        'order_value', 'shipping_cost', 'transaction_cost'));       
    }
    
    
    public function complete_transaction(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->userId;
        }
        $payment_option = $request->payment_option;
        $user_address_id = $request->user_address_id;    
        
        $gateway = Payment_gateway::where('name', $payment_option)->first()->id;
        $order_value = $request->order_value;
            
        $shipping_cost = $request->shipping_cost;
        
        if($payment_option == "CASH ON DELIVERY"){
            
            $order_id = Utilities::saveOrder($userId, $order_value,
                    $shipping_cost, 0, $user_address_id, $gateway, "UNPAID");
            
            return redirect('shop/transaction/success/' . $order_id);
            
        }else if($payment_option == "MPESA"){
            
            $order_id = Utilities::saveOrder($userId, $order_value,
                    $shipping_cost, 0, $user_address_id, $gateway, "UNPAID");
            
            $order = Order::findorfail($order_id);
            
            return view('modules/customer/checkout/mpesa_payment',
                compact('userId', 'gateway', 'order_value', 'shipping_cost',
                        'user_address_id', 'order'));
            
        }else if($payment_option == "PAYPAL"){
                    
            $transaction_cost = round(0.03*($order_value + $shipping_cost));
            $total_paypalcost = $order_value + $shipping_cost + $transaction_cost;
            
            $order_id = Utilities::saveOrder($userId, $order_value, $shipping_cost, 
                    $transaction_cost, $user_address_id, $gateway, "UNPAID");
            
            return view('modules/customer/checkout/paypal_payment', 
                compact('userId', 'gateway', 'order_value', 'shipping_cost',
                        'transaction_cost', 'user_address_id',
                        'total_paypalcost', 'order_id'));
            
        }    
    }
    
    public function getCities(Request $request){
        
        $country_id = $request->country;
        $cities = City::where('country_id', $country_id)->get();
        $html = '<option value="">Select City</option>';
        
        foreach($cities as $city){
            
            $html = $html.'<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        
        return response()->json(['status' => 200, 'html' => $html]);
    }
    
    public function getZones(Request $request){
        
        $city_id = $request->city;
        $zones = Zone::where('city_id', $city_id)->get();
        $html = '<option value="">Select Zone</option>';
        
        foreach($zones as $zone){
            
            $html = $html.'<option value="'.$zone->id.'">'.$zone->name.'</option>';
        }
        
        return response()->json(['status' => 200, 'html' => $html]);
    }
    
    public function getAreas(Request $request){
        
        $zone_id = $request->zone;
        $areas = Area::where('zone_id', $zone_id)->get();
        $html = '<option value="">Select Area</option>';
        
        foreach($areas as $area){
            
            $html = $html.'<option value="'.$area->id.'">'.$area->name.'</option>';
        }
        
        return response()->json(['status' => 200, 'html' => $html]);
    }
    
    
    public function getCustomerHistory(){
        
        $user = Auth::user();
        if($user != null){
            
            $user_id = $user->id;
        }else{
            
            Session::put('page', '/shop/history');
            return redirect(url('/shop/sign-in'));
        }
        
        $orders = Order::where('user_id', $user_id)->get();

        $total = count($orders);
        
        return view('modules/customer/history', compact('orders', 'total'));
    }
    
    
    public function getCustomerWishlist(){
        
        $user = Auth::user();
        if($user != null){
            
            $user_id = $user->id;
        }else{
            
            Session::put('page', '/shop/wishlist');
            return redirect(url('/shop/sign-in'));
        }
        
        $wishlists = Customer_wishlist::where('user_id', $user_id)->get();

        $total = count($wishlists);
        
        return view('modules/customer/wishlist', compact('wishlists', 'total'));
    }
    
    
    public function searchByCategoryId($category_id){
        
        $products_query = Product::where('category_id', $category_id);
        $products_ids_query = clone $products_query;
        
        $products = $products_query->get();
        $brands = Brand::where('category_id', $category_id)->get();
        $product_ids = $products_ids_query->get(['id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)
                ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price'));
    }
    
    public function search(Request $request){
        
        $pattern = $request->pattern;     
        Session::put('search_pattern', $pattern);
        
        $products_query = Product::leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                        ->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
        
        $brands_query = clone $products_query;
        
        $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();  
        
        $products = $products_query->select('products.*')->get();
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern'));
    }
    
    
    public function searchDefault(){    
        
        $pattern = Session::get('search_pattern');
        $products_query = Product::leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                        ->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
        
        $brands_query = clone $products_query;
        
        $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();  
        
        $products = $products_query->select('products.*')->get();
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern'));
    }
    
    
    public function searchLowestPriceFirst(){    
        
        $pattern = Session::get('search_pattern');
        
        $products_query = Product::join('product_prices', 
                'products.id', '=', 'product_prices.product_id')->leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                        ->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
        
        $brands_query = clone $products_query;
        
        $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();  
        
        $products = $products_query->select('products.*', 'product_prices.*')
                ->orderBy('product_prices.offer_price')->get();
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern'));
    }
    
    
    public function searchHighestPriceFirst(){    
        
        $pattern = Session::get('search_pattern');
        $products_query = Product::join('product_prices', 
                'products.id', '=', 'product_prices.product_id')->leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                        ->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
        
        $brands_query = clone $products_query;
        
        $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();  
        
        $products = $products_query->select('products.*', 'product_prices.*')
                ->orderBy('product_prices.offer_price', 'DESC')->get();
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern'));
    }
    
    
    public function searchOrderByName(){    
        
        $pattern = Session::get('search_pattern');
        $products_query = Product::join('product_prices', 
                'products.id', '=', 'product_prices.product_id')->leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                        ->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
        
        $brands_query = clone $products_query;
        
        $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();  
        
        $products = $products_query->select('products.*', 'product_prices.*')
                ->orderBy('products.name')->get();
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern'));
    }


    public function add_to_wishlist($product_id, $product_price_id, Request $request){
        
        $user = Auth::user();
        Session::put('wishlist_product_ref', $product_id);
        Session::put('wishlist_product_price_id', $product_price_id);
        
        if($user != null){
            
            $user_id = $user->id;
            $product_id = Session::get('wishlist_product_ref');
            $product_price_id = Session::get('wishlist_product_price_id');
        }else{
            
            Session::put('page', '/shop/add_to_wishlist/'.$product_id.'/'.$product_price_id);
            return redirect(url('/shop/sign-in'));
        }
        
        $customerWishlist = new Customer_wishlist();
        
        $customerWishlist->ip_address = $request->ip();     
        $customerWishlist->product_price_id = $product_price_id;
        $customerWishlist->product_id = $product_id;
        $customerWishlist->user_id = $user_id;
        
        $customerWishlist->save();
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Item added to your wishlist successfully!');

        return redirect()->intended('/shop/wishlist');
    }
    
    
    public function subscribe_to_newsletter(Request $request){
        
        $this->validate($request,['email' => 'required|email']);
        $email = $request->email;
        
        $checkExists = Newsletter_subscription::where('email', $email)->first();
        
        if($checkExists != null){
            
            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'You are already subscribed to '
                    . 'our Newsletter. Thank you!');

            return redirect()->intended(url()->previous());
        }
        $newsletterSubscription = new Newsletter_subscription();
        $user = Auth::user();
        
        if($user != null){
            
            $user_id = $user->id;
            $newsletterSubscription->user_id = $user_id;
        }        
        $newsletterSubscription->email = $email;       
        
        $newsletterSubscription->save();
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'You have successfully subscribed to our Newsletter!');

        return redirect()->intended(url()->previous());
    }
    
    public function submit_review(Request $request){
        
        $quality = $request->quality;
        $price = $request->price;
        $value = $request->value;
        $name = $request->name;
        $summary = $request->summary;
        $review = $request->review;
        $product_id = $request->product_id;
        
        $published = 0;
        
        $this->validate($request,['name' => 'required', 
            'summary' => 'required']);
        
        $rating = round(($quality + $price + $value)/3);
        
        $productReview = new Product_review();
        
        $productReview->product_id = $product_id;
        $productReview->price = $price;
        $productReview->quality = $quality;
        $productReview->rating = $rating;
        $productReview->value = $value;
        $productReview->name = $name;
        $productReview->summary = $summary;
        $productReview->comment = $review;
        $productReview->published = $published;
        
        $productReview->save();
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Your review has been successfully '
                . 'submitted. Thank you!');

        return redirect()->intended(url()->previous());
    }
    
    public function setDeliveryType(Request $request){
        
        $delivery_type = $request->delivery_type;
        $userId = Session::get('userId');
        
        if($delivery_type == 1){
            
            Session::put('delivery_type', 'pickup');
            $user_address = User_pickup_location::where('user_id',
                        $userId)->where('default', 1)->first();
            
            if($user_address != null) {
                Session::put('user_address_id', $user_address->id);
            }
            
        }else if($delivery_type == 2){
            
            Session::put('delivery_type', 'home_office_delivery');
            
            $user_address = User_address::where('user_id',$userId)
                    ->where('default', 1)->first();
            
            if($user_address != null) {
                Session::put('user_address_id', $user_address->id);
            }
        }
    }
      
}