<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion_banner extends Model
{
    
    public  $table='promotion_banners';

    public  $fillable=['promotion_section_id','active_from',
    	'active_to', 'campaign_description', 'url','category_id', 
        'product_id','banner','status'];


    public  function  product()
    {
    	return $this->BelongsTo('App\Product');
    }

    public  function  category()
    {
    	return  $this->BelongsTo('App\Category');
    }


    public  function  promotion_section()
    {
        return  $this->BelongsTo('App\Promotion_section');
    }
}
