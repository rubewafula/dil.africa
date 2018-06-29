<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_review extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_reviews';

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
    protected $fillable = ['product_id', 'rating', 'comment', 'published',
        'price', 'quality', 'value', 'name', 'summary'];
    
    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
}