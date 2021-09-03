<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Featured_category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'featured_categories';

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
    protected $fillable = ['main_category', 'category_id'];

    
    public function category()
    {
        return $this->BelongsTo('App\Category');
    }


    public function getFeaturedElectronicCategories(){

        if(Cache::has('featured_electronic_categories')) {

            $categories = Cache::get('featured_electronic_categories');

        }else{
        
            $categories = $this->where("main_category",  62)->get();

            $minutes = 30;

            Cache::add('featured_electronic_categories', $categories, $minutes);
        }
        
        return $categories;
    }


    public function getFeaturedFashionCategories(){

        if(Cache::has('featured_fashion_categories')) {

            $categories = Cache::get('featured_fashion_categories');

        }else{
        
            $categories = $this->where("main_category",  75)->get();

            $minutes = 30;

            Cache::add('featured_fashion_categories', $categories, $minutes);
        }
        
        return $categories;
    }


    public function getFeaturedBeautyCategories(){

        if(Cache::has('featured_beauty_categories')) {

            $categories = Cache::get('featured_beauty_categories');

        }else{
        
            $categories = $this->where("main_category",  157)->get();

            $minutes = 30;

            Cache::add('featured_beauty_categories', $categories, $minutes);
        }
        
        return $categories;
    }
    
}