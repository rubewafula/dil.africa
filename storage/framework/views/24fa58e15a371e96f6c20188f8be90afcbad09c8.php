<?php $__env->startSection('content'); ?>

<?php ($mini_category = $product->category); ?>
<?php ($mini_category_name = $mini_category->name); ?>
<?php ($sub_category = \Modules\Customer\Entities\Category::find($mini_category->depends_on)); ?>
<?php ($category = \Modules\Customer\Entities\Category::find($sub_category->depends_on)); ?>

<div class="breadcrumb" style="margin-bottom: 0px;">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/shop')); ?>">Home</a></li>
                <?php if($category != null): ?>
                <li><a href="<?php echo e(url('shop/category/'.$category->id)); ?>"><?php echo e($category->name); ?></a></li>
                <?php endif; ?>
                <?php if($sub_category != null): ?>
                <li><a href="<?php echo e(url('shop/category/'.$sub_category->id)); ?>"><?php echo e($sub_category->name); ?></a></li>
                <?php endif; ?>
                <?php if($mini_category != null): ?>
                <li><a href="<?php echo e(url('shop/category/'.$mini_category->id)); ?>"><?php echo e($mini_category_name); ?></a></li>
                <?php endif; ?>
                <li class='active'><?php echo e($product->name); ?></li>
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