<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Delivery_timeline extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'delivery_timelines';

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
    protected $fillable = ['name', 'hours', 'status'];

}