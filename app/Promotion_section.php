<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion_section extends Model
{
    public  $table='promotion_sections';

    public  $fillable=['name','no_of_images'];

}
