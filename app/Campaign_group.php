<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_group extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaign_groups';

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
    protected $fillable = ['group_name', 'description', 'status'];
    
}