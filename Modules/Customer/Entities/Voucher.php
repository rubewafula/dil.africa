<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vouchers';

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
    protected $fillable = ['name', 'voucher_code', 'user_id', 'percent_discount',
     'amount', 'status', 'active_from', 'active_to', 'product_id', 'category_id',
        'voucher_type', 'applicable_amount', 'voucher_img'];

    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
    
}