@php($banner = new \Modules\Customer\Entities\Promotion_banner())
@php($sidebar_banner = $banner->getSidebarBanner())
@if($sidebar_banner != null)
@if($sidebar_banner->campaign_id != null)
<a href="{{url('/shop/campaign/'.$sidebar_banner->campaign_id)}}">
	<div class="image">
		<img src="assets/images/banners/{{$sidebar_banner->url}}" alt="Image">
	</div>
</a>
@elseif($sidebar_banner->product_id != null)
@php($slug = \Modules\Customer\Entities\Product::find($sidebar_banner->product_id)->slug)
<a href="{{url('/shop/product/detail/'.$slug)}}">
	<div class="image">
		<img src="assets/images/banners/{{$sidebar_banner->url}}" alt="Image">
	</div>
</a>
@elseif($sidebar_banner->category_id != null)
@php($slug = \Modules\Customer\Entities\Category::find($sidebar_banner->category_id)->slug)
<a href="{{url('/shop/category/'.$slug)}}">
	<div class="image">
		<img src="assets/images/banners/{{$sidebar_banner->url}}" alt="Image">
	</div>
 </a>
 @else
 <div class="image">
	 <img src="assets/images/banners/{{$sidebar_banner->url}}" alt="Image">
 </div>
 @endif
 @endif