<div id="hero" class="hidden-xs">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

        <?php ($banner = new \Modules\Customer\Entities\Promotion_banner()); ?>
        <?php ($main_banners = $banner->getMainBanners()); ?>       

        <?php $__currentLoopData = $main_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($main_banner->campaign_id != null): ?>
        <a href="<?php echo e(url('/shop/campaign/'.$main_banner->campaign_id)); ?>">
	        <div class="item" style="background-image: url(assets/images/banners/<?php echo e($main_banner->url); ?>);">

	        </div><!-- /.item -->
	    </a>
        <?php elseif($main_banner->product_id != null): ?>
        <?php ($slug = \Modules\Customer\Entities\Product::find($main_banner->product_id)->slug); ?>
        <a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>">
	        <div class="item" style="background-image: url(assets/images/banners/<?php echo e($main_banner->url); ?>);">

	        </div><!-- /.item -->
	    </a>
	    <?php elseif($main_banner->category_id != null): ?>
	    <?php ($slug = \Modules\Customer\Entities\Category::find($main_banner->category_id)->slug); ?>
	    <a href="<?php echo e(url('/shop/category/'.$slug)); ?>">
	        <div class="item" style="background-image: url(assets/images/banners/<?php echo e($main_banner->url); ?>);">

	        </div><!-- /.item -->
	    </a>
	    <?php else: ?>
	    <div class="item" style="background-image: url(assets/images/banners/<?php echo e($main_banner->url); ?>);">
		</div><!-- /.item -->
	    <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div><!-- /.owl-carousel -->
</div>