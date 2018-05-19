<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_tag';

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
    protected $fillable = ['product_id', 'tag_id'];

    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    public function tag()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Tag');
    }
    
}