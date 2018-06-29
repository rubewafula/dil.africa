<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['user_id', 'total_value', 'order_status', 
        'order_reference', 'user_address_id', 'shipping_cost', 'transaction_cost',
        'notes', 'payment_gateway_id', 'payment_status', 'dispatch_date',
        'delivered_by', 'email_address', 'agent_order', 'job_processed',
        'confirmation_token'];

    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
    
    public function user_address()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User_address');
    }
    
}