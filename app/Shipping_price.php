<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping_price extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_prices';

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
    protected $fillable = ['zone_id','shipping_type_id','item_size_id','price_one','price_many'];


    public function city()
    {
        return $this->BelongsTo('Modules\Customer\Entities\City');
    }
    
    
    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Category');
    }
    
    public function shipping_type()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Shipping_type');
    }

    
}
