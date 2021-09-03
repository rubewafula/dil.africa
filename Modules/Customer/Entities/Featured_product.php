<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Featured_product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'featured_products';

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
    protected $fillable = ['product_id'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    //A Java Service will keep this populated and to a maximum of 20
    public function getFeaturedProducts(){

        if(Cache::has('featured_products')) {

            $products = Cache::get('featured_products');

        }else{
        
            $products = $this->orderBy('id','DESC')->limit(15)->get();

            $minutes = 20;

            Cache::add('featured_products', $products, $minutes);
        }
        
        return $products;
    }
}