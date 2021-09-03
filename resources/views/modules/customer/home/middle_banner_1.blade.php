<div class="row">

    @php($banner = new \Modules\Customer\Entities\Promotion_banner())
    @php($middle_banner = $banner->getMiddleBanner_1())
 
    @if($middle_banner != null)
    <div class="col-md-12">
        <div class="wide-banner cnt-strip">
            <div class="image">
                @if($middle_banner->target_url != null)
                <a href="{{url('/'.$middle_banner->target_url)}}" target="_blank">
                    <img class="img-responsive" src="assets/images/banners/{{$middle_banner->url}}" alt="">
                </a>
                @elseif($middle_banner->campaign_id != null)
                <a href="{{url('/shop/campaign/'.$middle_banner->campaign_id)}}">
                    <img class="img-responsive" src="assets/images/banners/{{$middle_banner->url}}" alt="">
                </a>
                @elseif($middle_banner->product_id != null)
                @php($slug = \Modules\Customer\Entities\Product::find($middle_banner->product_id)->slug)
                <a href="{{url('/shop/product/detail/'.$slug)}}">
                    <img class="img-responsive" src="assets/images/banners/{{$middle_banner->url}}" alt="">
                </a>
                @elseif($middle_banner->category_id != null)
                @php($slug = \Modules\Customer\Entities\Category::find($middle_banner->category_id)->slug)
                <a href="{{url('/shop/category/'.$slug)}}">
                    <img class="img-responsive" src="assets/images/banners/{{$middle_banner->url}}" alt="">
                </a>
                 @else
                 <img class="img-responsive" src="assets/images/banners/{{$middle_banner->url}}" alt="">
                 @endif
            </div>
            <div class="strip strip-text">
                <div class="strip-inner">
                    <h2 class="text-right">
                        <span class="shopping-needs"></span></h2>
                </div>	
            </div>
            <div class="new-label">
                <div class="text"></div>
            </div>
        </div>
    </div><!-- /.col -->
    @endif

</div><!-- /.row -->