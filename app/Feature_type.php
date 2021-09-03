<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Category;

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
    protected $fillable = ['level_two_category', 'name'];

    
  
    public  function  category($id)
    {
       
      $category= Category::find($id);

      if(!empty($category))
      {
        return  $category->name;

      }else{

         return  NULL;
      }

    }
    
}
