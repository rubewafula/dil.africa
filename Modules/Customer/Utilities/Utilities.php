<?php

namespace Modules\Customer\Utilities;

use Auth;
use Modules\Customer\Entities\Product;
use Modules\Customer\Entities\Product_price;
use Modules\Customer\Entities\Product_image;
use Modules\Customer\Entities\Cart_session;
use Modules\Customer\Entities\User;
use Modules\Customer\Entities\Order;
use Modules\Customer\Entities\Seller;
use Modules\Customer\Entities\Order_detail;
use Modules\Customer\Entities\Seller_order;
use Modules\Customer\Entities\Delivery_timeline;
use Modules\Customer\Entities\Category;
use Modules\Customer\Entities\Voucher;
use Modules\Customer\Entities\Shipping_price;
use Modules\Customer\Entities\Shipping_type;
use Modules\Customer\Entities\Special_shipping_rate;
use Modules\Customer\Entities\Outbox;

use Modules\Customer\Notifications\OrderNotification;
use Modules\Customer\Notifications\AdminOrderNotification;

use Modules\Customer\Entities\AfricasTalkingGateway;

use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Flash_sale;

use Session;
use \Datetime;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Cache;

use Mpesa;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilities
 *
 * @author antonio
 */
class Utilities {

    //put your code here

    public function getTimeDifferenceInDays($startdate, $enddate) {

        $datetime1 = strtotime($startdate);
        $datetime2 = strtotime($enddate);

        $secs = $datetime2 - $datetime1; // == <seconds between the two times>
        $days = $secs / 86400;

        return floor($days);
    }

    public static function getMainCategoriesLimited(){

         if(Cache::has('main_categories_limited')) {

            $categories = Cache::get('main_categories_limited');

        }else{

            $categories = Category::where('status', 1)
            ->where('level', 1)->orderBy('priority')->limit(8)->get();

            $minutes = 60;

            Cache::add('main_categories_limited', $categories, $minutes);
        }
        
        return $categories;
    }

    public static function getMainCategoriesAll(){

         if(Cache::has('main_categories_all')) {

            $categories = Cache::get('main_categories_all');

        }else{

            $categories = Category::where('status', 1)
            ->where('level', 1)->orderBy('priority')->get();

            $minutes = 60;

            Cache::add('main_categories_all', $categories, $minutes);
        }
        
        return $categories;
    }
    
    public static function addHours($startdate, $hours) {

        $datetime = strtotime($startdate);

        $secs = $hours * 3600; // == <seconds between the two times>
        $new_datetime = $datetime + $secs;

        return date('Y-m-d H:i:s', $new_datetime);
    }
    
    public static function saveOrder($userId, $total_value, $shipping_cost, 
            $transaction_cost, $user_address_id, $gateway, $payment_status, 
            $delivery_type=null) {
        
        $order_ref =  Order::latest()->first();
        $order_reference = 0;
        if($order_ref != null){

            $order_reference = $order_ref->order_reference + 1;
        }else{
            $order_reference = $order_reference + 1;
        }

        $user = User::find($userId);
        $email = $user->email;
        
        $token = bin2hex(random_bytes(10)).rand(10000000,500000000).bin2hex(random_bytes(10));

        $order = new Order();   

        $order->user_id = $userId;
        $order->total_value = $total_value;

        $voucher = Session::get('voucher_type');

        if($voucher != null){
            
            $order->voucher_code = Session::get('voucher_code');

            if($voucher == 'AMOUNT'){
                $order->voucher_amount = Session::get('voucher_amount');
            }
            elseif($voucher == 'PERCENT_DISCOUNT'){
                $percent = Session::get('voucher_percent');
                $amount_to_deduct = $total_value * ($percent/100);
                $order->voucher_amount = round($amount_to_deduct, 2);
            }elseif($voucher == 'FREE_SHIPPING'){
                $shipping_cost = 0;
            }

            Voucher::where('voucher_code', Session::get('voucher_code'))->update(['status' => 0]);

        }

        if($delivery_type == null) {

            if(Session::get('delivery_type') == 'home_office_delivery')
            {
                $order->shipping_type_id = 2;

            }elseif(Session::get('delivery_type') == 'pickup'){

                $order->shipping_type_id = 1;
            }
        }else{

            if($delivery_type == 'home_office_delivery')
            {
                $order->shipping_type_id = 2;

            }else{

                $order->shipping_type_id = 1;
            }
        }

        $order_date = date('Y-m-d H:i:s');
        $date = new DateTime($order_date);
        $date->setTime(10, 00);

        $expected_delivery_time = "";

        if($order_date < $date->format('Y-m-d H:i:s')){

            $expected_date = new DateTime($order_date);
            $expected_date->setTime(16, 00);
            $expected_delivery_time = $expected_date->format('Y-m-d H:i:s');
        }else {
            $expected_date = new DateTime($order_date);
            $expected_date->modify('+1 day');
            $expected_date->setTime(9, 00);
            $expected_delivery_time = $expected_date->format('Y-m-d H:i:s');
        }


        $order->shipping_cost = $shipping_cost;
        $order->transaction_cost = $transaction_cost;
        $order->order_reference = $order_reference;
        $order->user_address_id = $user_address_id;
        $order->payment_gateway_id = $gateway;
        $order->payment_status = $payment_status;
        $order->email_address = $email;
        $order->confirmation_token= $token;
        $order->expected_delivery_time= $expected_delivery_time;

        $order->save();

        $order_id = $order->id;

        $cart_items = Session::get('cart_items');

        if($cart_items == null){ return redirect(url('/shop/cart')); }

        foreach ($cart_items as $cart_item){

            $order_detail = new Order_detail();
            $seller_order = new Seller_order();

            $product_price_id = $cart_item->getProductPriceId();
            $productPrice = Product_price::find($product_price_id);
            $product_id = $productPrice->product_id;
            $product = Product::find($product_id);
            $quantity = $cart_item->getQuantity();
            $price = $cart_item->getUnitPrice() - $product->getShippingCost();
            $status = "PROCESSING";

            if($product->getFlashPrice() != null){

                $order_detail->flash_sale_price = $price;

                $flash_sale = $product->getFlashPrice();

                $new_stock = $flash_sale->remaining_stock - 1;
                $flash_sale->remaining_stock = $new_stock;
                $flash_sale->save();

                if($new_stock == 0){

                    $flash_sale->status = 0;
                    $flash_sale->save();
                }
            }

            $order_detail->order_id = $order_id;
            $order_detail->product_id = $product_id;
            $order_detail->quantity = $quantity;

            if($productPrice->offer_price != null){
                $order_detail->price = $productPrice->offer_price;
            }else{
                $order_detail->price = $productPrice->standard_price;
            }
            
            $order_detail->product_price_id = $product_price_id;
            $order_detail->status = $status;

            $order_detail->save();

            $new_quantity = $productPrice->quantity - $quantity;
            $productPrice->quantity = $new_quantity;
            $productPrice->save();

            $order_detail_id = $order_detail->id;
            $seller_id = $product->seller_id;

            if($product->delivery_timeline_id != null) {

                $delivery_date = Utilities::addHours($order_date, 
                    Delivery_timeline::find($product->delivery_timeline_id)->hours);
            }else{

                $delivery_date = Utilities::addHours($order_date, 6);
            }   

            $seller_order->seller_id = $seller_id;
            $seller_order->order_detail_id = $order_detail_id;
            $seller_order->order_id = $order_id;
            $seller_order->order_reference = $order_reference;
            $seller_order->order_date = $order_date;
            $seller_order->delivery_due_date = $delivery_date;

            $seller_order->save();
                                
        }
        
        Session::forget('cart');
        Session::forget('cart_items');

        $admin = new User();
        $admin->email = 'orders@dil.africa';
        $admin->name = 'Admin';

        $user->notify(new OrderNotification($order, $user, $cart_items));
        $admin->notify(new AdminOrderNotification($order, $cart_items, $admin, $user));

        if($gateway != 4) {

            if($user->phone != null){

                $phone = trim($user->phone);

                if(substr($phone, 0, 4) != "+254") {

                    if(substr($phone, 0, 1) == "0"){

                        $phone = "+254".substr($phone, 1, 9);
                    }elseif(substr($phone, 0, 1) == "7"){

                        $phone = "+254".$phone;

                    }
                }

                if($gateway = 2)
                {

                    $grand_t =  $total_value +  $shipping_cost ;     
                    $message ="Thank you for placing your order on DIL.AFRICA. Please pay Ksh. ".$grand_t." to M-PESA PAYBILL 829726 .Use account number ".$order->order_reference." to complete your  transaction.For inquiries  call 0797522522 ";

                }else{

                    $message ="Thank you for choosing DIL.AFRICA. We thank you for placing an order with us. Our Customer Service will be in touch with you shortly to confirm the order.";
                }

                $outbox = new Outbox();
                $outbox->order_id = $order_id;
                $outbox->user_id = $userId;

                $outbox->msisdn = $phone;
                $outbox->message = $message;
                $outbox->status = 0;

                $outbox->save();
            }

        }
        return $order_id;
    }


    public function getCommission($product_id){

        $product = Product::findorfail($product_id);

        $category_id = $product->category_id;
        $category = Category::findorfail($category_id);

        $commission = 10;

        if($category != null){

            $commission = $category->percent_commission;
        }

        return $commission;

    }


    public function sendCustomerEmail($order, $user, $cart_items){
        
      $mailMessage = "";

      if($order->payment_gateway_id == 1){
          
          $mailMessage.'Dear '.$user->first_name.','
                .'<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">'
                .'Thank you for placing an order with DIL.AFRICA. Your order '.$order->order_reference.' has been placed and is pending confirmation. 
                If we need to confirm any information regarding your purchase, we will call you within 1 hour (calling hours: Mon-Fri 8am - 8pm; Sat-Sun 9am - 3pm) 
                or email you if you are not reachable. If you don\'t respond within 48 hours, we will cancel your order and notify you via email. Please note: 
                If you\'d like to change your order details (e.g recipient, delivery address), please contact us now at 0797 522522 or email us at customercare@dil.africa.
                 You will no longer be able to change them at a later stage. Please Click on the "Confirm Order" button below to confirm your order.<br/>'
                .'<a href="'.url('shop/confirm-order/'.$order->confirmation_token).'">Confirm Order</a>'
                .'</div>';
      }
      else{

         $mailMessage.'Dear '.$user->first_name.','
                .'<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">'
                .'Thank you for placing an order with DIL.AFRICA. Your order '.$order->order_reference.' has been placed and is pending confirmation. 
                If we need to confirm any information regarding your purchase, we will call you within 1 hour (calling hours: Mon-Fri 8am - 8pm; Sat-Sun 9am - 3pm) 
                or email you if you are not reachable. If you don\'t respond within 48 hours, we will cancel your order and notify you via email. Please note: 
                If you\'d like to change your order details (e.g recipient, delivery address), please contact us now at 0797 522522 or email us at customercare@dil.africa.
                 You will no longer be able to change them at a later stage. Please Click on the "Confirm Order" button below to confirm your order.<br/>'
                .'<a href="'.url('shop/track-order').'">Check Order</a>'
                .'</div>';
        }

        $order_amount = 0;
        $delivery_selection = Session::get('delivery_type');
        $userId = Session::get('userId'); 
        $delivery_mode = "";
        $drop_location = "";
        $user_address = null;
        $address = "";
        $city = "";
        $country = "";

        if($delivery_selection =='home_office_delivery')
        {
            $delivery_mode = "Home / Office Delivery";
            $user_address = User_address::where('user_id', $userId)
                        ->where('default', 1)->first();

            if($user_address == null) { 

              $user_address = User_address::where('user_id', $userId)->first();  
            }
            
            $city = City::find($user_address->city_id)->name;
            $country = Country::find($user_address->country_id)->name;
            $address = $user_address->building.", ".$user_address->floor.', '.$user_address->street.', '.$city.', '.$country;

        }elseif($delivery_selection =='pickup'){
             $delivery_mode = "Pickup";
             $user_address = User_pickup_location::where('user_id',
                        $userId)->where('default', 1)->first();
             $warehouse = Warehouse::find($user_address->warehouse_id);
             $address = $warehouse->name.', '.Area::find($warehouse->area_id)->name; 
        }

        $cart_table = "";
        foreach ($this->cart_items as $cart_item){

            $order_amount += $cart_item->getSubtotal();
            $cart_table = $cart_table.'<tr><td style="border-bottom:1px solid #eee;">'.$cart_item->getProductName().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getUnitPrice()).'</td><td style="border-bottom:1px solid #eee;">'.$cart_item->getQuantity().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getSubtotal()).'</td></tr>';
        }

        $grand_total_cost = $order_amount;

        $shipping_cost = $this->order->shipping_cost;

        if($shipping_cost == 0){

            $shipping_cost = "-";
        }else {

            $grand_total_cost = $order_amount + $shipping_cost;
            $shipping_cost = number_format($shipping_cost);
        }

        $transaction_cost = $this->order->transaction_cost;

        if($transaction_cost == 0){

            $transaction_cost = "-";
        }else {

            $grand_total_cost = $order_amount + $transaction_cost;
            $transaction_cost = number_format($transaction_cost);
        }

        $mailMessage.'<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">'
            .'<span style="font-weight:bold;color:#0f7dc2;">Your order details are as below:</span><br/>'
            .'<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr><td style="background:#eee;color:#0f7dc2;">Order Reference:</td><td style="border-bottom:1px solid #eee;">'.$order->order_reference.'</td></tr>'
            .'<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Your Name:</td><td style="border-bottom:1px solid #eee;">'.ucfirst($this->user->first_name).' '.ucfirst($user->last_name).'</td></tr>'
            .'<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Email Address:</td><td style="border-bottom:1px solid #eee;">'.$this->user->email.'</td></tr>'
            .'<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Phone Number:</td><td style="border-bottom:1px solid #eee;">'.$this->user->phone.'</td></tr>'
            .'<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Mode of Delivery:</td><td style="border-bottom:1px solid #eee;">'.$delivery_mode.'</td></tr>'
            .'<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Dropping / Delivery Location:</td><td>'.$address.'</td></tr>'
             .'</table><br/>'
            .'<span style="font-weight:bold;font-size:13px;color:#0f7dc2;">Items Ordered</span>'
            .'<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr style="background:#eee;"><td style="border:1px solid #eee;color:#0f7dc2;">Item</td><td style="border:1px solid #eee;color:#0f7dc2;">Unit Price</td><td style="border:1px solid #eee;color:#0f7dc2;">Quantity</td><td style="border:1px solid #eee;color:#0f7dc2;">Total Price</td></tr>'
            .$cart_table
            .'<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Shipping Cost</td><td>'.$shipping_cost.'</td></tr>'
            .'<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Transaction Cost</td><td>'.$transaction_cost.'</td></tr>'
            .'<tr style="background:#0f7dc2;color:#FFF;"><td colspan="3">Grand Total</td><td>'.number_format($grand_total_cost).'</td></tr>'
            .'</table><br/>'
            .'We hope that you will enjoy our experience and we thank you once more for shopping with us!'
            .'</div><br/><br/>';

            return $mailMessage;
    }

    public static function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function getIpSessionTotalCartPrice() {

        $total_price = 0;
        if (Auth::user() != null) {

            $user_sessions = Cart_session::where('user_id', Auth::user()->id)->get();
        } else {

            $ip_address = Utilities::getRealIpAddr();
            $user_sessions = Cart_session::where('ip_address', $ip_address)->get();
        }

        foreach ($user_sessions as $session) {

            $product_price_id = $session->product_price_id;

            $productPrice = Product_price::find($product_price_id);

            if($productPrice == null){

                continue;
            } 

            $price = $productPrice->offer_price;

            if ($price == null) {

                $price = $productPrice->standard_price;
            }
            $total_price += $price;
        }

        return $total_price;
    }
    
    public static function getCustomerTotalCartPrice() {

        $total_price = 0;

        $cart = Session::get('cart');
        
        if($cart != null){
            
            foreach ($cart as $session) {

                $product_price_id = $session->getProductPriceId();
                $quantity = $session->getQuantity();

                if(!is_numeric($quantity)){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message_error', 'Invalid value for quantity encountered');

                    return redirect('/shop/cart');
                }

                $productPrice = Product_price::find($product_price_id);

                if($productPrice == null){

                    continue;
                } 

                $product_id = $productPrice->product_id;
                $product = Product::findorfail($product_id);   

                if($product->getFlashPrice() != null){

                    $price = $product->getFlashPrice()->offer_price;
                }
                else{

                    $price = $productPrice->offer_price;
                }

                if ($price == null) {

                    $price = $productPrice->standard_price;
                }

                $shipping_cost = $product->getShippingCost();

                $price = $price + $shipping_cost;

                $total_price += ($price * $quantity);
            }
        }

        return $total_price;
    }


    public static function getCustomerTotalCartPriceNoShipping() {

        $total_price = 0;

        $cart = Session::get('cart');
        
        if($cart != null){
            
            foreach ($cart as $session) {

                $product_price_id = $session->getProductPriceId();
                $quantity = $session->getQuantity();

                if(!is_numeric($quantity)){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message_error', 'Invalid value for quantity encountered');

                    return redirect('/shop/cart');
                }

                $productPrice = Product_price::find($product_price_id);

                if($productPrice == null){

                    continue;
                } 

                $product_id = $productPrice->product_id;
                $product = Product::findorfail($product_id);   

                if($product->getFlashPrice() != null){

                    $price = $product->getFlashPrice()->offer_price;
                }
                else{

                    $price = $productPrice->offer_price;
                }

                if ($price == null) {

                    $price = $productPrice->standard_price;
                }

                $total_price += ($price * $quantity);
            }
        }

        return $total_price;
    }
    
    
    public static function getCustomerTotalCartItems() {

        $quantity = 0;

        $cart = Session::get('cart');
        
        if ($cart != null) {

            $quantity = count($cart);
        }
        return $quantity;
    }

    public static function userExists($email) {

        $user = User::where('email', $email)->first();

        if ($user != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCartItems($userId) {

        if ($userId != 0) {

            $user_sessions = Cart_session::where('user_id', $userId)->get();
            
            if(count($user_sessions) == 0){
                $ip_address = Utilities::getRealIpAddr();
                $user_sessions = Cart_session::where('ip_address', $ip_address)->get();
            }
        } else {

            $ip_address = Utilities::getRealIpAddr();
            $user_sessions = Cart_session::where('ip_address', $ip_address)->get();
        }
        
        $cart_items = [];

        if (count($user_sessions) > 0) {

            foreach ($user_sessions as $session) {

                $quantity = $session->quantity;
                $product_price_id = $session->product_price_id;
                $productPrice = Product_price::find($product_price_id);
                $price = $productPrice->offer_price;

                if ($price == null) {

                    $price = $productPrice->standard_price;
                }

                $product_id = $productPrice->product_id;
                $product = Product::find($product_id);

                $seller = Seller::find($product->seller_id)->name;
                $product_image = Product_image::where('product_id', $product_id)
                                ->where('default', 1)->limit(1)->first()->image_url;
                $product_name = $product->name;
                $subtotal = $price * $quantity;

                $session_id = $session->id;

                $cartItem = new CartItem($product_price_id, $quantity, $seller,
                        $product_image, $product_name, $price, $subtotal, $session_id);

                array_push($cart_items, $cartItem);
            }

        }
        return $cart_items;
    }
    
    
    public function  getPopularCategories(){
        
        return Category::where('is_popular', 1)->limit(3)->get();
    }


    public static function getCartProductsIds(){

        $cart = Session::get('cart');
        $product_ids = [];

        foreach ($cart as $item) {
            
            array_push($product_ids, Product_price::find($item->getProductPriceId())->product_id);
        }

        return $product_ids;
    }


    public static function getCartCategoriesIds(){

        $cart = Session::get('cart');
        $categories_ids = [];

        foreach ($cart as $item) {
            
            $product_price_id = $item->getProductPriceId();
            $product = Product::find(Product_price::find($product_price_id)->product_id);
            $category_id = $product->category_id;

            array_push($categories_ids, $category_id);
            $category_has_childs = Utilities::categoryHasChilds($category_id);
            
            if($category_has_childs == TRUE){

                $ids_in_child = Utilities::getChildCategoriesIds($category_id);
                $categories_ids = array_merge($categories_ids, $ids_in_child);

                $returnedArray = $categories_ids;

                while(count($returnedArray) > 0){

                    $returnedArray = Utilities::getAllChildCategoriesIds($returnedArray);
                    $categories_ids = array_merge($categories_ids, $returnedArray);
                }
            }
        }
        return array_unique($categories_ids);
    }


    public static function getChildCategoriesIds($category_id){

        $categories_ids = [];
        $immediateChilds = Category::where('depends_on', $category_id)->get();
        if(count($immediateChilds) > 0){

            foreach ($immediateChilds as $child) {

                array_push($categories_ids, $child->id);
            }
        }

        return $categories_ids;
    }


    public static function getShippingChildCategoriesIds($category_id){

        $categories_ids = [];

        $immediateChilds = Category::where(function($query) use ($category_id) {
                
            $query->where('slug', '!=', 'tvs')
                ->orWhere('slug', '!=', 'large-appliances');
            })->where('depends_on', $category_id)->get();

        if(count($immediateChilds) > 0){

            foreach ($immediateChilds as $child) {

                array_push($categories_ids, $child->id);
            }
        }

        return $categories_ids;
    }


    public static function categoryHasChilds($category_id){

        return (count(Category::where('depends_on', $category_id)->get()) > 0);
    }


    public static function getAllChildCategoriesIds($ids){

        $categories_ids = [];

        foreach ($ids as $id) {

            $immediateChilds = Category::where('depends_on', $id)->get();
            if(count($immediateChilds) > 0){

                foreach ($immediateChilds as $child) {

                    array_push($categories_ids, $child->id);
                }

            }
        }
        
        return $categories_ids;
    }


    public static function getAllChildrenCategoriesIdsIncludingSelf($category_id){

        $categories_ids = [];
        array_push($categories_ids, $category_id);
            
        $category_has_childs = Utilities::categoryHasChilds($category_id);
            
        if($category_has_childs == TRUE){

            $ids_in_child = Utilities::getChildCategoriesIds($category_id);
            $categories_ids = array_merge($categories_ids, $ids_in_child);

            $returnedArray = $categories_ids;

            while(count($returnedArray) > 0){

                $returnedArray = Utilities::getAllChildCategoriesIds($returnedArray);
                $categories_ids = array_merge($categories_ids, $returnedArray);
            }
        }
        return array_unique($categories_ids);
    }
    

    public static function getSpecialShippingRate(){

        return $special_price = Special_shipping_rate::where('status', 1)->first();
    }

    public static function getSpecialShippingMessage($sale_price){

        if($sale_price >= 20000){

            return 'Free Shipping Countrywide!!';
        }

        $special_price = Special_shipping_rate::where('status', 1)
            ->where('order_amount', '<=', $sale_price)->first();
            
        if($special_price != null) {

            if($special_price->amount_charged == 0){
                return 'Eligible for Free Shipping';                 
            } elseif($special_price->amount_charged > 0){
                return 'Eligible for Discounted Shipping Cost';
            }
            return '';
        }
        return '';
    }


    public static function getShippingCost($city_id){

        $shipping_cost = 0;
        $items = Session::get('cart');

        $order_value = Session::get('order_value');

        $special_price = Special_shipping_rate::where('city_id', $city_id)
            ->where('status', 1)->first();

        if($special_price != null){

            if($special_price->order_amount < $order_value){

                return $special_price->amount_charged;
            }
        }

        $tv_id = null;
        $appliances_id = null;

        $tv_category = Category::where('slug', 'tvs')->first();
        $appliances_category = Category::where('slug', 'large-appliances')->first();

        if($tv_category != null){

            $tv_id = $tv_category->id;
        }
        if($appliances_category != null){

            $appliances_id = $appliances_category->id;
        }


        if($items != null){

            foreach ($items as $item) {
                
                $product_price = Product_price::find($item->getProductPriceId());

                if($product_price->offer_price > 20000){

                    continue;
                    
                }elseif($product_price->standard_price > 20000) {
                    
                    continue;
                }

                $category_id = $product_price->product->category_id;

                if($category_id != null){

                     $shipping_type_id = 0;

                    if(Session::get('delivery_type')  =='home_office_delivery'){

                        $shipping_type = Shipping_type::where('name', 'Home/Office Delivery')
                            ->first();

                        if($shipping_type != null){

                            $shipping_type_id = $shipping_type->id;
                        }
                    }elseif(Session::get('delivery_type')  =='pickup'){

                        $shipping_type = Shipping_type::where('name', 'Pick up Stations')
                            ->first();

                        if($shipping_type != null){

                            $shipping_type_id = $shipping_type->id;
                        }
                    }

                    $shippingPrice = Shipping_price::where('city_id', $city_id)
                        ->where('shipping_type_id', $shipping_type_id)
                            ->where('category_id', $category_id)->first();

                    if($shippingPrice == null){

                        $shippingPrice = Shipping_price::where( function($query) 
                            use ($tv_id, $category_id){

                            $query->where('category_id', '!=', $tv_id)
                            ->where('category_id', '!=', $category_id);

                        })->where('city_id', $city_id)
                         ->where('shipping_type_id', $shipping_type_id)->first();
                    }

                    if($shippingPrice != null){

                        $no_of_items = $item->getQuantity();

                        if($no_of_items > 1){

                            $shipping_cost = $shippingPrice->price_many;
                        }else{

                            $shipping_cost = $shippingPrice->price_one;
                        }
                    }
                }
                    
            }
        }

        return $shipping_cost;
    }

    public static function getHiddenShippingCost(){

        $items = Session::get('cart');
        $hidden_cost = 0;

        if($items != null){

            foreach ($items as $item) {

                $product_price = Product_price::findorfail($item->getProductPriceId());

                $product = Product::findorfail($product_price->product_id);

                $hidden_cost += $product->getShippingCost();
            }

            return $hidden_cost;
        }

        return 400;

    }


    public static function getShippingCostGeneric($city_id){

        $shipping_cost = 0;
        $items = Session::get('cart');
        $order_value = Session::get('order_value');

        //TO DO: Take care of item sizes later

        $special_price = Special_shipping_rate::where('city_id', $city_id)
            ->where('status', 1)->first();

        if($special_price != null){

            if($special_price->order_amount < $order_value){

                return $special_price->amount_charged;
            }
        }

        if($items != null){

            foreach ($items as $item) {
                
                $product_price = Product_price::find($item->getProductPriceId());

                $category_id = $product_price->product->category_id;

                $slug = $product_price->product->category->slug;

                if($category_id != null){

                     $shipping_type_id = 0;

                    if(Session::get('delivery_type')  =='home_office_delivery'){

                        $shipping_type = Shipping_type::where('name', 'Home/Office Delivery')->first();

                        if($shipping_type != null){

                            $shipping_type_id = $shipping_type->id;
                        }
                    }elseif(Session::get('delivery_type')  =='pickup'){

                        $shipping_type = Shipping_type::where('name', 'Pick up Stations')->first();

                        if($shipping_type != null){

                            $shipping_type_id = $shipping_type->id;
                        }
                    }

                    $shippingPrice = Shipping_price::where('city_id', $city_id)
                        ->where('shipping_type_id', $shipping_type_id)
                            ->where('category_id', $category_id)->first();

                    if($shippingPrice != null){

                        $no_of_items = $item->getQuantity();

                        if($no_of_items > 1){

                            $shipping_cost = $shippingPrice->price_many;
                        }else{

                            $shipping_cost = $shippingPrice->price_one;
                        }
                    }
                }
                    
            }
        }

        return $shipping_cost;
    }


    public static function sendSMS($recipients, $message){

        $username   = "anjoroge_DIL";
        $apikey  = "1844a17f33e32617249aecd038ae288fb77bd93ca581c6a2a30ffb8c6a7e3206";

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


    public static function getActivePrice($product_id){

        return DB::select("SELECT * FROM product_prices WHERE
         product_id = '".$product_id."' AND is_default = 1 AND `status` = 1
          ORDER BY id DESC");
    }


    public static function getCountryCityByIp($ip_address){

        /*Get user ip address details with geoplugin.net*/

        $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;

        $addrDetailsArr = unserialize(file_get_contents($geopluginURL));

        $city = $addrDetailsArr['geoplugin_city'];

        $country = $addrDetailsArr['geoplugin_countryName'];

        if(!$city){
            $city='Unknown';
        }if(!$country){
            $country ='Unknown';
        }

        return $country.' - '.$city;
    }


    public static function isEligibleForCashPayment($cityName){

        $order_total = 0;

        if($cityName != 'Nairobi'){

            return "not-nairobi";
        }

        $cart = Session::get('cart_items');

        foreach ($cart as $item) {
            
            $order_total += $item->getSubtotal();
            $product_price_id = $item->getProductPriceId();
            $product = Product::find(Product_price::find($product_price_id)->product_id);
            $category_slug = $product->category->slug;

            if($category_slug == 'fridges-freezers' || $category_slug == 'washers-dryers'){

                return "bulky";
            }
        }

        if($order_total >= 50000){

            return "huge-total";
        }

        return 1;
    }


    public static function getOrderTotalPrice(){

        $order_total = 0;
        $cart = Session::get('cart_items');

        foreach ($cart as $item) {
            
            $order_total += $item->getSubtotal();

        }

        return $order_total;

    }


    public static function getDefaultImage($product_id){
        
        $image = DB::select("SELECT * FROM product_images WHERE 
            product_id = '".$product_id."' AND `default` = 1 LIMIT 1");

        if($image == null){
            
            $image =  DB::select("SELECT * FROM product_images WHERE 
            product_id = '".$product_id."' LIMIT 1");
        }
        
        return $image;
    }


    public static function hasDifferentPrices($product_id){
        
        $allprices = DB::select("SELECT * FROM product_prices WHERE
         product_id = '".$product_id."' AND is_default = 1 AND `status` = 1
          ORDER BY id DESC");
    
        $first_relevant_price = 0;
        $first_standard_price = ($allprices[0] != null)?$allprices[0]->standard_price:0;
        $first_offer_price = ($allprices[0]!= null)?$allprices[0]->offer_price:0;

        if($first_offer_price != null && $first_offer_price != 0){
            $first_relevant_price = $first_offer_price;
        }else {
            $first_relevant_price = $first_standard_price;
        }

        foreach ($allprices as $price) {

            $standard_price = $price->standard_price;
            $offer_price = $price->offer_price;
            $relevant_price = 0;

            if($offer_price != null && $offer_price != 0){

                $relevant_price = $offer_price;
            }else {
                $relevant_price = $standard_price;
            }

            if($first_relevant_price != $relevant_price){return true;}
        }
    }


    public static function getMaximumPrice($product_id) {
        
        $allprices = DB::select("SELECT * FROM product_prices WHERE
         product_id = '".$product_id."' AND is_default = 1 AND `status` = 1
          ORDER BY id DESC");
        
        $prices = [];

        foreach ($allprices as $price) {
            
            $standard_price = $price->standard_price;
            $offer_price = $price->offer_price;

            if($standard_price > 0) {array_push($prices, $standard_price);}
            if($offer_price > 0) {array_push($prices, $offer_price);}
            
        }

        return max($prices);
    }


    public static function getMinimumPrice($product_id){
        
        $allprices = DB::select("SELECT * FROM product_prices WHERE
         product_id = '".$product_id."' AND is_default = 1 AND `status` = 1
          ORDER BY id DESC");
        
        $prices = [];

        foreach ($allprices as $price) {
            
            $standard_price = $price->standard_price;
            $offer_price = $price->offer_price;

            if($standard_price > 0) {array_push($prices, $standard_price);}
            if($offer_price > 0) { 
                array_push($prices, $offer_price);
            }
            
        }

        return min($prices);
    }

    public static function product_features($product_id){

        $product_features = DB::select("SELECT * FROM product_features WHERE
         product_id = '".$product_id."'");
    }


    public static function generateMPESAOAuthToken(){

        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $consumer_key = "5ce4m2w5DpypV2vTaxAieZKHxSnf90PZ";
        $consumer_secret = "qfeF2JoVgI5MAyR4";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key.':'.$consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        return json_decode($curl_response, true);
    }

    public static function mPESARegisterConfirmURL(){

        Log::info(" Calling MPESA Register Confirm");

        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $curl_post_data = array(

          'ShortCode' => '829726',
          'ResponseType' => 'Completed',
          'ConfirmationURL' => 'https://dil.africa/shop/mpesa/c2b/confirm',
          'ValidationURL' => 'https://dil.africa/shop/mpesa/c2b/validate'
        );

        $data_string = json_encode($curl_post_data);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer clr9eF6kx17kcC7A6E1kZHItUyfC')); //setting custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        Log::info("Got response from the curl MPESA");

        $curl_response = curl_exec($curl);

        $json_response = json_decode($curl_response);

        $file = fopen("/var/www/html/dil/storage/logs/mpesa.log", "w"); 

        if(fwrite($file, $json_response) === FALSE)
        {
            fwrite($file, "Error: no data written");
        }

        fwrite($file, "\r\n");
        fclose($file);

        return $json_response;
    }

    public static function mpesaEncryptSecurityCredentials(){

        $publicKey = file_get_contents("C:/xampp/htdocs/dil/public/cert.cer", true);
        $plaintext = "AT874Lg0JtEMYIjqGJhaXKXSvmoahlbl0cjXyxce3LqO+D7aEi00JEsAtD6Abj9aNLv2i1+D2+1mLtUPlJ4blFH8E29Z+8nlFFyPlxga6vtIcvr/mUik1mJL/DgHd6ooZjaAKaBzrsav4yQ/3W+a1L/iSMrNFIXhP+SRTs+jIery8iRG9ZfpDVE3CVufsGM4OVofUiTwQJntft14X4fP56+GWfJfD/eWATlxJSI75vYNoy1np1Ussjxd13TLhCUpWcgCeqCAdhbxxAGdQjOoliYAQCmaP34UsIHPH0wDzZpybORNaoJr+yk0QqUX11SIhxmi72Iy+9mJgVdsjKghIw==";

        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }


    public static function mpesaGenerateSTKPassword(){

        $shortCode = '731029';
        $passKey = 'bc9a331469b31711b216c1238810b8e0489c8f27280f74310f080aa19530c2d8';
        $timestamp = '20190613142340';

        return base64_encode($shortCode.$passKey.$timestamp);
    }


    public static function prepareMSISDN($phone){

        if(substr($phone, 0,4) == "+254"){
            
            return substr($phone, 1, strlen($phone));
        }
        if(substr($phone, 0,1) == "7"){

            return "254".$phone;
        }
        if(substr($phone, 0,1) == "0"){

            return "254".substr($phone, 1, strlen($phone));
        }
    }


    public static function lipaNaMPESAOnlineSTK($order_id){

        $order = Order::findorfail($order_id);

        $user = Auth::user();

        $shortCode = '174379';
        $callBack = "https://dil.africa/shop/mpesa/callback";

        $access_token = "yhAAymATVkarc9M0sOeGLGjhcXVz";

        $order_amount = $order->total_value + $order->shipping_cost + $order->transaction_cost;

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$access_token)); //setting custom header

        $curl_post_data = array(
          
          'BusinessShortCode' => $shortCode,
          'Password' => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
          'Timestamp' => date('YmdHis'),
          'TransactionType' => 'CustomerPayBillOnline',
          'Amount"' => $order_amount,
          'PartyA' => Utilities::prepareMSISDN($user->phone),
          'PartyB' => $shortCode,
          'PhoneNumber' => Utilities::prepareMSISDN($user->phone),
          'CallBackURL' => $callBack,
          'AccountReference' => $order->order_reference,
          'TransactionDesc' => 'Customer Payment for Order at DIL.AFRICA'
        );

        $data_string = json_encode($curl_post_data);

        Log::info(" Calling MPESA ");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        // curl_setopt($curl, CURLOPT_HEADER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        Log::info(" Read Response from MPESA ".print_r($curl_response, true));

        file_put_contents('/var/www/html/dil/storage/logs/mpesa.log', print_r($curl_response, true));

        return $curl_response;

    }

    public static function lipaNaMPESAOnlineSTKSummarized($order_id){

        $order = Order::findorfail($order_id);
        $order_amount = $order->total_value + $order->shipping_cost + $order->transaction_cost;

        $user = Auth::user();

        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $BusinessShortCode ='174379';
        $LipaNaMpesaPasskey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = $order_amount;
        $PartyA = Utilities::prepareMSISDN($user->phone);
        $PartyB = '174379';
        $PhoneNumber = Utilities::prepareMSISDN($user->phone);
        $CallBackURL = "https://dil.africa/shop/mpesa/callback";
        $AccountReference = $order->order_reference;
        $TransactionDesc = 'Customer Payment for Order at DIL.AFRICA';
        $Remarks = 'STK Initiated for order payment';

        $stkPushSimulation = $mpesa->STKPushSimulation($BusinessShortCode, 
            $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, 
            $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, 
            $TransactionDesc, $Remarks);

        return $stkPushSimulation;
    }


    public static function upload_pickup_points_csv(){

        $row = 1;
        $uploaded = 0;
        $cities_not_found_count = 0;
        $cities_not_found = [];

        $city_name = null;
        $city_record = null;
        $pickup_name = null;
        $contact = null;

        if (($handle = fopen("/var/www/html/dil/g4s_pickup_missed.csv", "r")) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                
                echo "<p> Uploading record number $row</p>";
                $row++;

                $city_name = $data[0];
                $pickup_name = $data[1];
                $contact = $data[2];

                $city_record = City::where('name', $city_name)->first();

                if($city_record == null){

                    Log::info("Missed any town with the name ".$city_name);
                    array_push($cities_not_found, $city_record);
                    $cities_not_found_count++;
                    continue;
                }

                $created_at = date("Y-m-d H:i:s");
                $updated_at = date("Y-m-d H:i:s");
                $city_id = $city_record->id;
                $is_pickup = 1;
                
                $warehouse = new Warehouse();

                $warehouse->created_at = $created_at;
                $warehouse->updated_at = $updated_at;
                $warehouse->name = $pickup_name;
                $warehouse->contact_phone = $contact;
                $warehouse->city_id = $city_id;
                $warehouse->is_pickup_location = $is_pickup;

                $warehouse->save();

                $uploaded++;

                Log::info("Created ".$city_name." pickup point record");
            }
            fclose($handle);
            Log::info("Created ".$uploaded." pickup records in total");
            Log::info($cities_not_found_count." cities were not found in the database");
            Log::info("===============================================================");
            Log::info(print_r($cities_not_found, 1));
            Log::info("===============================================================");
        }
    }

}