<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Feature_type extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feature_types';

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
    protected $fillable = ['category_id', 'name'];

    public  function  category()
    {
        return  $this->BelongsTo('Modules\Customer\Entities\Category');
    }

    
}
