<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository_price extends Model
{
    //

    public  $table='repository_prices';

    public $guarded= ['id'];

    public  $fillable=['repository_id','market','minimum_quantity','standard_price','offer_price','start_date','end_date','color','size','quantity','is_default','item_size_id'];


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
        return  $this->HasMany('Modules\Repository\Entities\Repository_image')->OrderBy('repository_price_id','DESC');
    }
}
