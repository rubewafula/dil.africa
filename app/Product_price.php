<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_price extends Model
{
    //

    public  $table='product_prices';

    public $guarded= ['id'];

    public  $fillable=['product_id','minimum_quantity','standard_price','offer_price',
        'start_date','end_date','color','size','quantity', 'offer_quantity', 
            'is_default','item_size_id'];


    public  function  product()
    {
    	return $this->BelongsTo('App\Product');
    }

    public  function  item_size()
    {
    	return  $this->BelongsTo('App\Item_size');
    }


    public  function  images()
    {
        return  $this->HasMany('App\Product_image');
    }


    public function getProductPriceImages(){
        
        $images = Product_image::where("product_price_id", $this->id)->get();
        
        return $images;
    }
}
