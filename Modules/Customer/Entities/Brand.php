<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'brands';

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
    protected $fillable = ['name', 'logo', 'mini_category_id', 'slug',
        'cover_photo', 'description'];
    
    
    public function mini_category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Mini_category');
    }
    
    
    public function getDefaultImage(){
        
        $image = $this->first();
        
        return $image;
    }
    
}