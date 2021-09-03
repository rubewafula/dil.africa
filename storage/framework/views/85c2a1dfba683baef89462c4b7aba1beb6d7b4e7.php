<!-- ============================================== SIDEBAR ============================================== -->	
<div class="col-xs-12 col-sm-12 col-md-3 sidebar">

    <!-- ================================== TOP NAVIGATION ================================== -->
    <div class="side-menu animate-dropdown outer-bottom-xs hidden-xs">
        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>        
        <?php echo $__env->make('customer::home.sidebar.categories', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div><!-- /.side-menu -->
    <!-- ================================== TOP NAVIGATION : END ================================== -->

    <div class="hidden-xs" style="margin-bottom:20px">
        <?php echo $__env->make('customer::home.sidebar.banner_1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div> 

    <!-- ============================================== HOT DEALS ============================================== -->
    <div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs hidden-xs hidden-sm">
        <h3 class="section-title">hot deals</h3>
        <?php echo $__env->make('customer::home.sidebar.hot_deals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <!-- ============================================== HOT DEALS: END ============================================== -->

    <!-- ============================================== SPECIAL OFFER ============================================== -->

    <div class="sidebar-widget outer-bottom-small wow fadeInUp hidden-xs hidden-sm">
        <h3 class="section-title">Special Offer</h3>
        <?php echo $__env->make('customer::home.sidebar.special_offers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== SPECIAL OFFER : END ============================================== -->

    <!-- <div class="sidebar-widget product-tag outer-bottom-xs wow fadeInUp">
        <h3 class="sectsion-title">Product tags</h3>
        <?php echo $__env->make('customer::home.sidebar.product_tags', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div> -->

    <!-- ============================================== NEWSLETTER ============================================== -->
    <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small hidden-xs">
        <h3 class="section-title">Newsletters</h3>
        <?php echo $__env->make('customer::layouts.newsletter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== NEWSLETTER: END ============================================== -->

    <!-- ============================================== Testimonials============================================== -->
    <div class="sidebar-widget  wow fadeInUp outer-top-vs hidden-xs" style="padding-bottom: 36px;">
        <h3 class="section-title">Electronics</h3>
        <?php echo $__env->make('customer::home.sidebar.electronics', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- ============================================== Testimonials: END ============================================== -->
</div><!-- /.sidemenu-holder -->
<!-- ============================================== SIDEBAR : END ============================================== -->