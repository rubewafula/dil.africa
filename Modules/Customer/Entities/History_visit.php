<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class History_visit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_visits';

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
    protected $fillable = ['ip_address', 'product_id', 'user_id'];
    
    
    public function product()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Product');
    }
    
    
}