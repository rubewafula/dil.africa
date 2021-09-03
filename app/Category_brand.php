<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_brand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_brands';

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
    protected $fillable = ['category_id', 'brand_id'];

    
    public function brand()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Brand');
    }
    
    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Category');
    }
    
}