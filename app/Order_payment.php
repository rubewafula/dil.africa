<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_payments';

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
    protected $fillable = ['order_id', 'payment_gateway_id', 'amount', 'status',
        'transaction_code', 'merchant_ref', 'transaction_date'];

    public function order()
    {
        return $this->BelongsTo('App\Order');
    }
    
    public function payment_gateway()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Payment_gateway');
    }
    
}