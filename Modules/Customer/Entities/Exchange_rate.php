<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Exchange_rate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exchange_rates';

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
    protected $fillable = ['base_currency', 'converted_currency', 'rate', 
        'applicable_date'];
    
}