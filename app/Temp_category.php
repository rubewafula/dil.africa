<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'temp_categories';

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
    protected $fillable = ['name', 'slug', 'cover_photo', 'description','icon','level','depends_on','public','percent_commission','is_popular','level_two_category'];


    static  function  check_lower_tree($category_id)
    {
      
      $cat_count =  SELF::where('depends_on',$category_id)->count();

    if($cat_count >  0 )
      {

        return  TRUE;
      } else{

        return FALSE;
      }


   }

   public  function  level_two($category_id)
   {
        if($category_id == NULL)
        {

          return  NULL;

        }
          $cat =  SELF::where('level_two_category',$category_id)->first();

          if(!empty($cat))
          {
            
            return  $cat->name;

          } else{
             return  NULL;

          }

   }


   public  function  products()
   {

      return  $this->BelongsToMany('App\Product');
   }


   public function  sizes()
   {

      return  $this->HasMany('App\Category_size');
   }


  public function getAncestorCategory(){

        $category = $this;
        while($category->depends_on != null){

            $category = Category::find($category->depends_on);
        }
        return $category;
    }

    
}
