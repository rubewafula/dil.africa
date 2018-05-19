<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Featured_product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'featured_products';

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
    public function getFeaturedProducts(){
        
        $products = $this->orderBy('id', 'DESC')->get();
        
        return $products;
    }
}