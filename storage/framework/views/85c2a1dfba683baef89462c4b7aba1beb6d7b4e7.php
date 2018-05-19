<!-- ============================================== SIDEBAR ============================================== -->	
<div class="col-xs-12 col-sm-12 col-md-3 sidebar">

    <!-- ================================== TOP NAVIGATION ================================== -->
    <div class="side-menu animate-dropdown outer-bottom-xs">
        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>        
        <?php echo $__env->make('customer::home.sidebar.categories', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div><!-- /.side-menu -->
    <!-- ================================== TOP NAVIGATION : END ================================== -->

    <div style="margin-bottom:15px">
        <?php echo $__env->make('customer::home.sidebar.banner_1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div> 

    <!-- ============================================== HOT DEALS ============================================== -->
    <div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs">
        <h3 class="section-title">hot deals</h3>
        <?php echo $__env->make('customer::home.sidebar.hot_deals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <!-- ============================================== HOT DEALS: END ============================================== -->


    <!-- ============================================== SPECIAL OFFER ============================================== -->

    <div class="sidebar-widget outer-bottom-small wow fadeInUp">
        <h3 class="section-title">Special Offer</h3>
        <?php echo $__env->make('customer::home.sidebar.special_offers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== SPECIAL OFFER : END ============================================== -->
    <!-- ============================================== PRODUCT TAGS ============================================== -->
    <div class="sidebar-widget product-tag wow fadeInUp">
        <h3 class="section-title">Product tags</h3>
        <?php echo $__env->make('customer::home.sidebar.product_tags', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== PRODUCT TAGS : END ============================================== -->

    <!-- ============================================== NEWSLETTER ============================================== -->
    <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small">
        <h3 class="section-title">Newsletters</h3>
        <?php echo $__env->make('customer::layouts.newsletter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== NEWSLETTER: END ============================================== -->

    <!-- ============================================== Testimonials============================================== -->
    <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
        <?php echo $__env->make('customer::layouts.testimonials', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- ============================================== Testimonials: END ============================================== -->
</div><!-- /.sidemenu-holder -->
<!-- ============================================== SIDEBAR : END ============================================== -->
