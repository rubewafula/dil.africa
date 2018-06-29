<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Cart_session extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cart_sessions';

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
    protected $fillable = ['user_id', 'ip_address', 'product_price_id', 'quantity'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
}