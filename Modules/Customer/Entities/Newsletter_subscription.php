<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_subscription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'newsletter_subscriptions';

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
    protected $fillable = ['user_id', 'email', 'status'];
    
    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
}