<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'riders';

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
    protected $fillable = ['name', 'email', 'phone','active', 'gender', 'id_number', 'vehicle_id'];

    public function vehicle()
    {

        return  $this->BelongsTo('App\Vehicle');
    }

}