<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaigns';

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
    protected $fillable = ['name', 'active_from', 'active_to', 
    'campaign_description', 'category_id',
        'product_id', 'status'];

    public function category()
    {
        return $this->BelongsTo('App\Category');
    }


    public function product()
    {
        return $this->BelongsTo('App\Product');
    }

}