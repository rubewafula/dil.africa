<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Searched_item extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'searched_items';

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
    protected $fillable = ['ip_address', 'user_id', 'original_search_item',
        'prompted_search_item', 'email_address', 'search_hit', 'phone_number'];

    public function user()
    {
        return $this->BelongsTo('App\User');
    }
    
}