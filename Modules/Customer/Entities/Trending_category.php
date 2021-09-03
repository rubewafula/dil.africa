<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Trending_category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trending_categories';

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
    protected $fillable = ['category_id'];

    
    public function category()
    {
        return $this->BelongsTo('App\Category');
    }

    public function getElectronicsTrendingCategories(){

        if(Cache::has('trending_electronics_cats')) {

            $products = Cache::get('trending_electronics_cats');

        }else{
        
            $products = $this->where('main_category', 62)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_electronics_cats', $products, $minutes);
        }
        
        return $products;
    }

    public function getFashionTrendingCategories(){

        if(Cache::has('trending_fashion_cats')) {

            $products = Cache::get('trending_fashion_cats');

        }else{
        
            $products = $this->where('main_category', 75)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_fashion_cats', $products, $minutes);
        }
        
        return $products;
    }

    public function getHairBeautyTrendingCategories(){
        
        if(Cache::has('trending_beauty_cats')) {

            $products = Cache::get('trending_beauty_cats');

        }else{

            $products = $this->where('main_category', 157)->orderBy('priority')->limit(4)->get();

            $minutes = 20;

            Cache::add('trending_beauty_cats', $products, $minutes);
        }
        
        return $products;
    }
    
}