<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $primaryKey = 'id'; 
    
    protected $table = 'categories';
    
    protected $fillable = ['name', 'slug', 'cover_photo', 'description', 
        'level', 'depends_on', 'is_popular'];
    
    
    public function getAllCategories(){
        return $this->get();
    }
    
    public function getSubCategories(){
        
        return $this->where('depends_on', $this->id)->get();
    }
    
    
    public function  popular_products(){
        
        return $this->HasMany('Modules\Customer\Entities\Popular');
    }
    
}