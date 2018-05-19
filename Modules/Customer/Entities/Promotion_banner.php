<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Promotion_banner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotion_banners';

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
    protected $fillable = ['promotion_section_id', 'active_from', 'active_to',
        'url', 'banner', 'status'];

    public function promotion_section()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Promotion_section');
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public  function getSidebarBanner(){
        
        $promotion_section_id = Promotion_section::where('name', "upper_sidebar")->first()->id;
        $banner = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->orderBy('id', 'DESC')->first();
        
        return $banner;
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public function getMainBanners(){
        
        $promotion_section_id = Promotion_section::where('name', "main")->first()->id;
        $banners = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->orderBy('id', 'DESC')->get();
        
        return $banners;
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public  function getMiddleBanner_1(){
        
        $promotion_section_id = Promotion_section::where('name', "middle_banner_1")->first()->id;
        $banner = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->orderBy('id', 'DESC')->first();
        
        return $banner;
    }
}
