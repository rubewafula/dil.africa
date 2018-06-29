<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_details';

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
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price',
        'product_price_id', 'status'];

    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    public function order()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Order');
    }
    
    public function product_price()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product_price');
    }
    
}