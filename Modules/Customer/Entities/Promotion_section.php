<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Promotion_section extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotion_sections';

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
    protected $fillable = ['name', 'no_of_images'];

    
}
