<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms_campaign extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sms_campaigns';

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
    protected $fillable = ['campaign_group_id', 'msisdn', 'status'];


    public function campaign_group()
    {
        return $this->BelongsTo('App\Campaign_group');
    }
    
}