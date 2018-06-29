<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Popular extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'popular_products';

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
    protected $fillable = ['product_id', 'category_id'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Category');
    }
    
    //A Java Service will keep this populated and to a maximum of 20
    public function getPopular(){
        
        $products = $this->orderBy('id', 'DESC')->get();
        
        return $products;
    }
    
}