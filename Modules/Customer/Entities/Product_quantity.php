<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_quantity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_quantities';

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
    protected $fillable = ['product_id', 'color', 'size', 'quantity'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
}