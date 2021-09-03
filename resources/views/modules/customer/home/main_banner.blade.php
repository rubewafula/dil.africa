<div id="hero" class="hidden-xs">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

        @php($banner = new \Modules\Customer\Entities\Promotion_banner())
        @php($main_banners = $banner->getMainBanners())       

        @foreach($main_banners as $main_banner)
        @if($main_banner->campaign_id != null)
        <a href="{{url('/shop/campaign/'.$main_banner->campaign_id)}}">
	        <div class="item" style="background-image: url(assets/images/banners/{{$main_banner->url}});">

	        </div><!-- /.item -->
	    </a>
        @elseif($main_banner->product_id != null)
        @php($slug = \Modules\Customer\Entities\Product::find($main_banner->product_id)->slug)
        <a href="{{url('/shop/product/detail/'.$slug)}}">
	        <div class="item" style="background-image: url(assets/images/banners/{{$main_banner->url}});">

	        </div><!-- /.item -->
	    </a>
	    @elseif($main_banner->category_id != null)
	    @php($slug = \Modules\Customer\Entities\Category::find($main_banner->category_id)->slug)
	    <a href="{{url('/shop/category/'.$slug)}}">
	        <div class="item" style="background-image: url(assets/images/banners/{{$main_banner->url}});">

	        </div><!-- /.item -->
	    </a>
	    @else
	    <div class="item" style="background-image: url(assets/images/banners/{{$main_banner->url}});">
		</div><!-- /.item -->
	    @endif
        @endforeach

    </div><!-- /.owl-carousel -->
</div>