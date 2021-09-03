<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_price extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_prices';

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
    protected $fillable = ['product_id', 'color', 'size', 'quantity', 'offer_quantity',
         'is_default', 'minimum_quantity', 'standard_price', 'offer_price', 'start_date',
            'end_date', 'status', 'item_size_id'];

    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }

    public function item_size()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Item_size');
    }


    public function getProductPriceImages(){
        
        $images = Product_image::where("product_price_id", $this->id)->get();
        
        return $images;
    }
}