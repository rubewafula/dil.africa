<div class="row">

    <?php ($banner = new \Modules\Customer\Entities\Promotion_banner()); ?>
    <?php ($middle_banner = $banner->getMiddleBanner_1()); ?>
    
    <div class="col-md-12">
        <div class="wide-banner cnt-strip">
            <div class="image">
                <img class="img-responsive" src="assets/images/banners/<?php echo e($middle_banner->url); ?>" alt="">
            </div>	
            <div class="strip strip-text">
                <div class="strip-inner">
                    <h2 class="text-right">
                        <span class="shopping-needs"></span></h2>
                </div>	
            </div>
            <div class="new-label">
                <div class="text"></div>
            </div><!-- /.new-label -->
        </div><!-- /.wide-banner -->
    </div><!-- /.col -->

</div><!-- /.row -->