<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

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
        'campaign_description', 'url', 'target_url', 'category_id', 'product_id', 'banner', 'status'];

    public function promotion_section()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Promotion_section');
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public  function getSidebarBanner(){
        
        if(Cache::has('side_banner')) {

            $banner = Cache::get('side_banner');

        }else{

            $promotion_section_id = Promotion_section::where('name', "upper_sidebar")->first()->id;
            $banner = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->where('active_from', '<=', date('Y-m-d'))
                ->where('active_to', '>=', date('Y-m-d'))->orderBy('id', 'DESC')->first();

            $minutes = 30;

            Cache::add('side_banner', $banner, $minutes);
        }
        
        return $banner;
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public function getMainBanners(){

        if(Cache::has('main_banners')) {

            $banners = Cache::get('main_banners');

        }else{

            $promotion_section_id = Promotion_section::where('name', "main")->first()->id;

            $banners = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->where('active_from', '<=', date('Y-m-d'))
                ->where('active_to', '>=', date('Y-m-d'))
                ->orderBy('id', 'DESC')->get();

            $minutes = 30;

            Cache::add('main_banners', $banners, $minutes);
        }
        
        return $banners;
    }
    
    //A Java Service to be setting the status to either 1 or 0 based on the time set
    public  function getMiddleBanner_1(){

        if(Cache::has('middle_banner_1')) {

            $banner = Cache::get('middle_banner_1');

        }else{
        
            $promotion_section_id = Promotion_section::where('name', "middle_banner_1")->first()->id;
            $banner = $this->where("promotion_section_id", $promotion_section_id)
                ->where('status', 1)->where('active_from', '<=', date('Y-m-d'))
                ->where('active_to', '>=', date('Y-m-d'))->orderBy('id', 'DESC')->first();

            $minutes = 30;

            Cache::add('middle_banner_1', $banner, $minutes);
        }
        
        return $banner;
    }
}
