<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Special_offer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'special_offers';

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
    
    public function getSpecialOffers(){

        if(Cache::has('special_offers')) {

            $offers = Cache::get('special_offers');

        }else{
        
            $offers = $this->where("expires_on", ">", date("Y-m-d H:i:s"))
                ->orderBy('priority')->get();

            $minutes = 5;

            Cache::add('special_offers', $offers, $minutes);
        }
        
        return $offers;
    }
    
}