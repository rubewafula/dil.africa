<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class New_arrival extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'new_arrivals';

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
    protected $fillable = ['product_id'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    //A Java Service will keep this populated and to a maximum of 20
    public function getNewArrivals(){

        if(Cache::has('new_arrivals')) {

            $products = Cache::get('new_arrivals');

        }else{
        
            $products = $this->orderBy('priority')->limit(15)->get();

            $minutes = 15;

            Cache::add('new_arrivals', $products, $minutes);
        }
        
        return $products;
    }
}