<?php

namespace App;

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
    protected $fillable = ['name', 'contact_phone', 'capacity','is_pickup_location', 'city_id'];

    public function user()
    {

        return  $this->BelongsTo(App\User);
    }

    public function  orders()
    {
        return  $this->HasMany('App\Order');
    }

    public  function  area()
    {
        return  $this->BelongsTo('App\Area');
    }

    public  function  city()
    {
        return  $this->BelongsTo('App\City');
    }

    
}
