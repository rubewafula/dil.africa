<div class='col-md-3 sidebar'>
    <div class="sidebar-module-container">
        <div class="home-banner outer-top-n"> <a href="#"><img src="<?php echo e(url('assets/images/cash-on-delivery.png')); ?>" alt="cash-on-delivery"></a>
            <a href="#"><img src="<?php echo e(url('assets/images/genuine-products.png')); ?>" alt="genuine-products"></a>
            <a href="#"><img src="<?php echo e(url('assets/images/FAQs.png')); ?>" alt="FAQS"></a>
        </div>		

        <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small outer-top-vs">
            <h3 class="section-title">Newsletters</h3>           
            <?php echo $__env->make('customer::layouts.newsletter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div><!-- /.sidebar-widget -->
        <!-- ============================================== NEWSLETTER: END ============================================== -->

        <!-- ============================================== Testimonials============================================== -->
        <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
            <?php echo $__env->make('customer::layouts.testimonials', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <!-- ============================================== Testimonials: END ============================================== -->

    </div>
</div><!-- /.sidebar -->