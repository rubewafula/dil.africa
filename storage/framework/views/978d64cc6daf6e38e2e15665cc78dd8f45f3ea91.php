<?php ($banner = new \Modules\Customer\Entities\Promotion_banner()); ?>
<?php ($sidebar_banner = $banner->getSidebarBanner()); ?>
<?php if($sidebar_banner != null): ?>
<?php if($sidebar_banner->campaign_id != null): ?>
<a href="<?php echo e(url('/shop/campaign/'.$sidebar_banner->campaign_id)); ?>">
	<div class="image">
		<img src="assets/images/banners/<?php echo e($sidebar_banner->url); ?>" alt="Image">
	</div>
</a>
<?php elseif($sidebar_banner->product_id != null): ?>
<?php ($slug = \Modules\Customer\Entities\Product::find($sidebar_banner->product_id)->slug); ?>
<a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>">
	<div class="image">
		<img src="assets/images/banners/<?php echo e($sidebar_banner->url); ?>" alt="Image">
	</div>
</a>
<?php elseif($sidebar_banner->category_id != null): ?>
<?php ($slug = \Modules\Customer\Entities\Category::find($sidebar_banner->category_id)->slug); ?>
<a href="<?php echo e(url('/shop/category/'.$slug)); ?>">
	<div class="image">
		<img src="assets/images/banners/<?php echo e($sidebar_banner->url); ?>" alt="Image">
	</div>
 </a>
 <?php else: ?>
 <div class="image">
	 <img src="assets/images/banners/<?php echo e($sidebar_banner->url); ?>" alt="Image">
 </div>
 <?php endif; ?>
 <?php endif; ?>