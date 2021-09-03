<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sellers';

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
      protected $guarded = ['id','seller_id'];

      
        public function  category()
        {

        	return  $this->BelongsTo('App\Category');
        }

        

      public  function  orders()
      {

        return  $this->hasMany('App\Seller_order')->OrderBy('id','DESC');
      }



      public  function  products()
      {

      	return  $this->hasMany('App\Product');
      }


      public   function  users()
      {

        return  $this->HasMany('App\User');
      }

    
}
