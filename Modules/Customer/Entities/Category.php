<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Customer\Utilities\Utilities;

use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    
    protected $primaryKey = 'id'; 
    
    protected $table = 'categories';
    
    protected $fillable = ['name', 'slug', 'cover_photo', 'description', 
        'level', 'depends_on', 'is_popular', 'item_size_id'];
    
    
    public function getAllCategories() {

        if(Cache::has('all_categories')) {

            $categories = Cache::get('all_categories');

        }else{

            $categories = $this->get();

            $minutes = 60;

            Cache::add('all_categories', $categories, $minutes);
        }
        
        return $categories;
    }
    
    
    public function getSubCategories(){

        if(Cache::has('sub_categories'.$this->slug)) {

            $categories = Cache::get('sub_categories'.$this->slug);

        }else{
        
            $categories =  $this->where('depends_on', $this->id)
                ->where('status', 1)->get();
            $minutes = 60;
            Cache::add('sub_categories'.$this->slug, $categories, $minutes);
        }
        return $categories;
    }
    
    
    public function  popular_products(){
        
        return $this->HasMany('Modules\Customer\Entities\Popular');
    }


    public function  item_size(){
        
        return $this->BelongsTo('Modules\Customer\Entities\Item_size');
    }


    public function getNoOfProducts(){

        if(Cache::has('categories_no_products'.$this->slug)) {

            $products_count = Cache::get('categories_no_products'.$this->slug);

        }else{

            $all_ids = Utilities::getAllChildrenCategoriesIdsIncludingSelf($this->id);

            $products_count = Product::whereIn('category_id', $all_ids)->count();

            $minutes = 60;
            Cache::add('categories_no_products'.$this->slug, $products_count, $minutes);
        }

        return $products_count;
    }
    
}