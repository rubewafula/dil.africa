<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hot_deal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hot_deals';

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
    protected $fillable = ['product_id', 'discount', 'expires_on',
        'offer_price', 'price_before'];

    public function product()
    {
        return $this->BelongsTo('App\Product');
    }
    
    public function getHotDeals(){
        
        $deals = $this->where("expires_on", ">", date("Y-m-d h:i:s"))
                ->orderBy('priority')->get();
        
        return $deals;
    }
    
}