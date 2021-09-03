<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

use Modules\Customer\Entities\Product_review;

class Repository extends Model
{
    protected $primarykey='id';
    
	protected $table='repositories';

     public  $fillable=['name','tax_class','size','weight','main_material','author','publisher','product_description','highlight','whats_inthe_box','product_warranty','care_label','youtube_id','product_expiry','product_expiry_date','locally_made_products','publish_status','publish_date','category_id','slug','brand_id','suspension_reason_id','item_size_id','submitted_by'];

    protected $dates = ['deleted_at'];




public function  item_size()
{
	return  $this->BelongsTo('App\Item_size');
}

	public function suspension_reason()
	{

	  return  $this->BelongsTo('App\Supension_reason');
	}

   
    public  function prices()
    {

    	return  $this->HasMany('\Modules\Repository\Entities\Repository_price');
    }


    public  function images()
    {

       return $this->HasMany('\Modules\Repository\Entities\Repository_image');
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
      return  $this->HasMany('Modules\Repository\Entities\Repository_feature');
    }


    public function getAncestorCategory(){

        $category = Category::find($this->category->id);
        while($category->depends_on != null){

            $category = Category::find($category->depends_on);
        }
        return $category->id;
    }


    public function getDefaultImage(){
        
        $image = Repository_image::where("repository_id", $this->id)
                ->where('default', 1)->first();

        if($image == null){
            
            $image = Repository_image::where("repository_id", $this->id)->first();
        }
        
        return $image;
    }
    
    public function getActivePrice(){
        
        $price = Repository_price::where("repository_id", $this->id)
                    ->where('status', 1)->orderBy('id', 'DESC')->get();
        
        return $price;
    }


    public function hasDifferentPrices(){
        
        $allprices = Repository_price::where("repository_id", $this->id)
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
        
        $allprices = Repository_price::where("repository_id", $this->id)
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
        
        $allprices = Repository_price::where("repository_id", $this->id)
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
        
        $images = Repository_image::where("repository_id", $this->id)->get();
        
        return $images;
    }
    
    public function isAvailable(){
        
        $available = false;
        $stock = Repository_price::where("repository_id", $this->id)->sum('quantity');        
        
        if($stock > 0){
            
            $available = true;
        }
        return $available;
    }

}