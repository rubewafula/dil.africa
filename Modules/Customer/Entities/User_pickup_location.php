<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class User_pickup_location extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_pickup_locations';

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
    protected $fillable = ['user_id', 'warehouse_id', 'default'];

    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
    
    public function warehouse()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Warehouse');
    }
    
}