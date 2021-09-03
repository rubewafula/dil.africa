<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Trending_product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trending_products';

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
    protected $fillable = ['product_id', 'category_id'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }

    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Category');
    }
    
    //A Java Service will keep this populated and to a maximum of 20
    public function getElectronicsTrendingProducts(){

        if(Cache::has('trending_electronics_products')) {

            $products = Cache::get('trending_electronics_products');

        }else{
        
            $products = $this->where('category_id', 62)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_electronics_products', $products, $minutes);
        }
        
        return $products;
    }

    //A Java Service will keep this populated and to a maximum of 20
    public function getFashionTrendingProducts(){

        if(Cache::has('trending_fashion_products')) {

            $products = Cache::get('trending_fashion_products');

        }else{
        
            $products = $this->where('category_id', 75)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_fashion_products', $products, $minutes);
        }
        
        return $products;
    }

    //A Java Service will keep this populated and to a maximum of 20
    public function getHairBeautyTrendingProducts(){

        if(Cache::has('trending_beauty_products')) {

            $products = Cache::get('trending_beauty_products');

        }else{    
        
            $products = $this->where('category_id', 157)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_beauty_products', $products, $minutes);
        }
        
        return $products;
    }
}