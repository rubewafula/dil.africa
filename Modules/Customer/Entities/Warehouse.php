<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'warehouses';

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
    protected $fillable = ['name', 'area_id', 'city_id', 'contact_phone', 
        'capacity', 'is_pickup_location'];
    
    public function area()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Area');
    }

    public function city()
    {
        return $this->BelongsTo('Modules\Customer\Entities\City');
    }
    
}