<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository_feature extends Model
{

	protected  $table= 'repository_features';

    protected  $primaryKey='id';
    
     protected $fillable = ['repository_id','feature_type_id','value'];


    public  function  repository()
    {
        return  $this->BelongsTo('Modules\Repository\Entities\Repository');
    }


    public  function  feature_type()
    {
        return  $this->BelongsTo('App\Feature_type');
    }
}
