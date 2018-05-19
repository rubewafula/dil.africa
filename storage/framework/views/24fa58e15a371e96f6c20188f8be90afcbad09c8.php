<?php $__env->startSection('content'); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="#">Home</a></li>
                <li><a href="#">Clothing</a></li>
                <li class='active'>OPPO F5,32GB 6.0" - Dual SIM, Black</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            <?php echo $__env->make('customer::product.sidebar.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class='col-md-9'>
                <?php echo $__env->make('customer::product.detail', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="product-tabs inner-bottom-xs  wow fadeInUp">
                    <?php echo $__env->make('customer::product.desc_review', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div><!-- /.product-tabs -->

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <h3 class="section-title">People Who Viewed This Item Also Viewed</h3>
                    <?php echo $__env->make('customer::product.related_products', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>