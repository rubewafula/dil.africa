<?php $__env->startSection('content'); ?>

<div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
        <div class="row">

            <?php echo $__env->make('customer::home.sidebar.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <!-- ============================================== CONTENT ============================================== -->
            <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
                <!-- ========================================== SECTION – HERO ========================================= -->

                <?php echo $__env->make('customer::home.main_banner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <!-- ========================================= SECTION – HERO : END ========================================= -->	

                <!-- ============================================== INFO BOXES ============================================== -->
                <div class="info-boxes wow fadeInUp">
                    <div class="info-boxes-inner">
                        <div class="row">
                            <div class="col-md-6 col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">money back</h4>
                                        </div>
                                    </div>	
                                    <h6 class="text">30 Days Money Back Guarantee</h6>
                                </div>
                            </div><!-- .col -->

                            <div class="hidden-md col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">free shipping</h4>
                                        </div>
                                    </div>
                                    <h6 class="text">Shipping on orders over Ksh 10,000</h6>	
                                </div>
                            </div><!-- .col -->

                            <div class="col-md-6 col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">Happy Clients</h4>
                                        </div>
                                    </div>
                                    <h6 class="text">99.9% Satisfaction Rate </h6>	
                                </div>
                            </div><!-- .col -->
                        </div><!-- /.row -->
                    </div><!-- /.info-boxes-inner -->

                </div><!-- /.info-boxes -->
                <!-- ============================================== INFO BOXES : END ============================================== -->
                <!-- ============================================== SCROLL TABS ============================================== -->
                <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">

                    <?php echo $__env->make('customer::home.recommended.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div><!-- /.scroll-tabs -->
                <!-- ============================================== SCROLL TABS : END ============================================== -->
                <!-- ============================================== WIDE PRODUCTS ============================================== -->
                <!-- /.wide-banners -->

                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
                <!-- ============================================== FEATURED PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <h3 class="section-title">Featured products</h3>
                    <?php echo $__env->make('customer::home.featured', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </section><!-- /.section -->
                <!-- ============================================== FEATURED PRODUCTS : END ============================================== -->
                <!-- ============================================== WIDE PRODUCTS ============================================== -->
                <div class="wide-banners wow fadeInUp outer-bottom-xs">
                    <?php echo $__env->make('customer::home.middle_banner_1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div><!-- /.wide-banners -->
                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
                <!-- ============================================== BEST SELLER ============================================== -->

                <div class="best-deal wow fadeInUp outer-bottom-xs">
                    <h3 class="section-title">Top Brands</h3>
                    <?php echo $__env->make('customer::home.top_brands', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div><!-- /.sidebar-widget -->
                <!-- ============================================== BEST SELLER : END ============================================== -->	

                <!-- ============================================== FEATURED PRODUCTS ============================================== -->
                <section class="section wow fadeInUp new-arriavls">
                    <h3 class="section-title">New Arrivals</h3>
                    <?php echo $__env->make('customer::home.new_arrivals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </section><!-- /.section -->
                <!-- ============================================== FEATURED PRODUCTS : END ============================================== -->

            </div><!-- /.homebanner-holder -->
            <!-- ============================================== CONTENT : END ============================================== -->
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL 
        </div><!-- /.container -->
    </div><!-- /#top-banner-and-menu -->

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>