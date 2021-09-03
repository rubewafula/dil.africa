<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Customer\Entities\Product_review;
use Modules\Customer\Entities\Default_shipping_price;

class Product extends Model
{
    //
    use SoftDeletes;
    public $table='products';

    public  $guarded= ['id'];

    public  $fillable=['name','product_code','seller_id','tax_class','size','weight',
    'main_material','author','publisher','product_description','highlight',
    'whats_inthe_box','product_warranty','care_label','youtube_id',
    'product_expiry','product_expiry_date','locally_made_products','
    publish_status','publish_date','category_id','slug','brand_id', 'model',
    'suspension_reason_id','item_size_id', 'keywords', 'product_measures',
     'submitted_by', 'qc_rejected_date'];

    protected $dates = ['deleted_at'];


public function  item_size()
{

	return  $this->BelongsTo('App\Item_size');
}

public function suspension_reason()
{

  return  $this->BelongsTo('App\Supension_reason');
}

    public function  seller()
    {

    	return  $this->BelongsTo('App\Seller');
    }


    public  function prices()
    {

    	return  $this->HasMany('App\Product_price');
    }


    public  function images()
    {

    	return $this->HasMany('App\Product_image');
    }


    public  function  category()
    {

        return   $this->BelongsTo('App\Category');
    }


    public  function  getStatusAttribute()
    {
       
       if($this->publish_status ==0)
       {
          return 'DRAFT';
       }

       if($this->publish_status == 1)
       {
          return  'PUBLISHED';
       }

       if($this->publish_status== 2)
       {

        return 'SUSPENDED';
       }
        if($this->publish_status== 3)
       {

        return 'UNPUBLISHED';
       }


    } 


    public  function  brand()
    {


        return  $this->BelongsTo('App\Brand');
    }


    public  function  order_details()
    {
      
      return  $this->HasMany('App\Order_detail');

    }

    public  function  categories()
    {

      return  $this->BelongsToMany('App\Category');
    }

  


    public  function  suspensions()
    {

      return  $this->HasMany('App\Product_suspension');
    }


    public  function  features()
    {
      return  $this->HasMany('App\Product_feature');
    }
    

    public function product_features()
    {
        return $this->HasMany('Modules\Customer\Entities\Product_feature');
    }


    public function getDefaultImage(){
        
        $image = Product_image::where("product_id", $this->id)
                ->where('default', 1)->first();

        if($image == null){
            
            $image = Product_image::where("product_id", $this->id)->first();
        }
        
        return $image;
    }
    
    public function getActivePrice(){
        
        $price = Product_price::where("product_id", $this->id)->where('is_default', 1)
                ->where('status', 1)->orderBy('id', 'DESC')->get();
        
        return $price;
    }


    public function hasDifferentPrices(){
        
        $allprices = Product_price::where("product_id", $this->id)->where('is_default', 1)
                ->where('status', 1)->orderBy('id', 'DESC')->get();
    
        $first_relevant_price = 0;
        $first_standard_price = ($allprices->first() != null)?$allprices->first()->standard_price:0;
        $first_offer_price = ($allprices->first()!= null)?$allprices->first()->offer_price:0;

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


    public function getMaximumPrice(){
        
        $allprices = Product_price::where("product_id", $this->id)->where('is_default', 1)
                ->where('status', 1)->orderBy('id', 'DESC')->get();
        
        $prices = [];

        foreach ($allprices as $price) {
            
            $standard_price = $price->standard_price;
            $offer_price = $price->offer_price;

            if($standard_price > 0) {array_push($prices, $standard_price);}
            if($offer_price > 0) {array_push($prices, $offer_price);}
            
        }

        return max($prices);
    }


    public function getMinimumPrice(){
        
        $allprices = Product_price::where("product_id", $this->id)->where('is_default', 1)
                ->where('status', 1)->orderBy('id', 'DESC')->get();
        
        $prices = [];

        foreach ($allprices as $price) {
            
            $standard_price = $price->standard_price;
            $offer_price = $price->offer_price;

            if($standard_price > 0) {array_push($prices, $standard_price);}
            if($offer_price > 0) {array_push($prices, $offer_price);}
            
        }

        return min($prices);
    }
    
    
    public function getProductReviews(){
        
        $reviews = Product_review::where("product_id", $this->id)
                ->orderBy('id', 'DESC')->get();
        
        return $reviews;
    }
    
    
    public function getLatestReview(){
        
        $review = Product_review::where("product_id", $this->id)
                ->orderBy('id', 'DESC')->first();
        
        return $review;
    }
    
    public function getProductImages(){
        
        $images = Product_image::where("product_id", $this->id)->get();
        
        return $images;
    }
    
    public function isAvailable(){
        
        $available = false;
        $stock = Product_price::where("product_id", $this->id)->sum('quantity');        
        
        if($stock > 0){
            
            $available = true;
        }
        return $available;
    }


    public function getAncestorCategory(){

        $category = Category::find($this->category->id);
        while($category->depends_on != null){

            $category = Category::find($category->depends_on);
        }
        return $category->id;
    }


    public function getShippingCost() {

        $price = $this->getActivePrice();

        if(count($price) > 0){

            if($price->first()->offer_price > 0 && $price->first()->offer_price < 20000){

                return 0;
                
            }elseif ( $price->first()->standard_price < 20000) {
                
                return 0;
            }
        }

        $price = $this->getMinimumPrice();

        if($price != null){

            if($price < 20000){

                return 0;
            }
        }

        $category_id = $this->category_id;

        $immediate_cat = Category::find($category_id);
        $default_shipping = Default_shipping_price::whereNull('slug')->first();

        $normal_cost = $default_shipping->normal_items;
        $bulky_cost = $default_shipping->bulky_items;

        if($immediate_cat != null) {

            $second_level_cat = Category::find($immediate_cat->depends_on);

            if($second_level_cat != null) {

                if($second_level_cat->slug == "large-appliances"){

                    return $bulky_cost;

                }elseif ($second_level_cat->slug == "tvs") {
                    
                    $category_id = $this->category_id;
                    $cat = Category::find($category_id);

                    if($cat->slug == "32-43") {

                        $shipping_medium = Default_shipping_price::where('slug', '32-43')->first();

                        return $shipping_medium->normal_items;
                        
                    }elseif ($second_level_cat->slug == "above-43") {
                    
                        $shipping_huge = Default_shipping_price::where('slug', 'above-43')->first();

                        return $shipping_huge->normal_items;
                    }

                }
            }
        }

        return $normal_cost;
    }


    public function getHiddenShippingCost() {

        $price = $this->getActivePrice();

        if(count($price) > 0){

            if(count($price) > 0){

                if($price->first()->offer_price > 0 && $price->first()->offer_price < 20000){

                    $category_id = $this->category_id;

                $immediate_cat = Category::find($category_id);
                $default_shipping = Default_shipping_price::orderBy('id', 'DESC')->first();

                $normal_cost = $default_shipping->normal_items;
                $bulky_cost = $default_shipping->bulky_items;

                if($immediate_cat != null) {

                    $second_level_cat = Category::find($immediate_cat->depends_on);

                    if($second_level_cat != null) {

                        if($second_level_cat->slug == "large-appliances"){

                            return $bulky_cost;
                        }
                    }
                }

                return $normal_cost;
                    
                }elseif ( $price->first()->standard_price < 20000) {
                    
                    $category_id = $this->category_id;

                    $immediate_cat = Category::find($category_id);
                    $default_shipping = Default_shipping_price::orderBy('id', 'DESC')->first();

                    $normal_cost = $default_shipping->normal_items;
                    $bulky_cost = $default_shipping->bulky_items;

                    if($immediate_cat != null) {

                        $second_level_cat = Category::find($immediate_cat->depends_on);

                        if($second_level_cat != null) {

                            if($second_level_cat->slug == "large-appliances"){

                                return $bulky_cost;
                            }
                        }
                    }

                    return $normal_cost;
                }
            }
        }

        $price = $this->getMinimumPrice();

        if($price != null){

            if($price < 20000){

                $category_id = $this->category_id;

                $immediate_cat = Category::find($category_id);
                $default_shipping = Default_shipping_price::orderBy('id', 'DESC')->first();

                $normal_cost = $default_shipping->normal_items;
                $bulky_cost = $default_shipping->bulky_items;

                if($immediate_cat != null) {

                    $second_level_cat = Category::find($immediate_cat->depends_on);

                    if($second_level_cat != null) {

                        if($second_level_cat->slug == "large-appliances"){

                            return $bulky_cost;
                        }
                    }elseif ($second_level_cat->slug == "tvs") {
                    
                        $category_id = $this->category_id;
                        $cat = Category::find($category_id);

                        if($cat->slug == "32-43") {

                            $shipping_medium = Default_shipping_price::where('slug', '32-43')->first();

                            return $shipping_medium->normal_items;
                            
                        }elseif ($second_level_cat->slug == "above-43") {
                        
                            $shipping_huge = Default_shipping_price::where('slug', 'above-43')->first();

                            return $shipping_huge->normal_items;
                        }

                    }
                }

                return $normal_cost;
            }
        }

        return 0;
    }


    public function getRealShippingCost($order_detail_id) {

        $shipping_cost = 0;

        $city_id = 0;

        $order_detail = Order_detail::find($order_detail_id);

        $order = Order::findorfail($order_detail->order_id);
        $order_value = $order_detail->total_value;

        $shipping_type_id = $order->shipping_type_id;

        $default_shipping = Default_shipping_price::orderBy('id', 'DESC')->first();

        $normal_cost = $default_shipping->normal_items;
        $bulky_cost = $default_shipping->bulky_items;

        if($shipping_type_id == 1){

            $address = User_pickup_location::findorfail($order->user_address_id);

            if($address == null){

                return $normal_cost;
            }

            $city_id = Warehouse::findorfail($address->warehouse_id);

        }else{

            $address = User_address::findorfail($order->user_address_id);

            if($address == null){

                return $normal_cost;
            }

            $city_id = $address->city_id;
        }

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
         
        $product_price = Product_price::find($order_detail->product_price_id);

        if($product_price == null){

            return $normal_cost;
        }

        $category_id = $product_price->product->category_id;

        if($category_id != null){

            $shippingPrice = Shipping_price::where('city_id', $city_id)
                ->where('shipping_type_id', $shipping_type_id)
                    ->where('category_id', $category_id)->first();

            if($shippingPrice == null){

                $shippingPrice = Shipping_price::where( function($query) 
                    use ($tv_id, $appliances_id){

                    $query->where('category_id', '!=', $tv_id)
                    ->where('category_id', '!=', $appliances_id);

                })->where('city_id', $city_id)
                 ->where('shipping_type_id', $shipping_type_id)->first();
            }

            if($shippingPrice != null){

                $no_of_items = $order_detail->quantity;

                if($no_of_items > 1){

                    $shipping_cost = $shippingPrice->price_many;
                }else{

                    $shipping_cost = $shippingPrice->price_one;
                }
            }
        }

        return $shipping_cost;
    }

}