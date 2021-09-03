<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use  App\Category;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

     public  function  check_children($category_id)
    {
      
      $cat_count =  Category::where('depends_on',$category_id)->count();

    if($cat_count >  0 )
      {
        return  TRUE;
      } else{
        return FALSE;
      }


   }



}