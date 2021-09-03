<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_product extends Model
{
  
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaign_products';

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
    protected $fillable = ['product_id', 'product_code', 'discount', 
        'offer_price', 'price_before', 'initial_stock', 'remaining_stock',
         'status'];

    public function product()
    {
        return $this->BelongsTo('App\Product');
    }

    public function promotion_banner()
    {
        return $this->BelongsTo('App\Promotion_banner');
    }
    
    public function getCampaignProducts($id){
        
        $products = $this->where("promotion_banner_id", $id)
        	->where("remaining_stock", ">", 0)->get();
        
        return $products;
    }

}