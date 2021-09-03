<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_tag extends Model
{
    //

    public  $table='product_tag';


    public  $fillable=['product_id','tag_id'];


    public function  product()
    {

    	return  $this->BelongsTo('App\Product');
    }


    public  function  tag()
    {

    	return  $this->BelongsTo('App\Tag');
    }

}
