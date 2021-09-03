<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

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
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    public function getHotDeals(){

        if(Cache::has('hot_deals')) {

            $deals = Cache::get('hot_deals');

        }else{
        
            $deals = $this->where("expires_on", ">", date("Y-m-d h:i:s"))
                ->orderBy('priority')->get();

            $minutes = 10;

            Cache::add('hot_deals', $deals, $minutes);
        }
        
        return $deals;
    }
    
}