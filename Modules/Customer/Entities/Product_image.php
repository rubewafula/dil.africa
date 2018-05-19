<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';

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
    protected $fillable = ['name', 'product_id', 'image_url', 'default'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
}