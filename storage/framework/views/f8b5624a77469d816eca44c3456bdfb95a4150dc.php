<div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

        <?php ($banner = new \Modules\Customer\Entities\Promotion_banner()); ?>
        <?php ($main_banners = $banner->getMainBanners()); ?>       

        <?php $__currentLoopData = $main_banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item" style="background-image: url(assets/images/banners/<?php echo e($main_banner->url); ?>);">

        </div><!-- /.item -->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div><!-- /.owl-carousel -->
</div>