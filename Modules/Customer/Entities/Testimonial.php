<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'testimonials';

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
    protected $fillable = ['name', 'image_url', 'organization', 'message'];

    public function getTestimonials(){
        
        $testimonials = $this->where('status', 1)->orderBy('id', 'DESC')->get();       
        return $testimonials;
    }
}
