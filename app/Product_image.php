<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    //

    public  $table='product_images';

    public  $primaryKey= 'id';


    public  $fillable=['product_id','image_url','default','product_price_id'];


    public function  product()
    {

    	return  $this->BelongsTo('App\Product');
    }


    public  function  product_price()
    {

    	return  $this->BelongsTo('App\Product_price');
    }

}
