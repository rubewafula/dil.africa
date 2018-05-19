<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sellers';

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
    protected $fillable = ['name', 'username', 'logo', 'description', 
        'opening_hours', 'closing_hours', 'status', 'country_id', 'city_id',
        'area_id', 'physical_location', 'email_address', 'telephone',
        'other_telephone', 'contact_person', 'contact_telephone', 
        'contact_email_address', 'warehouse_id', 'bank_name', 'account_name',
        'account_number', 'swift_code', 'bank_code'];

    
}
