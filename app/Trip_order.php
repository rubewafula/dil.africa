<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip_order extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trip_orders';

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
    protected $fillable = ['trip_id', 'order_id', 'status', 'comments'];


	 public function  trip()
	 {
		 return  $this->BelongsTo('App\Trip');
	 } 

	 public function  order()
	 {
		 return  $this->BelongsTo('App\Order');
	 } 
		 
}