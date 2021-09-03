<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flash_sale extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flash_sales';

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
    protected $fillable = ['product_id', 'product_code', 'discount',
        'active_from', 'expires_on', 'offer_price', 'price_before',
         'initial_stock', 'remaining_stock','status'];

    public function product()
    {
        return $this->BelongsTo('App\Product');
    }
    
    public function getFlashSale(){
        
        $flash_sale = $this->where("expires_on", ">", date("Y-m-d h:i:s"))
        	->where("remaining_stock", ">", 0)->first();
        
        return $flash_sale;
    }
    
}