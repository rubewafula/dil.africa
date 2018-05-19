<?php ($banner = new \Modules\Customer\Entities\Promotion_banner()); ?>
<?php ($sidebar_banner = $banner->getSidebarBanner()); ?>
<img src="assets/images/banners/<?php echo e($sidebar_banner->url); ?>" alt="Image">