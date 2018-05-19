<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Best_seller_brand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'best_seller_brands';

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
    protected $fillable = ['brand_id'];

    
    public function brand()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Brand');
    }
    
    public function getBestSellerBrands(){
        
        $brands = $this->orderBy('id', 'DESC')->get();
        
        return $brands;
    }
    
}