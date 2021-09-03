<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quality_issue extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quality_issues';

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
    protected $fillable = ['name'];


    public  function  seller_orders()
    {
        return  $this->HasMany('App\Seller_order');
    }

    
}
