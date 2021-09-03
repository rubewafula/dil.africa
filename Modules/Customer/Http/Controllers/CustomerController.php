<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Auth;
use Session;
use App\Role_user;

use PDF;

use App\Campaign_product;

use Modules\Customer\Entities\Product;
use Modules\Customer\Entities\History_visit;
use Modules\Customer\Entities\Cart_session;
use Modules\Customer\Entities\Product_price;
use Modules\Customer\Entities\Product_price_old;
use Modules\Customer\Entities\Seller;
use Modules\Customer\Entities\Product_image;
use Modules\Customer\Entities\User;
use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\Payment_gateway;
use Modules\Customer\Entities\Shipping_cost;
use Modules\Customer\Entities\Shipping_price;
use Modules\Customer\Entities\Area;
use Modules\Customer\Entities\Order;
use Modules\Customer\Entities\Order_payment;
use Modules\Customer\Entities\Seller_order;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Zone;
use Modules\Customer\Entities\Customer_wishlist;
use Modules\Customer\Entities\Brand;
use Modules\Customer\Entities\Newsletter_subscription;
use Modules\Customer\Entities\Product_review;
use Modules\Customer\Entities\Voucher;
use Modules\Customer\Entities\Category;
use Modules\Customer\Entities\Country;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Searched_item;
use Modules\Customer\Entities\MPESATransactionLog;
use Modules\Customer\Entities\IPayTransactionLog;
use Modules\Customer\Entities\Outbox;
use Modules\Customer\Entities\Flash_sale;

use Modules\Customer\Notifications\UserConfirmation;
use Modules\Customer\Notifications\AgentConfirmation;

use Modules\Customer\Utilities\Utilities;
use Modules\Customer\Utilities\CartItem;
use Modules\Customer\Utilities\MiniCartItem;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Cache;

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

    
    public function product_detail(Request $request, $slug)
    {
        $ip_address = $request->ip();
        
        $user_id = null;
        $product = Product::where('slug', $slug)->first();

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

        $title = "DIL.AFRICA - ".$product->name;

        return view('modules/customer/product/index', compact('related_products',
                'product', 'title'));
    }


    public function product_price_detail(Request $request, $slug, $price_id)
    {
        $ip_address = $request->ip();
        
        $user_id = null;

        $product = Product::where('slug', $slug)->first();

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
                    ->where('product_id', $product->id)->orderBy('id', 'DESC')
                    ->limit(10)->get();
            
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

        $title = "DIL.AFRICA - ".$product->name;

        return view('modules/customer/product/index_detail', compact('related_products',
                'product', 'product_price', 'prices', 'title'));
    }


    public function load_product_price(Request $request)
    {

        $product_price_id = $request->product_price_id;

        $price = Product_price::find($product_price_id);

        $images = Product_image::where("product_price_id", $product_price_id)->get();

        $hasImages =  0;
        $sliderHtml = '';
        $imagesHtml = '';
        $thumbnailsHtml = "";
        $priceHtml = "";
        $count = 0;
        $stock =  "";
        $formHtml = "";

        if(count($images) > 1){

            $hasImages = 1;

            $imagesHtml = '<div class="product-item-holder size-big single-product-gallery small-gallery">
                <div id="owl-single-product">';

                    foreach($images as $image) {  

                      $imagesHtml = $imagesHtml.'<div class="single-product-gallery-item" id="slide'.$count.'">
                        <a data-lightbox="image-1" data-title="Gallery" href="'.url("assets/images/products/".$image->image_url).'">
                            <img class="img-responsive" alt="" src="'.url("assets/images/blank.gif").'" data-echo="'.url('assets/images/products/'.$image->image_url).'" />
                        </a></div>';

                        $count++;
                    }

                $imagesHtml = $imagesHtml.'</div>';
                $imagesHtml = $imagesHtml.'<div class="single-product-gallery-thumbs gallery-thumbs">';

                $count = 0;
                $imagesHtml = $imagesHtml.'<div id="owl-single-product-thumbnails">';

                foreach($images as $image){

                    $imagesHtml = $imagesHtml.'<div class="item">
                        <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="'.$count.'" href="#slide'.$count.'">
                            <img class="img-responsive" width="85" alt="" src="'.url('assets/images/blank.gif').'" data-echo="'.url('assets/images/products/'.$image->image_url).'" />
                        </a></div>';

                    $count++;
                }

                $imagesHtml = $imagesHtml.'</div></div></div>';
 
        }

        if($price ->quantity > 0){
                $stock = '<span class="value">In Stock</span>';
        }else{
            $stock = '<span class="value">Out of Stock</span>';
        }

        $offer_price = $price->offer_price;
        $standard_price = $price->standard_price;

        if($offer_price != null && $offer_price != "" && $offer_price != 0){

            $priceHtml = '<div class="col-sm-6"><div class="price-box"><span class="price">
                            Ksh '.$offer_price.'   <span class="price-strike">
                                KSh '.$standard_price.'</span> 
                            <input type="hidden" value="'.$price->product->id.'" id="product_ref" />
                        </div>
                    </div><div class="col-sm-6">
                            <div class="favorite-button m-t-10">
                                <a class="btn btn-primary" href="'.url("shop/add_to_wishlist/".$price->product->id."/".$price->id).'" title="Add to Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </div>
                        </div>';

        }else {

            $priceHtml = '<div class="col-sm-6"><div class="price-box">
                            <span class="price">
                            Ksh '. $standard_price .'</span>
                            <input type="hidden" value="'.$price->product->id.'" id="product_ref" />
                        </div>
                    </div><div class="col-sm-6">
                            <div class="favorite-button m-t-10">
                                <a class="btn btn-primary" href="'.url("shop/add_to_wishlist/".$price->product->id."/".$price->id).'" title="Add to Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </div>
                        </div>';
        }

        $formHtml = '<form method="POST" action="'.url("shop/add_to_cart").'">
                        <div class="quantity-container info-container"><div class="row">
                                <div class="col-sm-2"><span class="label">Qty :</span>
                                </div><div class="col-sm-2"><div class="cart-quantity">
                                        <div class="quant-input"><div class="arrows">
                                                <div class="arrow plus gradient"><span class="ir">
                                                <i class="icon fa fa-sort-asc"></i></span></div>
                                                <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                            </div><input type="text" name="quantity" value="1">
                                        </div></div></div><div class="col-sm-7"><input type="hidden" value="'.$price->id.'" name="product_ref" /><button type="submit" class="btn btn-primary">
                                        <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                    </button></div></div><!-- /.row -->
                        </div><!-- /.quantity-container --></form>';

        return response()->json(['status' => 200, 'has_images' => $hasImages, 
            'slider' => $sliderHtml, 'thumbnails' => $thumbnailsHtml, 'images' => $imagesHtml,
            'stock' => $stock, 'price' => $priceHtml, 'cart_form' => $formHtml]);

    }
    
    
    public function add_to_cart(Request $request)
    {

        $quantity = $request->quantity;

        if($quantity == 0){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'Invalid quantity value zero specified. Please specify a valid value!');

            return redirect()->intended(url()->previous());
        }

        if(!is_numeric($quantity)){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'Invalid quantity value. Please check!');

            return redirect()->intended(url()->previous());
        }
        $product_id = $request->product_ref;

        $checkStock = Product_price::find($product_id);

        if($checkStock->quantity < $quantity){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'This item is out of stock for the selected seller. You may choose the same product from a different seller. Thank you!');

            return redirect()->intended(url()->previous());
        }

        if($checkStock->quantity < $quantity){

            Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message_error', 'There are only '.$checkStock->quantity.' pieces left for this product by the selected seller! You may choose the same product from a different seller. Thank you!');

            return redirect()->intended(url()->previous());
        }
        
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

                    $quant = $miniCartItem->getQuantity();

                    if(!is_numeric($quant)){
                        $quant  = 0;

                    }
                    $miniCartItem->setQuantity($quant+1);
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
            Session::put('cart', $items);        
        }
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Item added to your cart successfully!');

        return redirect()->intended(url('/shop/cart'));
    }


    public function updateCart(Request $request)
    {

        $invalid_value = false;

        $data = $request->data;
               
        $cart = Session::get('cart'); 

        $items = explode(",", $data); 
        
        foreach ($items as $item) {
            
            $splitted = explode(":", $item);
            $product_id = $splitted[0];
            $quantity = $splitted[1];

            if($quantity == 0){

                $invalid_value = true;
                continue;
            }

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

        if($invalid_value){

             Session::flash('alert-class', 'alert-danger'); 
            Session::flash('flash_message', 'An invalid value zero was detected and was ignored! The rest of the items were updated.');
        }else {
        
            Session::flash('alert-class', 'alert-success'); 
            Session::flash('flash_message', 'Your cart has been updated successfully!');

            return response()->json(['status' => 200]);
        }
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

        $applicable_amount = $voucher_details->applicable_amount;

        if($applicable_amount != null){

            $order_total = Utilities::getOrderTotalPrice();

            if($order_total < $applicable_amount){

                Session::flash('alert-class', 'alert-danger'); 
                Session::flash('flash_message_error', 'This voucher only applies for orders with a minimum order amount of '.$applicable_amount.'. Please continue shopping and match the amount to enjoy this discount. Thank you.');

                return redirect('/shop/cart');
            }
        }

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

            if($voucher_details->voucher_type != null){

                $voucher_type = $voucher_details->voucher_type;
                

                if($voucher_type == 'AMOUNT'){

                    Session::put('voucher_type', $voucher_type);
                    Session::put('voucher_code', $voucher_details->voucher_code);
                    Session::put('voucher_amount', $voucher_details->amount);
                    Session::flash('alert-class', 'alert-success'); 
                    Session::flash('flash_message', "Congratulations. The voucher was applied successfully.");

                    return redirect('/shop/cart');
                }else if($voucher_type == 'PERCENT_DISCOUNT'){

                    Session::put('voucher_type', $voucher_type);
                    Session::put('voucher_code', $voucher_details->voucher_code);
                    $percent = $voucher_details->percent_discount;
                    Session::put('voucher_percent', $percent);
                    
                    Session::flash('alert-class', 'alert-success'); 
                    Session::flash('flash_message', "Congratulations. The voucher was applied successfully.");

                    return redirect('/shop/cart');
                }else if($voucher_type == 'FREE_SHIPPING'){

                    Session::put('voucher_type', $voucher_type);
                    Session::put('voucher_code', $voucher_details->voucher_code);
                    Session::put('voucher_shipping', 'true');
                    Session::flash('alert-class', 'alert-success'); 
                    Session::flash('flash_message', "Congratulations. The voucher was applied successfully.");

                    return redirect('/shop/cart');
                }else {

                    Session::flash('alert-class', 'alert-danger'); 
                    Session::flash('flash_message_error', "Specified voucher is of an unknown type and can not be applied.");

                    return redirect('/shop/cart');  
                }
            }

        }

    }

    
    public function sign_in(){
        
        return view('modules/customer/sign_in');
    }

    public function sign_up(){
        
        return view('modules/customer/sign_up');
    }

    public function agent_sign_up(){
        
        return view('modules/customer/agent_signup');
    }

    public function profile() {

        $user = Auth::user();

        if($user == null){

            return redirect(url()->previous());
        }

        $addresses = User_address::where('user_id', $user->id)->get();
        
        return view('modules/customer/profile', compact('user', 'addresses'));
    }

    public function change_password() {

        $user = Auth::user();

        if($user == null){

            return redirect(url()->previous());
        }
        
        return view('modules/customer/change_password');
    }


    public function saveNewPassword(Request $request) {

        $this->validate($request, ['current_password' => 'required',
            'new_password' => 'required', 'confirm_password' => 'required']);

        $user = Auth::user();

        if($user == null){

            return redirect(url()->previous());
        }

        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $conf_password = $request->confirm_password;

        if($new_password != $conf_password){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Passwords do not match! Please verify and then try again.');
            return redirect(url()->previous());
        }

        if ($user && Hash::check($current_password, $user->password)) {

            $user->password = bcrypt($new_password);
            $user->save();

            Session::flash('alert-class', 'alert-success');
            Session::flash('flash_message', 'Password changed successfully.');
            return redirect(url()->previous());

        }else{

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Wrong current password specified! Please verify and then try again.');
            return redirect(url()->previous());
        }
        
        return redirect(url()->previous());
    }

    

    public function profile_edit($id) {

        $user = Auth::user();

        if($user == null){

            return redirect(url()->previous());
        }

        $addresses = User_address::where('user_id', $user->id)->get();
        
        return view('modules/customer/profile_edit', compact('user', 'addresses'));
    }

    public function update_profile(Request $request) {

        $user = Auth::user();
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;

        if($user == null){

            return redirect(url()->previous());
        }

        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->phone = $phone;

        $user->save();

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Your profile information has been updated successfully. Thank you!');
        
         return redirect(url()->previous());
    }
    
    
    public function checkout(){

        $user = Auth::user();

        if($user != null) { $userId = $user->id; }
        else{ $userId = Session::get('userId'); }
        
        if($user == null){
            return view('modules/customer/checkout/checkout');
        }else{
            
            $cart = Session::get('cart');
            Session::put('userId', $user->id);
            
            if($cart != null){

                if($user->is_agent == 1){

                    return redirect(url('/shop/checkout/agent/delivery'));
                }
                
                return redirect(url('/shop/checkout/delivery'));
            }else {

                Session::flash('alert-class', 'alert-danger');
                Session::flash('flash_message', 'You have no items in the cart. Please shop first before checking out.');
                return redirect(url()->previous());
            }
        }
    }
    
    public function delivery(){
          
        $user = Auth::user();

        if($user != null) { $userId = $user->id; }
        else{ $userId = Session::get('userId'); }
        
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
                compact('userId', 'user', 'user_address', 'addresses', 'stations'));
    }


    public function deliveryAgent(){
          
        $user = Auth::user();

        if($user != null) { $userId = $user->id; }
        else{ $userId = Session::get('userId'); }
        
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
        
        return view('modules/customer/checkout/agent_delivery_information',
                compact('userId', 'user', 'user_address', 'addresses', 'stations'));
    }
    
    
    public function my_account(){
          
        $user = Auth::user();       
        
        if($user == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Please login to continue!');
            
            return redirect('shop/sign-in');
        }
        
        $userId = $user->id;
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/profile', compact('user', 'addresses'));
    }
    
    public function delivery_update($id){
        
        $user_address = User_address::findorfail($id);
        $userId = $user_address->user_id;
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/checkout/delivery_information',
                compact('user_address', 'userId', 'addresses'));
    }

    public function address_edit($id){
        
        $user_address = User_address::findorfail($id);
        $userId = $user_address->user_id;
        
        $addresses = User_address::where('user_id', $userId)
                ->orderBy('id', 'DESC')->get();
        
        return view('modules/customer/address_details',
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

        $user_address = User_address::find($user_address_id); 

        return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id', 'user_address'));
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

        $order_value = Utilities::getCustomerTotalCartPrice();
        $delivery_type  = Session::get('delivery_type');

        Session::put('order_value', $order_value);
        
        if($delivery_type == 'home_office_delivery')
        {

            $city = Session::get('city_id');

         }else if($delivery_type == 'pickup'){

            $city = Session::get('city_id');

         }

         $products_value = Utilities::getCustomerTotalCartPriceNoShipping();

        //  if($products_value < 20000)
        //  {
        //     $shipping_cost = Utilities::getShippingCost($city);
        //     $dil_shipping = $shipping_cost;
        //  }
        // else{

        //     $shipping_cost = 0;
        //     $hiddshipping_cost = Utilities::getHiddenShippingCost();
        //     $dil_shipping = $hiddshipping_cost;
        // }

        $shipping_cost = Utilities::getShippingCost($city);
        $hiddshipping_cost = Utilities::getHiddenShippingCost();
        $dil_shipping = $hiddshipping_cost;

        $payment_option = Session::get('payment_option');
        $transaction_cost = 0;

        if($payment_option == "PAYPAL"){
                     
            $transaction_cost = round(0.035*($order_value+$shipping_cost));
        } 

        Session::put('payment_option', $payment_option);
        Session::put('shipping_cost', $shipping_cost);
        Session::put('dil_shipping', $dil_shipping);
        Session::put('transaction_cost', $transaction_cost);

        if($payment_option == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please specify the payment option'
                    . ' first to continue!');
            
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id', 'order_value',
                     'delivery_type', 'products_value','shipping_cost', 
                     'dil_shipping'));
        }

        return view('modules/customer/checkout/order_review',
         compact('payment_option','userId', 'user_address_id', 'order_value',
                     'delivery_type', 'products_value','shipping_cost', 
                     'dil_shipping','transaction_cost'));
    }
        
    public function contact_us(){
        
        return view('modules/customer/contact_us');
    }
    
    public function load_register(){
        
        return redirect(url('/shop/sign-up'));
    }

    public function load_register_agent(){
        
        return redirect(url('/shop/agent/sign-up'));
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
        
        $cart = Session::get('cart');
        
        $cart_items = [];
        $total = 0;
        $tax = 0;
        
        if($cart != null) {
            
            if(count($cart) > 0) {

                foreach($cart as $session){

                    $quantity = $session->getQuantity();

                    if(!is_numeric($quantity)){

                        Session::flash('alert-class', 'alert-danger');
                        Session::flash('flash_message_error', 'Invalid value for quantity encountered');

                        return redirect('/shop/cart');
                    }

                    $product_price_id = $session->getProductPriceId();
                    $productPrice = Product_price::find($product_price_id);

                    if($productPrice == null){

                        continue;
                    }

                    $product_id = $productPrice->product_id;
                    $product = Product::find($product_id);   

                    if($product->getFlashPrice() != null){

                        $price = $product->getFlashPrice()->offer_price;
                    }
                    else{

                        $price = $productPrice->offer_price;
                    }

                    if($price == null){

                        $price = $productPrice->standard_price;
                    }

                    if($product == null){

                        continue;
                    }

                    $shipping_cost = $product->getShippingCost();

                    $sold_by = Seller::find($product->seller_id);

                    if($sold_by != null) {           
                        $seller = $sold_by->name;
                    }else{

                        $seller = "Not Specified";
                    }

                    $images = Product_image::where('product_id', $product_id)
                            ->where('default', 1)->limit(1)->get();

                    if(count($images) > 0){

                        $product_image = $images->first()->image_url;
                    }else {

                        $images = Product_image::where('product_id', $product_id)
                            ->limit(1)->get();
                        $product_image = $images->first()->image_url;
                    }

                    $price = $price + $shipping_cost;

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

                $image_fetched = Product_image::where('product_id', $product_id)
                        ->where('default', 1)->limit(1)->first();

                if($image_fetched != null){ $product_image = $image_fetched->image_url; }
                
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

    public function about_us(){
        
        return view('modules/customer/about_us');
    }

    public function return_policy(){
        
        return view('modules/customer/return_refunds');
    }

    public function become_seller(){
        
        return view('modules/customer/become_seller');
    }

    public function become_agent(){
        
        return view('modules/customer/sales_agent');
    }

    public function logistics_partner(){
        
        return view('modules/customer/logistics_partner');
    }

    public function shipping(){

        $shipping_costs = Shipping_price::where('city_id', 1)->groupBy('category_id')->get();

        return view('modules/customer/shipping_policy', compact('shipping_costs'));
    }

    public function faq(){
        
        return view('modules/customer/faq');
    }

    public function track_order(){
        
        return view('modules/customer/track_order');
    }

    public function getOrderTrackDetails(Request $request){

        $order_reference = $request->order_reference;

        $order = Order::where('order_reference', $order_reference)->first();

        if($order == null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'No order with the specified 
                reference number. Please confirm your reference number again.');
            return redirect(url()->previous());
        }

        $delivery_mode = "";
        $address = "";

        if($order->shipping_type_id == 2)
        {
            $delivery_mode = "Home / Office Delivery";
            $user_address = User_address::where('user_id', $order->user_id)
                        ->where('default', 1)->first();
            $city = City::find($user_address->city_id)->name;
            $country = Country::find($user_address->country_id)->name;
            $address = $user_address->building.", ".$user_address->floor.', 
            '.$user_address->street.', '.$city.', '.$country;

        }elseif($order->shipping_type_id == 1){

             $delivery_mode = "Pickup from our Station";
             $user_address = User_pickup_location::where('user_id',
                        $order->user_id)->where('default', 1)->first();
             $warehouse = Warehouse::find($user_address->warehouse_id);
             $address = $warehouse->name.', '.Area::find($warehouse->area_id)->name; 
        }

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'This is a valid order. Please scroll down 
            to see the order status information. Thank you!');
        return view('modules/customer/track_order', compact('order', 'delivery_mode', 'address'));
    }


    public function privacy_policy(){
        
        return view('modules/customer/privacy_policy');
    }

    public function register_guest(Request $request){
        
        $this->validate($request, ['email' => 'required', 'phone' => 'required',
            'first_name' => 'required', 'last_name' => 'required']);

        $email = $request->email;
        $phone = $request->phone;
        $userId = 0;
        
        if(!Utilities::userExists($email)){
            
            $first_name = $request->first_name;
            $last_name = $request->last_name;      
            $password = bcrypt($first_name);
            $active = 0;

            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = $password;
            $user->active = $active;
            $user->email = $email;
            $user->phone = $phone;

            $user->save();
            $userId = $user->id;

            Auth::user($user);

        }else {
            
            $user = User::where('email', $email)->first();
            $userId = $user->id;
            $user_address = User_address::where('user_id', $userId)
                    ->where('default', 1)->orderBy('id', 'DESC')->first();

            Auth::user($user);
        }
        
        Session::put('userId', $userId);
        
        return view('modules/customer/checkout/delivery_information',
                compact('userId', 'user_address', 'user'));
    }
    
    public function registerCustomer(Request $request){
        
        $this->validate($request, ['email' => 'required', 'phone' => 'required',
            'first_name' => 'required', 'last_name' => 'required']); 
        
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
            $user->phone = $phone;
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

    public function registerAgent(Request $request){
        
        $this->validate($request, ['email' => 'required', 'phone' => 'required',
            'first_name' => 'required', 'last_name' => 'required']); 
        
        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $country = $request->country;
        $city = $request->city;
        $phone = $request->phone;
        $password = $request->password;
        $conf_password = $request->conf_password;
        
        if($password != $conf_password){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Passwords do not match. '
                    . 'Please correct!');
            
            return redirect(url()->previous());
        }
        
        $token = bin2hex(random_bytes(10)).rand(10000000,500000000).bin2hex(random_bytes(10));
        
        if(!Utilities::userExists($email)){
            
            $first_name = $first_name;
            $last_name = $last_name;                 
            
            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = bcrypt($password);
            $user->active = 1;
            $user->email = $email;
            $user->phone = $phone;
            $user->confirmation_token = $token;
            $user->is_agent = 1;

            $user->save();

            $roleUser = new Role_user();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = 20;
            $roleUser->save();
            
            $user->notify(new AgentConfirmation($user));
            
        }else {
            
            $user = User::where('email', $email)->first();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = bcrypt($password);
            $user->phone = $phone;
            $user->confirmation_token = $token;

            $user->save();
            
            
            $user->notify(new AgentConfirmation($user));
                      
        }
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'You have registered successfully as a 
            DIL.Africa Sales Agent! You are now eligible to earn commissions for any orders that you place 
            on behalf of customers. Thank you!');
        
        return redirect(url()->previous());
    }
    
    
    public function confirm_account($confirmation){
        
        if(User::where('confirmation_token',$confirmation)->exists())
        {
             User::where('confirmation_token',$confirmation)->update([

                 'active'=>1,
                 'confirmation_token'=> NULL
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

    public function agent_confirm_account($confirmation){
        
        if(User::where('confirmation_token',$confirmation)->exists())
        {
             User::where('confirmation_token',$confirmation)->update([

                 'active'=>1,
                 'confirmation_token'=> NULL
             ]);

             Session::flash('flash_message','Your account has been successfully'
                     . ' verified. Thank you for registering as a DIL.Africa Sales Agent (DASA)');
            return  redirect()->intended(url()->previous());
        } else{
            // wrong  code

            Session::flash('flash_message','The confirmation link used is invalid');
            return  redirect()->intended(url()->previous());

        }
    }


    public function confirm_order($confirmation){
        
        if(Order::where('confirmation_token',$confirmation)->exists())
        {

             Order::where('confirmation_token',$confirmation)->update([

                 'order_status'=>"VALIDATED",
                 'confirmation_token'=>NULL
             ]);

             Session::flash('flash_message','Your order has been successfully'
                     . ' confirmed. Thank you for choosing DIL.Africa');

            return  redirect('/shop/cart');
        } else{
            // wrong  code

            Session::flash('flash_message','The confirmation link used is invalid');
            return  redirect('/shop/cart');

        }
    }


    public function home(Request $request){

        $user = Auth::user();

        Session::put("userId", $user->id);

        if($user == null){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'You must be logged in to access this page! Please Login!');
            return redirect('/shop');
        }

        $page = Session::get('page');

        if($page != null){
                
            return redirect($page);
        }else{

            $cart = Session::get('cart');

            if($cart != null) {

                return redirect('/shop/checkout/delivery'); 
            }else {

                return redirect('/shop/history'); 
            }
           
        }

    }


    public function login(Request $request){

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        
        if ($user && Hash::check($password, $user->password)){
            
            Auth::login($user);
            Session::put('userId', $user->id);

            $referrer = url()->previous();
            $suburl = substr($referrer, strrpos($referrer, '.africa/')+1, strrpos($referrer, '/'));

            if(substr($suburl, 0, 16) == "africa/logistics"){

                $seller_orders = Seller_order::limit(5)->orderBy('id', 'DESC')->get();
                $orders = Order::limit(4)->orderBy('id', 'DESC')->get();

                return view('logistics::index', compact('seller_orders', 'orders'));

            }elseif(substr($suburl, 0, 13) == "africa/seller"){

                if($user->is_seller == 1)
                {  
                    
                    return redirect()->intended('seller');
                }else{

                    Auth::logout();
                    Session::flash('alert-class','alert-danger');
                    Session::flash('flash_message','Wrong username or password. Please verify. Please also ensure that you have confirmed your account from the email.');
                    return redirect('seller/login');
                }
            }elseif(substr($suburl, 0, 15) == "africa/backend"){

                $role = Role_user::where('user_id', $user->id)->first();
                if($role->role_id == 5)
                {  
                    return redirect()->intended('backend');
                }else{

                    Auth::logout();
                    Session::flash('alert-class','alert-danger');
                    Session::flash('flash_message','Wrong username or password. Please verify');
                    return redirect('backend');
                }
            }
            elseif(substr($suburl, 0, 9) == "africa/qc") {

                $role = Role_user::where('user_id', $user->id)->first();
                if($role->role_id == 16)
                {  
                    return redirect()->intended('qc');
                }else{

                    Auth::logout();
                    Session::flash('alert-class','alert-danger');
                    Session::flash('flash_message','Wrong username or password. Please verify');
                    return redirect('backend');
                }
            }
            
            elseif(substr($suburl, 0, 15) == "africa/accounts") {

                $role = Role_user::where('user_id', $user->id)->first();
                if($role->role_id == 19)
                {  
                    return redirect()->intended('accounts');
                }else{

                    Auth::logout();
                    Session::flash('alert-class','alert-danger');
                    Session::flash('flash_message','Wrong username or password. Please verify');
                    return redirect('backend');
                }
            }
            
            $page = Session::get('page');
            
            Session::flash('alert-class', 'alert-success');
            Session::flash('flash_message', 'Welcome to DIL.AFRICA '.$user->first_name);
            
            if($page != null){
                
                Session::forget('page');
                return redirect($page);
            }else{

                $cart = Session::get('cart');

                if($cart != null) {

                    if($user->is_agent == 1){

                        return redirect('/shop/checkout/agent/delivery'); 
                    }
                    return redirect('/shop/checkout/delivery'); 
                }else {

                    return redirect('/shop/my-account'); 
                }
               
            }
            
        }else {
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'Wrong email or password! Please try again!');
            return redirect(url()->previous());
        }
    }


    public function saveAddress(Request $request) {
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
            Log::info( "Got a logged in user with id ".$userId);
        } else {
            $userId = $request->user_id;

            Log::info( "The user was not logged in but got an id from request with id ".$userId);
        }
        
        $this->validate($request,['telephone' => 'required',
            'city_id' => 'required']);
        
        $address_id = $request->user_address_id;
        $telephone = $request->telephone;
        $area = $request->google_area;
        $country = 1;
        $city = $request->city_id;
        $delivery_address = $request->delivery_address;
        
        if(strlen($address_id) == 0){

            $user_address = User_address::where('delivery_address', $delivery_address)
                ->where('google_area', $area)->first();

            if($user_address == null){

                $user_address = new User_address();
                Log::info( "No user address and we are creating one here for user ".$userId);
            }

        }else {
            
            $user_address = User_address::findorfail($address_id);

            Log::info( "Got an existing address for the user ".$userId);
        }
        $user_address->user_id = $userId;
        $user_address->telephone = $telephone;
        $user_address->google_area = $area;
        $user_address->country_id = $country;
        $user_address->city_id = $city;
        $user_address->delivery_address = $delivery_address;
        
        $user_address->save();

        Log::info( "Successfully saved the address for the user ".$userId);
        
        $user_address_id = $user_address->id;

        $user = User::find($userId);

         Log::info( "Tried finding the user from the users relation with ID ".$userId);

        if($user != null) {
            
             Log::info("Found the user successfully  from the users table with ID ".$userId);
            if($user->phone == null){

                $user->phone = $telephone;
                $user->save();
            }
        }else{

             Log::info( "Could not find the user again after doing all that shit in the address ".$userId);
        }

        Session::forget('delivery_type');
        Session::put('delivery_type', 'home_office_delivery');
        Session::put('user_address_id', $user_address_id);
        Session::put('city_id', $city);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Address details saved successfully!');
        
        $cart = Session::get('cart');
        if($cart != null){
            
             Log::info( "Found some ordered stuff in the session and will redirect to payments for user id ".$userId);

            if(count($cart) > 0){

                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id', 'user_address'));
            }
        }
         Log::info( "Did not get any shiet in the cart for user with id ".$userId);
            
        return redirect(url()->previous());
    }


    public function saveAddressAgent(Request $request) {
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
            Log::info( "Got a logged in user with id ".$userId);
        } else {
            $userId = $request->user_id;

            Log::info( "The user was not logged in but got an id from request with id ".$userId);
        }
        
        $this->validate($request,['telephone' => 'required',
            'city_id' => 'required']);
        
        $customer_email = $request->customer_email;
        $address_id = $request->user_address_id;
        $telephone = $request->telephone;
        $area = $request->google_area;
        $country = 1;
        $city = $request->city_id;
        $delivery_address = $request->delivery_address;
        
        if(strlen($address_id) == 0){

            $user_address = User_address::where('delivery_address', $delivery_address)
                ->where('google_area', $area)->first();

            if($user_address == null){

                $user_address = new User_address();
                Log::info( "No user address and we are creating one here for user ".$userId);
            }

        }else {
            
            $user_address = User_address::findorfail($address_id);

            Log::info( "Got an existing address for the user ".$userId);
        }

        if($customer_email != null){

            if(strlen($customer_email) > 0){

                if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $customer_email)){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message', 'Invalid Email Address. Please enter a valid email address!');

                    return redirect(url()->previous());
                }

                $customerExists = User::where('email', $customer_email)->first();

                if($customerExists == null){

                    $first_name = $request->first_name;
                    $last_name = $request->last_name;      
                    $password = bcrypt($first_name);
                    $active = 0;

                    $user = new User();
                    $user->first_name = $first_name;
                    $user->last_name = $last_name;
                    $user->password = $password;
                    $user->active = $active;
                    $user->email = $customer_email;
                    $user->phone = $telephone;
                    $user->created_by_agent = $userId;

                    $user->save();

                    $user_address->user_id = $user->id;
                }else{

                    $user_address->user_id = $customerExists->id;
                }
            }
        }
        
        $user_address->telephone = $telephone;
        $user_address->google_area = $area;
        $user_address->country_id = $country;
        $user_address->city_id = $city;
        $user_address->delivery_address = $delivery_address;
        
        $user_address->save();

        Log::info( "Successfully saved the address for the user ".$userId);
        
        $user_address_id = $user_address->id;

        $user = User::find($userId);

         Log::info( "Tried finding the user from the users relation with ID ".$userId);

        if($user != null) {
            
             Log::info("Found the user successfully  from the users table with ID ".$userId);
            if($user->phone == null){

                $user->phone = $telephone;
                $user->save();
            }
        }else{

             Log::info( "Could not find the user again after doing all that shit in the address ".$userId);
        }
        
        Session::forget('delivery_type');
        Session::put('delivery_type', 'home_office_delivery');
        Session::put('user_address_id', $user_address_id);
        Session::put('city_id', $city);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Address details saved successfully!');
        
        $cart = Session::get('cart');
        if($cart != null){
            
             Log::info( "Found some ordered stuff in the session and will redirect to payments for user id ".$userId);

            if(count($cart) > 0){

                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id', 'user_address'));
            }
        }
         Log::info( "Did not get any shiet in the cart for user with id ".$userId);
            
        return redirect(url()->previous());
    }


    public function updateAddress(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->user_id;
        }
        
        $this->validate($request,['telephone' => 'required',
            'city_id' => 'required']);
        
        $address_id = $request->user_address_id;
        $telephone = $request->telephone;
        // $zone = $request->zone_id;
        $area = $request->google_area;
        // $building = $request->building;
        // $floor = $request->floor;
        // $street = $request->street;
        $country = 1;
        $city = $request->city_id;
        // $landmark = $request->landmark;
        $delivery_address = $request->delivery_address;
        // $preffered = $request->default;
        
        $user_address = User_address::findorfail($address_id);
        $user_address->user_id = $userId;
        $user_address->telephone = $telephone;
        // $user_address->zone_id = $zone;
        $user_address->google_area = $area;
        // $user_address->building = $building;
        // $user_address->floor = $floor;
        // $user_address->street = $street;
        $user_address->country_id = $country;
        $user_address->city_id = $city;
        // $user_address->landmark = $landmark;
        $user_address->delivery_address = $delivery_address;
        
        $user_address->save();
        
        $user_address_id = $user_address->id;

        $user = User::find($userId);

        if($user != null) {
            
            if($user->phone == null){

                $user->phone = $telephone;
                $user->save();
            }
        }
        
        Session::put('city_id', $city);
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Address details updated successfully!');
            
        return redirect(url('/shop/my-account'));
    }
    
    
    public function savePickupLocation(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
            Log::info( "Got a logged in user with id in the savePickupLocation method for id ".$userId);

        } else {

            $userId = $request->user_id;

            Log::info( "Did not find a logged in user in the pickup method but found one in the request with ID ".$userId);
        }
        
        $request->validate(['city' => 'required', 'pickup_location'=> 'required']);
        
        $pickuplocation_id = $request->user_pickuplocation_id;
        $city_id = $request->city;
        $pickup_station = $request->pickup_location;
        
        if(strlen($pickuplocation_id) == 0){

            $user_pickuplocation = new User_pickup_location();

            Log::info( "Creating a new pickup station for user id ".$userId);

        }else {
            
            $user_pickuplocation = User_pickup_location::findorfail($pickuplocation_id);

            Log::info( "Got an existing pickup station for the user ".$userId);
        }
        $user_pickuplocation->user_id = $userId;
        $user_pickuplocation->warehouse_id = $pickup_station;
        $user_pickuplocation->default = 1;

        $user_pickuplocation->save();

        Log::info( "Saved a pickup station for user with ID ".$userId);
        
        $user_address_id = $user_pickuplocation->id;

        Log::info( "Picked up the station with ID  ".$user_address_id);

        $user_address = User_pickup_location::find($user_address_id);

        $user_pickuplocation = $user_address;
        
        Session::put('user_address_id', $user_address_id);
        Session::put('delivery_type', 'pickup');
        Session::put('city_id', $city_id);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Pickup station set successfully!');
        
        $cart = Session::get('cart');

        if($cart != null){
            
            Log::info( "Found items in the cart at save pickup station and will redirect to payments for user ".$userId);

            if(count($cart) > 0){
                
                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id', 'user_address', 
                    'user_pickuplocation'));
            }
        }

        Log::info( "No items were found in the cart for the user with ID ".$userId);
            
        return redirect(url()->previous());
    }


    public function savePickupLocationAgent(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
            Log::info( "Got a logged in user with id in the savePickupLocation method for id ".$userId);

        } else {

            $userId = $request->user_id;

            Log::info( "Did not find a logged in user in the pickup method but found one in the request with ID ".$userId);
        }
        
        $request->validate(['city' => 'required', 'pickup_location'=> 'required']);

        $customer_email = $request->customer_email;
        
        $pickuplocation_id = $request->user_pickuplocation_id;
        $pickup_station = $request->pickup_location;
        $city_id = $request->city;
        
        if(strlen($pickuplocation_id) == 0){

            $user_pickuplocation = new User_pickup_location();

            Log::info( "Creating a new pickup station for user id ".$userId);

        }else {
            
            $user_pickuplocation = User_pickup_location::findorfail($pickuplocation_id);

            Log::info( "Got an existing pickup station for the user ".$userId);
        }

        if($customer_email != null){

            if(strlen($customer_email) > 0){

                if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $customer_email)){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message', 'Invalid Email Address. Please enter a valid email address!');

                    return redirect(url()->previous());
                }

                $customerExists = User::where('email', $customer_email)->first();

                if($customerExists == null){

                    $first_name = $request->first_name;
                    $last_name = $request->last_name;      
                    $password = bcrypt($first_name);
                    $active = 0;

                    $user = new User();
                    $user->first_name = $first_name;
                    $user->last_name = $last_name;
                    $user->password = $password;
                    $user->active = $active;
                    $user->created_by_agent = $userId;
                    $user->email = $customer_email;
                    $user->phone = $telephone;

                    $user->save();

                    $user_pickuplocation->user_id = $user->id;
                }else{

                    $user_pickuplocation->user_id = $customerExists->id;
                }
            }
        }

        $user_pickuplocation->warehouse_id = $pickup_station;
        $user_pickuplocation->default = 1;

        $user_pickuplocation->save();

        Log::info( "Saved a pickup station for user with ID ".$userId);
        
        $user_address_id = $user_pickuplocation->id;

        Log::info( "Picked up the station with ID  ".$user_address_id);

        $user_address = User_pickup_location::find($user_address_id);
        
        Session::put('user_address_id', $user_address_id);
        Session::forget('delivery_type');
        Session::put('delivery_type', 'pickup');
        Session::put('city_id', $city_id);
        
        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Pickup station set successfully!');
        
        $cart = Session::get('cart');

        if($cart != null){
            
            Log::info( "Found items in the cart at save pickup station and will redirect to payments for user ".$userId);

            if(count($cart) > 0){
                
                return view('modules/customer/checkout/payment_information',
                compact('userId', 'user_address_id', 'user_address'));
            }
        }

        Log::info( "No items were found in the cart for the user with ID ".$userId);
            
        return redirect(url()->previous());
    }
    
    
    public function continue_payment() {

        $delivery_type = Session::get('delivery_type');

        $user_address_id = Session::get('user_address_id');

        $userId = Session::get('userId');

        $cart_items = Session::get('cart_items');

        if(count($cart_items) == 0){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'You have no items in the cart. 
                Please shop to continue to payment');

            return redirect(url()->previous());
        }
        
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

            $user_address = User_pickup_location::find($user_address_id); 

            Session::put('user_address_id', $user_address_id);
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id', 'user_address'));
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
            $user_address = User_address::find($user_address_id);
            
            Session::put('user_address_id', $user_address_id);
            return view('modules/customer/checkout/payment_information',
                    compact('userId', 'user_address_id', 'user_address'));
        }
    }
    

    public function payment_method(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->userId;
        }
        
        $user_address_id = $request->user_address_id; 
        $transaction_cost = 0;

        $payment_option = $request->payment_option;
        if($payment_option == ""){
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message_error', 'You have not selected any'
                    . ' payment option. Please choose one of the options to'
                    . ' continue!');
            
            return redirect(url()->previous());
        }
        
        $order_value = Utilities::getCustomerTotalCartPrice();
        Session::put('order_value', $order_value);
        Session::put('delivery_type', $request->delivery_type);

        $delivery_type = $request->delivery_type;
        
        if($request->delivery_type == 'home_office_delivery')
        {

            $city = Session::get('city_id');

         }else if($request->delivery_type == 'pickup'){

            $city = Session::get('city_id');

         }

         $products_value = Utilities::getCustomerTotalCartPriceNoShipping();

        //  if($products_value < 20000)
        //  {
        //     $shipping_cost = Utilities::getShippingCost($city);
        //     $dil_shipping = $shipping_cost;
        //  }else{
        //     $shipping_cost = 0;
        //     $hiddshipping_cost = Utilities::getHiddenShippingCost();
        //     $dil_shipping = $hiddshipping_cost;
        // }
    

        $shipping_cost = Utilities::getShippingCost($city);
        $hiddshipping_cost = Utilities::getHiddenShippingCost();
        $dil_shipping = 0;

        $actual_shipping_cost = 0;

        if($shipping_cost == 0){

            $dil_shipping = $hiddshipping_cost;

        }elseif($shipping_cost > 0){

            $dil_shipping = $shipping_cost;
        }
        
        if($payment_option == "PAYPAL"){
                     
            $transaction_cost = round(0.035*($order_value+$shipping_cost));
        } 

        // dd($hiddshipping_cost);

        Session::put('payment_option', $payment_option);
        Session::put('shipping_cost', $shipping_cost);
        Session::put('dil_shipping', $actual_shipping_cost);
        Session::put('transaction_cost', $transaction_cost);

        if($payment_option == "IPAY"){

            $order_id = Utilities::saveOrder($userId, $products_value,
                        $actual_shipping_cost, 0, $user_address_id, 4, "UNPAID", 
                        $delivery_type);

            return view('modules/customer/checkout/order_review',
                compact('userId', 'user_address_id', 'payment_option',
                 'dil_shipping', 'order_value', 'shipping_cost',
                  'transaction_cost', 'order_id', 'products_value', 
                  'delivery_type'));
        }
        
        return view('modules/customer/checkout/order_review',
                compact('userId', 'user_address_id', 'payment_option',
                        'order_value', 'shipping_cost', 'dil_shipping',
                         'transaction_cost', 'products_value',
                          'delivery_type'));      
    }
    
    
    public function complete_transaction(Request $request){
        
        if(Auth::user() != null){
            
            $userId = Auth::user()->id;
        } else {
            $userId = $request->userId;
        }
        $payment_option = $request->payment_option;
        $user_address_id = $request->user_address_id;    
        $delivery_type = $request->delivery_type;
        $gateway = Payment_gateway::where('name', $payment_option)->first()->id;
        $order_value = $request->order_value;
        $products_value = $request->products_value;
            
        $shipping_cost = $request->shipping_cost;
        $dil_shipping = $request->dil_shipping;

        // dd($dil_shipping);
        
        if($payment_option == "MPESA ON DELIVERY"){
            
            $order_id = Utilities::saveOrder($userId, $products_value,
                    $dil_shipping, 0, $user_address_id, $gateway, "UNPAID", 
                    $delivery_type);
            
            return redirect('shop/transaction/success/' . $order_id);
            
        }else if($payment_option == "MPESA (PREPAID)"){
            
            $order_id = Utilities::saveOrder($userId, $products_value,
                    $dil_shipping, 0, $user_address_id, $gateway, "UNPAID", 
                    $delivery_type);
            
            $order = Order::find($order_id);
            
            return view('modules/customer/checkout/mpesa_payment',
                compact('userId', 'gateway', 'order_value', 'shipping_cost',
                        'user_address_id', 'order'));
            
        }else if($payment_option == "PAYPAL"){
                    
            $transaction_cost = round(0.035*($order_value + $shipping_cost));
            $total_paypalcost = $order_value + $shipping_cost + $transaction_cost;
            
            $order_id = Utilities::saveOrder($userId, $products_value, $dil_shipping, 
                    $transaction_cost, $user_address_id, $gateway, "UNPAID", 
                    $delivery_type);
            
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


    public function getPickupPoints(Request $request){
        
        $city_id = $request->city;
        $points = Warehouse::where('city_id', $city_id)->get();
        // $html = '<option value="">Select Pick</option>';

        $html = '';
        
        foreach($points as $point){
            
            $html = $html.'<option value="'.$point->id.'">'.$point->name.' ('.strtoupper($point->city->name) .')</option>';
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


    public function getCityAreas(Request $request){
        
        $area_id = $request->city;
        $areas = Area::where('city_id', $area_id)->get();
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
        
        $orders = Order::where('user_id', $user_id)->orderBy('id', 'DESC')->get();

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
    
    
    public function searchByCategory($slug){

        $page = 1;

        $limit = 40;
        $offset = 0;

        if(Cache::has('searched_category_'.$slug)) {

            $category = Cache::get('searched_category_'.$slug);

        }else{

            $category = Category::where('slug', $slug)->first();
            $minutes = 60;
            Cache::add('searched_category_'.$slug, $category, $minutes);
        }

        $actual_link = url('/shop/category/'.$slug);

        if($category == null){

            return redirect(url('/shop'));
        }

        $category_id = $category->id;

        $title = "DIL.AFRICA - ".$category->name;

        if(Cache::has('searched_category_products'.$slug)) {

            $product_details = Cache::get('searched_category_products'.$slug);

            $products = $product_details["products"];
            $brands = $product_details["brands"];
            $colors = $product_details["colors"];
            $maximum_price = $product_details["maximum_price"];
            $minimum_price = $product_details["minimum_price"];
            $no_of_pages = $product_details["no_of_pages"];

        }else{

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
            'product_prices.product_id')->where('product_prices.status', 1)
                    ->whereIn('category_id', $all_ids);

            $products_ids_query = clone $products_query;

            $total_products_query = clone  $products_query;

            $total_products = count($total_products_query->get());
        
            $products = $products_query->groupBy('products.id')
                ->orderBy('standard_price')
                // ->skip($offset)->take($limit)
                ->get(['products.id', 'name', 'product_code', 'seller_id', 
                    'product_description', 'category_id', 'slug', 'product_id', 
                    'standard_price', 'color', 'product_prices.size']);

            $brands = Brand::where('category_id', $category_id)->get();
            $product_ids = $products_ids_query->get(['products.id'])->toArray();
            
            $product_prices = Product_price::whereIn('product_id', $product_ids);
            
            $product_prices_copy = clone $product_prices;
            
            $maximum_price = $product_prices_copy->get()->max('standard_price');
            $minimum_price = $product_prices_copy->get()->min('standard_price');
            
            $colors = $product_prices->where('color', '!=', null)
                        ->distinct('color')->get();

            $no_of_pages = round($total_products/40);

            $product_details_array = [];

            $product_details_array["products"] = $products;
            $product_details_array["brands"] = $brands;
            $product_details_array["colors"] = $colors;
            $product_details_array["maximum_price"] = $maximum_price;
            $product_details_array["minimum_price"] = $minimum_price;
            $product_details_array["no_of_pages"] = $no_of_pages;

            $minutes = 60;

            Cache::add('searched_category_products'.$slug, $product_details_array, $minutes);
        }
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'category', 
                'title', 'no_of_pages', 'page', 'actual_link'));
    }


    public function searchFlashSale(){

        $page = 1;

        $limit = 40;
        $offset = 0;

        $title = "DIL.AFRICA - Flash Sale!!!";

        $products_query = Product::leftJoin('flash_sales', 'products.id', '=', 
            'flash_sales.product_id')->leftJoin('product_prices', 'products.id', '=', 
            'product_prices.product_id')->where('flash_sales.status', 1)
            ->where('flash_sales.active_from', '<=', date('Y-m-d H:i:s'))
            ->where('flash_sales.expires_on', '>=', date('Y-m-d H:i:s'));

        $products_ids_query = clone $products_query;

        $total_products_query = clone  $products_query;

        $total_products = count($total_products_query->get());
        
        $products = $products_query->groupBy('products.id')
            ->orderBy('flash_sales.offer_price')
            ->get(['products.id', 'name', 'products.product_code', 'seller_id', 
                'product_description', 'category_id', 'slug', 'flash_sales.product_id', 
                'flash_sales.offer_price', 'color', 'product_prices.size']);

        if(count($products) < 1){

            Session::flash('flash_message', 'No products in flash sale. Please check
             with us later');
            return redirect(url('/shop'));
        }

        $category_ids = [];

        foreach ($products as $key) {
            array_push($category_ids, $key->category_id);
        }

        $brands = Brand::whereIn('category_id', $category_ids)->get();
        $product_ids = $products_ids_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->get()->max('offer_price');
        $minimum_price = $product_prices_copy->get()->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)
                    ->distinct('color')->get();

        $no_of_pages = round($total_products/40);
        
        return view('modules/customer/flash_sale/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 
                'title', 'no_of_pages', 'page'));
    }


    public function searchByCategoryPagination($slug, $no_of_pages, $page){

        $limit = 40;
        $offset = ($page - 1) * 40;

        $actual_link = url('/shop/category/'.$slug);

        $category = Category::where('slug', $slug)->first();

        if($category == null){

            return redirect(url('/shop'));
        }

        $category_id = $category->id;

        $title = "DIL.AFRICA - ".$category->name;

        $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

        $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
            'product_prices.product_id')->where('product_prices.status', 1)
                    ->whereIn('category_id', $all_ids);

        $products_ids_query = clone $products_query;
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            // ->skip($offset)->take($limit)
            ->get(['products.id', 'name', 'product_code', 'seller_id', 
                'product_description', 'category_id', 'slug', 
            'product_id', 'standard_price', 'color', 'product_prices.size']);

        $brands = Brand::where('category_id', $category_id)->get();
        $product_ids = $products_ids_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->get()->max('standard_price');
        $minimum_price = $product_prices_copy->get()->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)
                    ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'category', 
                'title', 'no_of_pages', 'page', 'actual_link'));
    }


    public function searchCampaignProducts($id){

        $title = "DIL.AFRICA - Enjoy Big Discounts!";

        $page = 1;

        $limit = 40;
        $offset = 0;

        $all_ids = Campaign_product::where('campaign_id', $id)
            ->get(['product_id'])->toArray();

        $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
            'product_prices.product_id')->where('product_prices.status', 1)
                    ->whereIn('products.id', $all_ids);

        $products_ids_query = clone $products_query;

        $total_products_query = clone  $products_query;

        $total_products = count($total_products_query->get());

        $no_of_pages = round($total_products/40);
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            // ->skip($offset)->take($limit)
            ->get(['products.id', 'name', 'product_code', 'seller_id', 
                'product_description', 'category_id', 'slug', 
            'product_id', 'standard_price', 'color', 'product_prices.size']);

        $brands_query = clone $products_query;

        $brands_ids = $brands_query->get(['brand_id']);

        $brands = Brand::whereIn('id', $brands_ids)->get();

        $product_ids = $products_ids_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->get()->max('standard_price');
        $minimum_price = $product_prices_copy->get()->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)
                    ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'category', 
                'title', 'no_of_pages', 'page', 'actual_link'));
    }


    public function filterByPriceRange($slug, $from, $to){
        
        $page  = 1;
        $limit = 40;
        $offset = ($page - 1) * 40;

        $actual_link = url('/shop/category/'.$slug);

        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();
            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $parent_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                        ->whereIn('category_id', $all_ids); 

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');     
        
            $parent_query = Product::leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->where( function ($query) use ($pattern) {
                        $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%');
                })->where('products.publish_status', 1);

            $title = "DIL.AFRICA - ".$pattern;

            $brands_query = clone $parent_query;
        
            $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();
        }

        $products_query = clone $parent_query;

        $products_query = $products_query->whereBetween('product_prices.standard_price', 
             [$from, $to]);

        $products_ids_query = clone $products_query;

        $total_products_query = clone  $products_query;

        $total_products = count($total_products_query->get());

        $no_of_pages = round($total_products/40);
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            // ->skip($offset)->take($limit)
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);

        $product_ids = $products_ids_query->get(['products.id'])->toArray();

        $product_ids_forprices = $parent_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids_forprices);

        $active_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->get()->max('standard_price');
        $minimum_price = $product_prices_copy->get()->min('standard_price');

        $active_maxprice = $active_prices->get()->max('standard_price');
        $active_minprice = $active_prices->get()->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)
                ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price',
                 'category', 'active_maxprice', 'active_minprice', 'title', 
                 'no_of_pages', 'page', 'actual_link'));
    }


    public function filterByColor($slug, $color) {

        $page  = 1;
        $limit = 40;
        $offset = ($page - 1) * 40;

        $actual_link = url('/shop/category/'.$slug);
        
        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();

            if($category == null){

                return redirect(url('/shop'));
            }

            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $parent_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                    ->whereIn('category_id', $all_ids);

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');     
        
            $parent_query = Product::leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'categories.id', '=', 'brands.category_id')
                ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->where( function ($query) use ($pattern) {
                        $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%');
                })->where('products.publish_status', 1);

            $title = "DIL.AFRICA - ".$pattern;

            $brands_query = clone $parent_query;
        
            $brands = $brands_query->select('products.id', 'categories.*',
                'brands.*')->get();
        }

        $products_query = clone $parent_query;
 
        $products_query = $products_query->where('product_prices.id', $color);

        $products_ids_query = clone $products_query;

        $total_products_query = clone  $products_query;

        $total_products = count($total_products_query->get());

        $no_of_pages = round($total_products/40);
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            // ->skip($offset)->take($limit)
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);;

        $product_ids = $products_ids_query->get(['products.id'])->toArray();

        $color_ids = $parent_query->get(['products.id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);

        $color_prices = Product_price::whereIn('product_id', $color_ids);
        
        $maximum_price = $product_prices->get()->max('standard_price');
        $minimum_price = $product_prices->get()->min('standard_price');
        
        $colors = $color_prices->where('color', '!=', null)
                    ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price',
                 'category', 'title', 'no_of_pages', 'page', 'actual_link'));
    }


    public function getAllProducts(){
        
        $products_query = Product::limit(200);

        $products_ids_query = clone $products_query;

        $title = "DIL.AFRICA - All Products";
        
        $products = $products_query->get();
        $brands = Brand::get();
        $product_ids = $products_ids_query->get(['id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('offer_price');
        $minimum_price = $product_prices_copy->min('offer_price');
        
        $colors = $product_prices->where('color', '!=', null)
                ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price',
                 'category', 'title'));
    }


    public function searchByBrand($slug) {
        
        $brand = Brand::where('slug', $slug)->first();

        $brand_id = $brand->id;

        $title = "DIL.AFRICA - ".$brand->name;

        $products_query = Product::where('brand_id', $brand_id);
        $products_ids_query = clone $products_query;
        
        $products = $products_query->get();

        $brands = Brand::where('slug', $slug)->get();

        $product_ids = $products_ids_query->get(['id'])->toArray();
        
        $product_prices = Product_price::whereIn('product_id', $product_ids);
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)
                ->distinct('color')->get();
        
        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'title'));
    }

    
    public function search(Request $request){
        
        $pattern = $request->pattern;     
        Session::put('search_pattern', $pattern);

        $title = "DIL.AFRICA - ".$pattern;

        $pattern = preg_replace('!\s+!', ' ', trim($pattern));

        $pattern = strtolower($pattern);

        $last3 = substr($pattern, -3);

        if($last3 == "ies"){

            $pattern = substr($pattern, 0, strlen($pattern) - 3);
        }elseif(substr($pattern, -1) == "s"){

            $pattern = substr($pattern, 0, strlen($pattern) - 1);
        }
        
        $products_query = Product::leftJoin('categories', 
                'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                'products.brand_id', '=', 'brands.id')
                ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->where( function ($query) use ($pattern) {
                        $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                         ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                         ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                        ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%');
                    })->where('products.publish_status', 1); 
        
        $products = $products_query->select('products.*')->orderBy('category_id')->get();

        if(count($products) < 1){

            $pattern = preg_replace('/\s+/', ' ', $pattern);
            $strs = explode(" ",$pattern);

            if(count($strs) > 1) {

                $product_name_guess = $strs[0];
                $category_name_guess = $strs[1];
                $brand_name_guess = $strs[0];

                $guessed_category = Category::where('name', 'LIKE', '%'.$category_name_guess.'%')->get();
                $guessed_brand = Brand::where('name', 'LIKE', '%'.$brand_name_guess.'%')->get();

                if(count($guessed_category) > 0) {

                    $products_query = Product::leftJoin('categories', 
                        'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                        'products.brand_id', '=', 'brands.id')
                        ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                        ->where( function ($query) use ($strs,$category_name_guess) {

                            $query->where('products.name', 'LIKE', '%'.$strs[0].'%')
                             ->orWhere('products.author', 'LIKE', '%'.$strs[0].'%')
                             ->orWhere('products.publisher', 'LIKE', '%'.$strs[0].'%');
                        })->where('categories.name', 'LIKE', '%'.$category_name_guess.'%')
                            ->where('products.publish_status', 1);

                }elseif(count($guessed_brand) > 0) {

                    $products_query = Product::leftJoin('categories', 
                        'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                        'products.brand_id', '=', 'brands.id')
                        ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                        ->where( function ($query) use ($strs,$category_name_guess,$brand_name_guess) {

                            $query->where('categories.name', 'LIKE', '%'.$category_name_guess.'%');
                        })->where('brands.name', 'LIKE', '%'.$brand_name_guess.'%')
                            ->where('products.publish_status', 1);

                }else{

                    $products_query = Product::leftJoin('categories', 
                        'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                        'products.brand_id', '=', 'brands.id')
                     ->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                        ->where( function ($query) use ($strs) {

                            $query->where('products.name', 'LIKE', '%'.$strs[0].'%')
                             ->orWhere('products.name', 'LIKE', '%'.$strs[1].'%')
                             ->orWhere('products.author', 'LIKE', '%'.$strs[0].'%')
                             ->orWhere('products.author', 'LIKE', '%'.$strs[1].'%')
                             ->orWhere('products.publisher', 'LIKE', '%'.$strs[0].'%')
                             ->orWhere('products.publisher', 'LIKE', '%'.$strs[1].'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$strs[1].'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$strs[0].'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$strs[0].'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$strs[1].'%');
                        })->where('products.publish_status', 1); 

                    }
                }

                $products = $products_query->select('products.*')->orderBy('category_id')->get();

                $brands_query = clone $products_query;
        
                $brands = $brands_query->select('products.id', 'categories.*',
                        'brands.*')->get(); 

        }else {

            $brands_query = clone $products_query;
        
            $brands = $brands_query->select('products.id', 'categories.*',
                    'brands.*')->get(); 
        }
        
        $brands_products_ids = [];

        $user_id = null;

        if(Auth::user() != null){

            $user_id = Auth::user()->id;
        }

        $original_search_item = $pattern;

        if(count($products) > 0){

            $search_hit = "Successful";
        }else{

            $search_hit = "Failure";
        }

        $ip = $request->ip();

        $searched_item = new Searched_item();

        $searched_item->ip_address = $ip;
        $searched_item->user_id = $user_id;
        $searched_item->original_search_item = $original_search_item;
        $searched_item->search_hit = $search_hit;

        $searched_item->save();

        $searched_item_id = $searched_item->id;
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern',
                 'title', 'searched_item_id'));
    }


    public function searchRaw(Request $request){
        
        $pattern = $request->pattern;   

        if(trim($pattern) == ""){

            return redirect(url('/'));
        }
        Session::put('search_pattern', $pattern);

        $title = "DIL.AFRICA - ".$pattern;

        $pattern = preg_replace('!\s+!', ' ', trim($pattern));

        $search_hit = null;
        
        $products = DB::select("SELECT products.id, products.name, products.product_code, 
         products.seller_id, products.product_description, products.publish_status,
          products.category_id, products.slug, products.brand_id, products.model, 
          products.keywords, brands.id as brand_id, brands.name as brand_name, brands.slug as brand_slug,
           product_prices.standard_price, product_prices.offer_price, 
          product_prices.color, product_prices.size, product_prices.quantity, product_prices.seller_code
           FROM products INNER JOIN categories ON products.category_id = 
                categories.id INNER JOIN brands ON products.brand_id = brands.id INNER JOIN product_prices 
                ON products.id = product_prices.product_id WHERE (products.name LIKE '%".$pattern."%' 
                OR products.author LIKE '%".$pattern."%'
                OR products.publisher LIKE '%".$pattern."%'
                OR categories.name LIKE '%".$pattern."%'
                OR brands.name LIKE '%".$pattern."%')
                AND products.publish_status = '1' ORDER BY product_prices.standard_price");

        if(count($products) < 1){

            $pattern = preg_replace('/\s+/', ' ', $pattern);
            $strs = explode(" ",$pattern);

            if(count($strs) > 1) {

                $products = DB::select("SELECT products.id, products.name, products.product_code, 
                 products.seller_id, products.product_description, products.publish_status,
                  products.category_id, products.slug, products.brand_id, products.model, 
                  products.keywords, brands.id as brand_id, brands.name as brand_name, brands.slug as brand_slug,
                   product_prices.standard_price, product_prices.offer_price, 
                  product_prices.color, product_prices.size, product_prices.quantity, product_prices.seller_code
                   FROM products INNER JOIN categories ON products.category_id = 
                        categories.id INNER JOIN brands ON products.brand_id = brands.id INNER JOIN product_prices 
                        ON products.id = product_prices.product_id WHERE (products.name LIKE '%".$strs[0]."%' 
                        OR products.name LIKE '%".$strs[1]."%'
                        OR products.author LIKE '%".$strs[0]."%'
                        OR products.author LIKE '%".$strs[1]."%'
                        OR products.publisher LIKE '%".$strs[0]."%'
                        OR products.publisher LIKE '%".$strs[1]."%'
                        OR products.product_description LIKE '%".$strs[0]."%'
                        OR products.product_description LIKE '%".$strs[1]."%'
                        OR categories.name LIKE '%".$strs[0]."%'
                        OR categories.name LIKE '%".$strs[1]."%'
                        OR brands.name LIKE '%".$strs[0]."%'
                        OR brands.name LIKE '%".$strs[1]."%')
                        AND products.publish_status = '1' ORDER BY product_prices.standard_price");
            }

        }

        $ip = $request->ip();
        $user_id = null;

        if(Auth::user() != null){

            $user_id = Auth::user()->id;
        }

        $original_search_item = $pattern;

        if(count($products) > 0){

            $search_hit = "Successful";
        }else{

            $search_hit = "Failure";
        }

        $searched_item = new Searched_item();

        $searched_item->ip_address = $ip;
        $searched_item->user_id = $user_id;
        $searched_item->original_search_item = $original_search_item;
        $searched_item->search_hit = $search_hit;

        $searched_item->save();

        $searched_item_id = $searched_item->id;
        
        $brands_products_ids = [];
        
        foreach($products as $product){

            array_push($brands_products_ids, $product->id);
        }

        $brands_products_ids = implode("','",$brands_products_ids);

        $brands = $products;

        $product_prices = DB::select("SELECT * FROM product_prices WHERE 
            product_id IN ('".$brands_products_ids."')");   
        
        $prices_range = DB::select("SELECT MAX(standard_price) AS maximum,
         MIN(standard_price) AS minimum FROM product_prices WHERE 
            product_id IN ('".$brands_products_ids."')"); 
        
        $maximum_price = $prices_range[0]->maximum;
        $minimum_price = $prices_range[0]->minimum;
        
        $colors = DB::select("SELECT  *  FROM product_prices INNER JOIN products 
        ON product_prices.product_id = products.id WHERE product_prices.product_id
         IN ('".$brands_products_ids."') AND color IS NOT NULL GROUP BY color");    

        return view('modules/customer/category/index', compact('products',
                'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern',
                 'title', 'searched_item_id'));
    }


    public function saveSearchedItems(Request $request){

        $this->validate($request, ['item_looking_for' => 'required', 
            'phone' => 'required']);

        // Log::info("Request is ".print_r($request, 1));

        $searched_item_id = $request->searched_item_id;

        $searched_item = Searched_item::find($searched_item_id);

        if($searched_item == null){

            return redirect()->intended(url()->previous());
        }

        $searched_item->prompted_search_item = $request->item_looking_for;
        $searched_item->email_address = $request->email;
        $searched_item->phone_number = $request->phone;

        $searched_item->save();

        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Thank you. We will seek for the best deals for you and get in touch with you!');

        return redirect(url('/'));

    }
    
    
    public function searchDefault($slug){    
        
        $search_mode = 'Default';

        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();

            if($category == null){

                return redirect(url('/shop'));
            }
            
            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                        ->whereIn('category_id', $all_ids); 

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');

            $title = "DIL.AFRICA - ".$pattern;

            $products_query = Product::leftJoin('categories', 
                    'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                    'products.brand_id', '=', 'brands.id')
                        ->where( function ($query) use ($pattern) {
                            $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
                        })->where('products.publish_status', 1);
            
            $brands_query = clone $products_query;
            
            $brands = $brands_query->select('products.id', 'categories.*',
                    'brands.*')->get();  
        }
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        if($slug != "custom-search") {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'category',
                     'search_mode'));
        }else {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price',
                     'pattern', 'search_mode', 'title'));
        }
    }
    
    
    public function searchLowestPriceFirst($slug){    
        
        $search_mode = 'Price:lowest first';

        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();

            if($category == null){

                return redirect(url('/shop'));
            }

            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                        ->whereIn('category_id', $all_ids); 

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');

            $title = "DIL.AFRICA - ".$pattern;
            
            $products_query = Product::leftJoin('product_prices', 
                    'products.id', '=', 'product_prices.product_id')->leftJoin('categories', 
                    'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                    'products.brand_id', '=', 'brands.id')
                        ->where( function ($query) use ($pattern) {
                            $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
                        })->where('product_prices.is_default', 1)
                        ->where('products.publish_status', 1);
            
            $brands_query = clone $products_query;
            
            $brands = $brands_query->select('products.id', 'categories.*',
                    'brands.*')->get();  
        }
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price')
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        if($slug != "custom-search") {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'category',
                     'search_mode', 'title'));
        }else {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern',
                     'search_mode', 'title'));
        }
    }
    
    
    public function searchHighestPriceFirst($slug){    
        
        $search_mode = 'Price:Highest first';

        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();

            if($category == null){

                return redirect(url('/shop'));
            }

            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                        ->whereIn('category_id', $all_ids); 

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');

            $products_query = Product::leftJoin('product_prices', 
                    'products.id', '=', 'product_prices.product_id')->leftJoin('categories', 
                    'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                    'products.brand_id', '=', 'brands.id')
                        ->where( function ($query) use ($pattern) {
                            $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
                        })->where('product_prices.is_default', 1)
                        ->where('products.publish_status', 1);

            $title = "DIL.AFRICA - ".$pattern;
            
            $brands_query = clone $products_query;
            
            $brands = $brands_query->select('products.id', 'categories.*',
                    'brands.*')->get();  
        }
        
        $products = $products_query->groupBy('products.id')->orderBy('standard_price', 'DESC')
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      


        if($slug != "custom-search") {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'category',
                     'search_mode', 'title'));
        }else {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern',
                     'search_mode', 'title'));
        }
    }
    
    
    public function searchOrderByName($slug){    
        
        $search_mode = 'Product Name: A to Z';

        if($slug != "custom-search") {

            $category = Category::where('slug', $slug)->first();

            if($category == null){

                return redirect(url('/shop'));
            }
            $category_id = $category->id;

            $title = "DIL.AFRICA - ".$category->name;

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($category_id);

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->where('product_prices.status', 1)
                        ->whereIn('category_id', $all_ids); 

            $brands = Brand::where('category_id', $category_id)->get();

        } else{

            $pattern = Session::get('search_pattern');

            $products_query = Product::leftJoin('product_prices', 'products.id', '=', 
                'product_prices.product_id')->leftJoin('categories', 
                    'products.category_id', '=', 'categories.id')->leftJoin('brands', 
                    'products.brand_id', '=', 'brands.id')
                        ->where( function ($query) use ($pattern) {
                            $query->where('products.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.author', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.publisher', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.product_description', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('products.highlight', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('categories.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.name', 'LIKE', '%'.$pattern.'%')
                            ->orWhere('brands.description', 'LIKE', '%'.$pattern.'%');
                        })->where('products.publish_status', 1);

            $title = "DIL.AFRICA - ".$pattern;
            
            $brands_query = clone $products_query;
            
            $brands = $brands_query->select('products.id', 'categories.*',
                    'brands.*')->get();  
        }
        
        $products = $products_query->groupBy('products.id')->orderBy('products.name')
            ->get(['products.id', 'products.name', 'products.product_code', 'products.seller_id', 
                'product_description', 'products.category_id', 'products.slug', 
            'product_prices.product_id', 'product_prices.standard_price',
             'product_prices.color', 'product_prices.size']);
        
        $brands_products_ids = [];
        
        foreach($products as $product){
            array_push($brands_products_ids, $product->id);
        }
        
        $product_prices = Product_price::whereIn('product_id', $brands_products_ids);    
        
        $product_prices_copy = clone $product_prices;
        
        $maximum_price = $product_prices_copy->max('standard_price');
        $minimum_price = $product_prices_copy->min('standard_price');
        
        $colors = $product_prices->where('color', '!=', null)->distinct('color')
                ->get();      

        if($slug != "custom-search") {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'category',
                     'search_mode', 'title'));
        }else {

            return view('modules/customer/category/index', compact('products',
                    'brands', 'colors', 'maximum_price', 'minimum_price', 'pattern',
                     'search_mode', 'title'));
        }
    }


    public function add_to_wishlist($product_id, $product_price_id, Request $request){
        
        $user = Auth::user();
        Session::put('wishlist_product_ref', $product_id);
        
        if($user != null){
            
            $user_id = $user->id;
            $product_id = Session::get('wishlist_product_ref');
        }else{
            
            Session::put('page', '/shop/add_to_wishlist/'.$product_id.'/'.$product_price_id);
            return redirect(url('/shop/sign-in'));
        }
        
        $customerWishlist = new Customer_wishlist();
        
        $customerWishlist->ip_address = $request->ip();     
        $customerWishlist->product_id = $product_id;
        $customerWishlist->product_price_id = $product_price_id;
        $customerWishlist->user_id = $user_id;
        
        $customerWishlist->save();
        
        Session::flash('alert-class', 'alert-success'); 
        Session::flash('flash_message', 'Item added to your wishlist successfully!');

        return redirect()->intended(url()->previous());
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
        
        if($delivery_type == 2){
            
            Session::put('delivery_type', 'pickup');
            $user_address = User_pickup_location::where('user_id',
                        $userId)->where('default', 1)->first();
            
            if($user_address != null) {
                Session::put('user_address_id', $user_address->id);
            }
            
        }else if($delivery_type == 1){
            
            Session::put('delivery_type', 'home_office_delivery');
            
            $user_address = User_address::where('user_id',$userId)
                    ->where('default', 1)->first();
            
            if($user_address != null) {
                Session::put('user_address_id', $user_address->id);
            }
        }
        return response()->json(["delivery_type" => Session::get('delivery_type')]);
    }

    public  function  invoice($order_id)
    {
      
      $order= Order::findorfail($order_id);

      return  view('modules/customer/checkout/invoice', compact('order'));

    }

    public function view_invoice($order_id){

        $order = Order::findorfail($order_id);

        $pdf = PDF::loadView('modules/customer/checkout/invoice', compact('order'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->Stream('Your Order Ref. '.$order->order_reference.'.pdf');
    }

    public function download_invoice($order_id){

        $order = Order::findorfail($order_id);

        $pdf = PDF::loadView('modules/customer/checkout/invoice', compact('order'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Your Order Ref. '.$order->order_reference.'.pdf');
    }

    public function logout(){

        Auth::logout();
        return redirect('/shop');
    }


    public function upload_cities(){

        $cities = ["Archerspost","Bahati","Baragoi","Baringo","Bissil","Bomet","Bumala","Bungoma","Busia","Butere","Cheptais","Chogoria","Chuka","Daadab","Dundori","Eldama Ravine","Eldoret","Embu","Endarasha","Funyula","Garbatula","Garissa","Gatundu","Hola","Homa Bay","Isiolo","Iten","Juakali","Kabarnet","Kabati","Kabuti","Kagio","Kagumo","Kajiado","Kakamega","Kakuma","Kaloleni","Kandara","Kangari","Kangema","Kangundo","Kapcherop","Kapenguria","Kapenguria","Kapsabet","Kapsokwony","Kapsowar","Karatina","Kathiani","Kericho","Keroka","Kerugoya Kutus","Kiambu","Kibwezi","Kilifi","Kimilili","Kinamba","Kinna","Kiria-Ini","Kisii","Kisumu Kenya","Kitale","Kitui","Laisamis","Lamu","Lare","Limuru","Lodwar","Loiyangalani","Lokichogio","Lolgorian","Lungalunga","Machakos","Machinery","Magarini","Majimazuri","Malindi","Mandera","Maralal","Marereni","Maseno","Masii","Maunarok","Mazeras","Mbita Point","Merti","Mitunguu","Mogonga","Mogotio","Molo","Mombasa Kenya","Mtito Andei","Muhuru Bay","Muranga","Mwatate","Mweiga","Mwingi","Nairagieenkare","Nairobi Kenya","Naivasha","Nanyuki","Narok","Naromoru","Ndori","Ngong’","Njabini","Nyahururu","Nyakach","Nyamache","Nyamarambe","Nyamira","Nyansiongo","Nyeri","Ogembo","Olenguruone","Ol Kalou","Othaya","Rongai","Ruiru","Runyenjes","Salgaa","Siakago","Siaya","Sindo","Sololo","Sultan Hamud","Taveta","Thika","Timboroa","Tongaren","Ugunja","Ukunda","Voi","Wajir","Watamu","Webuye","Wote","Wundanyi","Yala"];

        $count = 0;

        Log::info("Called the upload cities function");

        foreach ($cities as $city) {

            Log::info("Entered the for loop function");
            
            $city_exists = City::where('name', $city)->first();

            if($city_exists == null){

                $new_city = new City();

                $new_city->country_id = 1;
                $new_city->name = $city;

                $new_city->save();
                $count++;

                Log::info("Uploaded city / town number ".$count);
            }
        }

        Log::info($count.' cities/towns added successfully');

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', $count.' cities/towns added successfully');
    }


    public function upload_zones(){

        $count = 0;

        Log::info("Called the upload zones function");

        $cities = City::where('id', '!=', 1)->where('id', '!=', 55)->get();

        foreach ($cities as $city) {

            Log::info("Entered the for loop function");

            $new_zone = new Zone();

            $new_zone->city_id = $city->id;
            $new_zone->name = $city->name;

            $new_zone->save();
            $count++;

            Log::info("Uploaded zone number ".$count);

        }

        Log::info($count.' zones added successfully');

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', $count.' zones added successfully');
    }


    public function upload_areas(){

        $count = 0;

        Log::info("Called the upload areas function");

        $cities = City::where('id', '!=', 1)->where('id', '!=', 27)
            ->where('id', '!=', 55)->where('id', '!=', 58)->get();

        foreach ($cities as $city) {

            Log::info("Entered the for loop function");

            $new_area = new Area();

            $new_area->city_id = $city->id;
            $new_area->name = $city->name;

            $new_area->save();
            $count++;

            Log::info("Uploaded area number ".$count);

        }

        Log::info($count.' areas added successfully');

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', $count.' areas added successfully');
    }


    public function upload_shipping_csv(){

        $cities = City::where('id', '!=', 1)->get();

        $category_name = "";
        $category = null;

        $row = 1;
        $uploaded = 0;

        if (($handle = fopen("/var/www/html/dil/categories_shipping_prices.csv", "r")) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";

                    if($c == 0){ 
                        $category_name = $data[$c]; 
                        $category = Category::where('name', $category_name)->first();
                    }
                    if($c == 1){ 
                        
                        $nairobi_pickup = $data[$c]; 

                        if($category != null){

                            $category_id = $category->id;
                            $shipping_type_id = 1;
                            $city_id = 1;
                            $price_one = $nairobi_pickup;
                            $price_many = $nairobi_pickup;
                            $created_at = date("Y-m-d H:i:s");
                            $updated_at = date("Y-m-d H:i:s");

                            $shipping_price = new Shipping_price();

                            $shipping_price->category_id = $category_id;
                            $shipping_price->shipping_type_id = $shipping_type_id;
                            $shipping_price->city_id = $city_id;
                            $shipping_price->price_one = $price_one;
                            $shipping_price->price_many = $price_many;
                            $shipping_price->created_at = $created_at;
                            $shipping_price->updated_at = $updated_at;

                            $shipping_price->save();

                            $uploaded++;

                            Log::info("Created the ".$uploaded." shipping record");

                        }

                    }
                    if($c == 2){ 
                        $nairobi_home = $data[$c]; 

                        if($category != null){

                            $category_id = $category->id;
                            $shipping_type_id = 2;
                            $city_id = 1;
                            $price_one = $nairobi_home;
                            $price_many = $nairobi_home;
                            $created_at = date("Y-m-d H:i:s");
                            $updated_at = date("Y-m-d H:i:s");

                            $shipping_price = new Shipping_price();

                            $shipping_price->category_id = $category_id;
                            $shipping_price->shipping_type_id = $shipping_type_id;
                            $shipping_price->city_id = $city_id;
                            $shipping_price->price_one = $price_one;
                            $shipping_price->price_many = $price_many;
                            $shipping_price->created_at = $created_at;
                            $shipping_price->updated_at = $updated_at;

                            $shipping_price->save();

                            $uploaded++;

                            Log::info("Created the ".$uploaded." shipping record");

                        }
                    }
                    if($c == 3){ 

                        $others_pickup = $data[$c]; 

                        if($category != null){

                            $category_id = $category->id;
                            $shipping_type_id = 1;
                            $price_one = $others_pickup;
                            $price_many = $others_pickup * 2;
                            $created_at = date("Y-m-d H:i:s");
                            $updated_at = date("Y-m-d H:i:s");

                            foreach ($cities as $city) {
                                
                                $city_id = $city->id;

                                $shipping_price = new Shipping_price();

                                $shipping_price->category_id = $category_id;
                                $shipping_price->shipping_type_id = $shipping_type_id;
                                $shipping_price->city_id = $city_id;
                                $shipping_price->price_one = $price_one;
                                $shipping_price->price_many = $price_many;
                                $shipping_price->created_at = $created_at;
                                $shipping_price->updated_at = $updated_at;

                                $shipping_price->save();

                                $uploaded++;

                                Log::info("Created the ".$uploaded." shipping record");
                            }

                        }
                    }
                }
            }
            fclose($handle);
        }
    }


    public function upload_shipping_one_category() {

        $cities = City::where('id', '!=', 1)->get();

        $category_name = "";
        $category = null;

        $uploaded = 0;
                    
        $nairobi_pickup = 200; 

        $category_id = 225;
        $shipping_type_id = 1;
        $city_id = 1;
        $price_one = $nairobi_pickup;
        $price_many = $nairobi_pickup;
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $shipping_price = new Shipping_price();

        $shipping_price->category_id = $category_id;
        $shipping_price->shipping_type_id = $shipping_type_id;
        $shipping_price->city_id = $city_id;
        $shipping_price->price_one = $price_one;
        $shipping_price->price_many = $price_many;
        $shipping_price->created_at = $created_at;
        $shipping_price->updated_at = $updated_at;

        $shipping_price->save();

        $uploaded++;

        Log::info("Created the ".$uploaded." shipping record");

        $nairobi_home = 250; 

        $shipping_type_id = 2;
        $city_id = 1;
        $price_one = $nairobi_home;
        $price_many = $nairobi_home;
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $shipping_price = new Shipping_price();

        $shipping_price->category_id = $category_id;
        $shipping_price->shipping_type_id = $shipping_type_id;
        $shipping_price->city_id = $city_id;
        $shipping_price->price_one = $price_one;
        $shipping_price->price_many = $price_many;
        $shipping_price->created_at = $created_at;
        $shipping_price->updated_at = $updated_at;

        $shipping_price->save();

        $uploaded++;

        Log::info("Created the ".$uploaded." shipping record"); 

        $others_pickup = 350; 

        $shipping_type_id = 1;
        $price_one = $others_pickup;
        $price_many = $others_pickup * 2;
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        foreach ($cities as $city) {
            
            $city_id = $city->id;

            $shipping_price = new Shipping_price();

            $shipping_price->category_id = $category_id;
            $shipping_price->shipping_type_id = $shipping_type_id;
            $shipping_price->city_id = $city_id;
            $shipping_price->price_one = $price_one;
            $shipping_price->price_many = $price_many;
            $shipping_price->created_at = $created_at;
            $shipping_price->updated_at = $updated_at;

            $shipping_price->save();

            $uploaded++;

            Log::info("Created the ".$uploaded." shipping record");

            $shipping_price = new Shipping_price();

            $shipping_price->category_id = $category_id;
            $shipping_price->shipping_type_id = 2;
            $shipping_price->city_id = $city_id;
            $shipping_price->price_one = $price_one;
            $shipping_price->price_many = $price_many;
            $shipping_price->created_at = $created_at;
            $shipping_price->updated_at = $updated_at;
            
            $shipping_price->save();

            $uploaded++;

            Log::info("Created the ".$uploaded." shipping record");
        }

        echo "Uploaded a total of ".$uploaded." records";
    }


    public function upload_shipping_outsidenai_csv(){

        $cities = City::where('id', '!=', 1)->get();

        $category_name = "";
        $category = null;

        $row = 1;
        $uploaded = 0;

        if (($handle = fopen("/var/www/html/dil/categories_shipping_prices_outnai.csv", "r")) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";

                    if($c == 0){ 
                        $category_name = $data[$c]; 
                        $category = Category::where('name', $category_name)->first();
                    }
                    if($c == 1){ 

                        $others_pickup = $data[$c]; 

                        if($category != null){

                            $category_id = $category->id;
                            $shipping_type_id = 2;
                            $price_one = $others_pickup;
                            $price_many = $others_pickup * 2;
                            $created_at = date("Y-m-d H:i:s");
                            $updated_at = date("Y-m-d H:i:s");

                            foreach ($cities as $city) {
                                
                                $city_id = $city->id;

                                $shipping_price = new Shipping_price();

                                $shipping_price->category_id = $category_id;
                                $shipping_price->shipping_type_id = $shipping_type_id;
                                $shipping_price->city_id = $city_id;
                                $shipping_price->price_one = $price_one;
                                $shipping_price->price_many = $price_many;
                                $shipping_price->created_at = $created_at;
                                $shipping_price->updated_at = $updated_at;

                                $shipping_price->save();

                                $uploaded++;

                                Log::info("Created the ".$uploaded." shipping record");
                            }

                        }
                    }
                }
            }
            fclose($handle);
        }
    }


    public function test_mpesa_token(){

        $response = Utilities::generateMPESAOAuthToken();

        echo $response;
    }

    public function test_mpesa_security_encryption(){

        $response = Utilities::mpesaEncryptSecurityCredentials();

        echo $response;
    }

    public function test_mpesa_stk($order_id){


        $response = Utilities::lipaNaMPESAOnlineSTK($order_id);

        echo $response;
    }

    public function testmpesa_stk(){


        $response = Utilities::mpesaGenerateSTKPassword();

        echo $response;
    }


    public function test_mpesa_register_confirm_url(){

        Log::info("Calling the test for register confirm");

        $response = Utilities::mPESARegisterConfirmURL();

        echo $response;
    }


    public function mpesaSTKCallback(Request $request){

        $postData = file_get_contents('php://input');

        $file = fopen("/var/www/html/dil/storage/logs/mpesa.log", "w"); 

        if(fwrite($file, $postData) === FALSE)
        {
            fwrite("Error: no data written");
        }

        fwrite("\r\n");
        fclose($file);

    }

    public function upload_g4s_pickups(){

        Utilities::upload_pickup_points_csv();
    }


    public function mpesaRegisterURL(){

        $response = Utilities::mPESARegisterConfirmURL();

        echo $response;
    }

    public function mpesaC2BValidate(){

        $postData = file_get_contents('php://input');

        $file = fopen("/var/www/html/dil/storage/logs/mpesa.log", "w"); 

        if(fwrite($file, $postData) === FALSE)
        {
            fwrite($file, "Error: no data written");
        }

        fwrite($file, "\r\n");
        fclose($file);

        echo '{"ResultCode": 0, "ResultDesc": "Accepted"}';


    }

    public function mpesaC2BConfirm(){

        $postData = file_get_contents('php://input');

        $file = fopen("/var/www/html/dil/storage/logs/mpesa.log", "w"); 

        if(fwrite($file, $postData) === FALSE)
        {
            fwrite($file, "Error: no data written");
        }

        fwrite($file, "\r\n");
        fclose($file);

        if( $postData != null){

            $decoded = json_decode($postData);

            $transaction_type = $decoded->TransactionType;
            $transaction_id = $decoded->TransID;
            $transaction_time = $decoded->TransTime;
            $transaction_amount = $decoded->TransAmount;
            $business_code = $decoded->BusinessShortCode;
            $bill_ref_no = $decoded->BillRefNumber;
            $invoice_number = $decoded->InvoiceNumber;
            $org_account_balance = $decoded->OrgAccountBalance;
            $third_party_trans_id = $decoded->ThirdPartyTransID;
            $msisdn = $decoded->MSISDN;
            $first_name = $decoded->FirstName;
            $middle_name = $decoded->MiddleName;
            $last_name = $decoded->LastName;

            $MPESATransactionLog = new MPESATransactionLog();

            $MPESATransactionLog->transaction_type = $transaction_type;
            $MPESATransactionLog->transaction_id = $transaction_id;
            $MPESATransactionLog->transaction_time = $transaction_time;
            $MPESATransactionLog->transaction_amount = $transaction_amount;
            $MPESATransactionLog->business_code = $business_code;
            $MPESATransactionLog->bill_ref_no = $bill_ref_no;
            $MPESATransactionLog->invoice_number = $invoice_number;
            $MPESATransactionLog->org_account_balance = $org_account_balance;
            $MPESATransactionLog->third_party_trans_id = $third_party_trans_id;
            $MPESATransactionLog->msisdn = $msisdn;
            $MPESATransactionLog->first_name = $first_name;
            $MPESATransactionLog->middle_name = $middle_name;
            $MPESATransactionLog->last_name = $last_name;

            $MPESATransactionLog->save();

            $order = Order::where('order_reference', $bill_ref_no)->first();

            if($order != null) {

                $amount_payable = ($order->total_value + $order->shipping_cost + 
                    $order->transaction_cost) - $order->voucher_amount;

                if($amount_payable <= $transaction_amount){

                    $order->payment_status = 'PAID';
                }elseif($transaction_amount > 0){

                    $totalPaid = Order_payment::where('order_id', $order->id)->sum('amount');

                    if(($totalPaid + $transaction_amount) >= $amount_payable){

                        $order->payment_status = 'PAID';
                    }else {

                        $order->payment_status = 'PARTIALLY_PAID';
                    }
                    
                }

                $order->payment_reference = $transaction_id;
                $order->save();

                $orderPayment = new Order_payment();

                $orderPayment->order_id = $order->id;
                $orderPayment->payment_gateway_id = $order->payment_gateway_id;
                $orderPayment->amount = $transaction_amount;
                $orderPayment->user_id = $order->user_id;
                $orderPayment->transaction_code = $transaction_id;
                $orderPayment->merchant_ref = $business_code;
                $orderPayment->transaction_date = date('Y-m-d H:i:s');

                $orderPayment->save();

                $message = "Payment of ".$transaction_amount." has been received successfully for the customer, number ".$msisdn."";

                $outbox = new Outbox();

                $outbox->msisdn = "254741549531";
                $outbox->message = $message;
                $outbox->status = 0;

                $outbox->save();
            }
        }

        echo '{"ResultCode": 0, "ResultDesc": "Accepted"}';

    }


    public function ipay(Request $request){

        // $postData = file_get_contents('php://input');

        $id = $request->id;
        $txncd  = $request->txncd;
        $status = $request->status;
        $ivm = $request->ivm;
        $qwh = $request->qwh;
        $afd = $request->afd;
        $poi = $request->poi;
        $uyt = $request->uyt;
        $ifd = $request->ifd;
        $agt = $request->agt;
        $mc = $request->mc;
        $p1 = $request->p1;
        $p2 = $request->p2;
        $p3 = $request->p3;
        $p4 = $request->p4;
        $msisdn_id = $request->msisdn_id;
        $msisdn_idnum = $request->msisdn_idnum;

        $postData = $id." param: ".$txncd." param: ".$status." param: 
            ".$ivm." param: ".$qwh." param: ".$afd." param: 
            ".$poi." param: ".$uyt." param: ".$ifd." param: ".$agt." param: 
            ".$mc." param: ".$p1." param: ".$p2." param: ".$p3." param: 
            ".$p4." param: ".$msisdn_id." param: ".$msisdn_idnum;

        $file = fopen("/var/www/html/dil/storage/logs/ipay.log", "w"); 

        if(fwrite($file, $postData) === FALSE)
        {
            fwrite($file, "Error: no data written");
        }

        $iPayTransactionLog = new IPayTransactionLog();

        $iPayTransactionLog->ipay_id = $id;
        $iPayTransactionLog->transaction_code = $txncd;
        $iPayTransactionLog->status = $status;
        $iPayTransactionLog->invoice_hashed = $ivm;
        $iPayTransactionLog->browser_id_qwh = $qwh;
        $iPayTransactionLog->browser_id_afd = $afd;
        $iPayTransactionLog->browser_id_poi = $poi;
        $iPayTransactionLog->browser_id_uyt = $uyt;
        $iPayTransactionLog->browser_id_ifd = $ifd;
        $iPayTransactionLog->browser_id_agt = $agt;
        $iPayTransactionLog->amount_sent = $mc;
        $iPayTransactionLog->custom_p1 = $p1;
        $iPayTransactionLog->custom_p2 = $p2;
        $iPayTransactionLog->custom_p3 = $p3;
        $iPayTransactionLog->custom_p4 = $p4;
        $iPayTransactionLog->customer_name = $msisdn_id;
        $iPayTransactionLog->msisdn = $msisdn_idnum;

        $iPayTransactionLog->save();

        $order_id = $p1;
        $order = Order::find($order_id);

        if($status == "aei7p7yrx4ae34"){ 

            $order->order_status = "CONFIRMED";
            $order->payment_status = "PAID"; 
        }
        elseif($status == "dtfi4p7yty45wq ") { 

            $order->order_status = "CONFIRMED";
            $order->payment_status = "PARTIALLY_PAID"; 
        }

        $order->save();

        $user_id = $order->user_id;
        $user = User::findorfail($user_id);

        if($user->phone != null){

            $phone = trim($user->phone);

            if(substr($phone, 0, 4) != "+254") {

                if(substr($phone, 0, 1) == "0"){

                    $phone = "+254".substr($phone, 1, 9);
                }elseif(substr($phone, 0, 1) == "7"){

                    $phone = "+254".$phone;

                }
            }

            $message = "Thank you for choosing DIL.AFRICA. We thank you for placing an order with us. Our Customer Service will be in touch with you shortly to confirm the order.";

            $outbox = new Outbox();
            $outbox->order_id = $order_id;
            $outbox->user_id = $order->user_id;

            $outbox->msisdn = $phone;
            $outbox->message = $message;
            $outbox->status = 0;

            $outbox->save();
        }

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Your payment has been received successfully. Thank you.');

        return view('modules/customer/checkout/complete_transaction',
                compact("order", 'order_id'));
    }

    public function pay_by_ipay($order_id){

        $order = Order::findorfail($order_id);
        $user = User::find($order->user_id);

        return view('modules/customer/checkout/ipay',
                compact('order', 'order_id', 'user'));
    }


    public function replaceExtraSpaces(){

        $products = Product::get();
        $brands = Brand::get();
        $categories = Category::get();

        foreach ($products as $product) {
            
            $prod_name = preg_replace('!\s+!', ' ', trim($product->name));
            $author = preg_replace('!\s+!', ' ', trim($product->author));
            $publisher = preg_replace('!\s+!', ' ', trim($product->publisher));

            $product->name = $prod_name;
            $product->author = $author;
            $product->publisher = $publisher;

            $product->save();
        }

        foreach ($brands as $brand) {
            
            $brand_name = preg_replace('!\s+!', ' ', trim($brand->name));

            $brand->name = $brand_name; 
            $brand->save();
        }

        foreach ($categories as $category) {
            
            $category_name = preg_replace('!\s+!', ' ', trim($category->name));
            $category->name = $category_name; 
            $category->save();
        }

        echo "Names updated successfully";

    }

    public function updateErroneousProductPrices(){

        $productPrices = Product_price::get();
        $count = 0;

        foreach ($productPrices as $priceNow) {
            $idNow = $priceNow->id;

            $oldPrice = Product_price_old::where('id', $idNow)->first();
            if($oldPrice != null){

                $priceNow->offer_price = $oldPrice->offer_price;
                $priceNow->standard_price = $oldPrice->standard_price;
                $priceNow->save();
                $count++;
            }

        }

        echo $count.' records updated successfully';
    }


    public function test_generate_credential(){

        echo Utilities::mpesaEncryptSecurityCredentials();
    }


    public  function  display_shop($slug)
    {

        $shop= Seller::where('username',$slug)->firstorfail();

         $products= Product::where(['seller_id'=>$shop->id,'publish_status'=>1])->OrderBy('created_at','DESC')->paginate(12);

              return view('customer::shop.details',
                compact('products','shop'));

    }
      
}