<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zones';

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
    protected $fillable = ['name', 'city_id'];
    
    
    public function city()
    {
        return $this->BelongsTo('Modules\Customer\Entities\City');
    }
    
}