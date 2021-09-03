<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'seller_id', 'category_id', 
        'delivery_timeline_id', 'tax_class', 'model', 'brand_id',
        'size', 'weight', 'main_material', 'author', 'publisher', 
        'product_description', 'highlight', 'what_isinthe_box',
        'product_warranty', 'care_label', 'youtube_id', 'product_expiry', 
        'product_expiry_date', 'locally_made_products', 'publish_status',
        'publish_date', 'keywords', 'product_measures'];
    
    
    public function newQuery() {
        
        return parent::newQuery()->where('publish_status', 1);
    }

    public function seller()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Seller');
    }
    
    
    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Category');
    }
    
    
    public function product_images()
    {
        return $this->HasMany('Modules\Customer\Entities\Product_image');
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

    public function getFlashPrice(){
        
        $price = Flash_sale::where("product_id", $this->id)->where('status', 1)
                    ->where('flash_sales.active_from', '<=', date('Y-m-d H:i:s'))
            ->where('flash_sales.expires_on', '>=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')->first();
        
        return $price;
    }


    public function hasDifferentPrices(){
        
        $allprices = Product_price::where("product_id", 
            $this->id)->where('is_default', 1)
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


    public function getMaximumPrice() {
        
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
            if($offer_price > 0) { 
                array_push($prices, $offer_price);
            }
            
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
    
}