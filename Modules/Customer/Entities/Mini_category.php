<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Mini_category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mini_categories';

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
    protected $fillable = ['sub_category_id', 'name', 'slug', 'cover_photo',
        'description'];

    public function category()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Sub_Category');
    }
    
}
