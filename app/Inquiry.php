<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inquiries';

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
    protected $fillable = ['subject_type_id', 'first_name', 'last_name', 'message', 'read', 'viewed_by', 'user_id','email','telephone'];
	
	public function  subject_type()
	{
		
		return  $this->BelongsTo('App\Subject_type');
		
	}	
	

    
}
