<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

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
    protected $fillable = ['user_id', 'ip_address', 'building', 'delivery_address', 
        'city_id', 'country_id', 'address_type', 'postal_address', 'floor', 'street',
        'postal_code', 'zone_id', 'google_area', 'area_id', 'default', 'landmark',
         'description', 'telephone'];

    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
    
    public function country()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Country');
    }
    
    public function city()
    {
        return $this->BelongsTo('Modules\Customer\Entities\City');
    }
    
    public function area()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Area');
    }
    
}