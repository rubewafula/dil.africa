<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_note extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_notes';

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
    protected $fillable = ['id','user_id','note','created_by','created_at','updated_at'];
    

    public  function  user()
    {
        return   $this->BelongsTo('App\User');
    }
    
}
