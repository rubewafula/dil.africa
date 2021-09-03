<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category_product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_product';

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
    protected $fillable = ['product_id','category_id'];

    public $timestamps = false;

}