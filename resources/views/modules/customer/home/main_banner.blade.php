<div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

        @php($banner = new \Modules\Customer\Entities\Promotion_banner())
        @php($main_banners = $banner->getMainBanners())       

        @foreach($main_banners as $main_banner)
        <div class="item" style="background-image: url(assets/images/banners/{{$main_banner->url}});">

        </div><!-- /.item -->
        @endforeach

    </div><!-- /.owl-carousel -->
</div>