<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipping_cost extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_costs';

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
    protected $fillable = ['zone_id', 'amount'];
    
}