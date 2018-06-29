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
        'delivery_timeline_id', 'tax_class',
        'size', 'weight', 'main_material', 'author', 'publisher', 
        'product_description', 'highlight', 'what_isinthe_box',
        'product_warranty', 'care_label', 'youtube_id', 'product_expiry', 
        'product_expiry_date', 'locally_made_products', 'publish_status',
        'publish_date'];
    
    
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
                ->where('default', 1)->orderBy('id', 'DESC')->first();
        
        return $image;
    }
    
    public function getActivePrice(){
        
        $price = Product_price::where("product_id", $this->id)->where('is_default', 1)
                ->where('status', 1)->orderBy('id', 'DESC')->first();
        
        return $price;
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
    
}