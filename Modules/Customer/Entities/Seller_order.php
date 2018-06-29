<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Seller_order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seller_orders';

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
    protected $fillable = ['seller_id', 'order_detail_id', 'order_id', 
        'order_reference', 'order_date', 'shipping_status', 'delivery_due_date',
        'order_status', 'warehouse_id', 'received_by'];

    public function seller()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Seller');
    }
    
    public function order()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Order');
    }
    
    public function order_detail()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Order_detail');
    }
    
}