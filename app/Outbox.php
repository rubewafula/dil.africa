<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'outbox';

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
    protected $fillable = ['order_id', 'user_id', 'campaign_group_id', 'sms_campaign_id',
     'msisdn', 'message', 'status'];

    public function order()
    {
        return $this->BelongsTo('App\Order');
    }
    
    public function user()
    {
        return $this->BelongsTo('App\User');
    }

    public function campaign_group()
    {
        return $this->BelongsTo('App\Campaign_group');
    }

    public function sms_campaign()
    {
        return $this->BelongsTo('App\Sms_campaign');
    }
    
}