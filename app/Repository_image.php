<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository_image extends Model
{
    //

    public  $table='repository_images';

    public $guarded= ['id'];

    public  $fillable=['repository_id','repository_price_id','image_url','default'];


    public  function  repository()
    {
    	return $this->BelongsTo('Modules\Repository\Entities\Repository');
    }

    public  function  item_size()
    {
    	return  $this->BelongsTo('App\Item_size');
    }


    public  function  images()
    {
        return  $this->HasMany('App\Product_image');
    }
}
