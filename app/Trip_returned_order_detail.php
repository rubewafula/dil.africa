<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip_returned_order_detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trip_returned_order_details';

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
    protected $fillable = ['trip_id', 'order_id', 'order_detail_id', 'status', 'comments'];


	 public function  trip()
	 {
		 return  $this->BelongsTo('App\Trip');
	 } 

	 public function  order()
	 {
		 return  $this->BelongsTo('App\Order');
	 } 

	 public function  order_detail()
	 {
		 return  $this->BelongsTo('App\Order_detail');
	 } 
		 
}