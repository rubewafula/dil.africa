<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fifth_category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fifth_categories';

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
    protected $fillable = ['fourth_category_id', 'name', 'cover_photo'];

    
}
