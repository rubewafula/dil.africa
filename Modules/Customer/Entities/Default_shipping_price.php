<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Default_shipping_price extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'default_shipping_prices';

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
    protected $fillable = ['normal_items', 'bulky_items'];

}