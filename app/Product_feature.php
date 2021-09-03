<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_feature extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_features';

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
    protected $fillable = ['product_id','feature_type_id','value'];


    public  function  product()
    {
        return  $this->BelongsTo('App\Product');
    }


    public  function  feature_type()
    {
        return  $this->BelongsTo('App\Feature_type');
    }

    
}
