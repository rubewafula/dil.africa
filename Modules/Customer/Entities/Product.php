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
    protected $fillable = ['name', 'seller_id', 'mini_category_id', 'tax_class',
        'size', 'weight', 'main_material', 'author', 'publisher', 
        'product_description', 'highlight', 'what_isinthe_box',
        'product_warranty', 'care_label', 'youtube_id', 'product_expiry', 
        'product_expiry_date', 'locally_made_products', 'publish_status',
        'publish_date'];

    public function seller()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Seller');
    }
    
    
    public function mini_category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Mini_category');
    }
    
    
    public function product_images()
    {
        return $this->HasMany('Modules\Customer\Entities\Product_image');
    }
    
    
    public function getDefaultImage(){
        
        $image = Product_image::where("product_id", $this->id)
                ->where('default', 1)->orderBy('id', 'DESC')->limit(1)->first();
        
        return $image;
    }
    
    public function getActivePrice(){
        
        $price = Product_price::where("product_id", $this->id)
                ->where('status', 1)->orderBy('id', 'DESC')->limit(1)->first();
        
        return $price;
    }
    
    
}