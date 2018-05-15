<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $primaryKey = 'id'; 
    
    protected $table = 'categories';
    
    protected $fillable = ['name', 'slug', 'cover_photo', 'description'];
    
    
    public function getAllCategories(){
        return $this->get();
    }
    
}
