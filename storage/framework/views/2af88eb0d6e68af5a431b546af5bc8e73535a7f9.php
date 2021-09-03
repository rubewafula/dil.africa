<div class="more-info-tab clearfix">
    <h3 class="new-product-title pull-left">Recomended For You</h3>
    <ul class="nav nav-tabs nav-tab-line pull-right hidden-xs hidden-sm" id="new-products-1">
        <li class="active"><a style="font-size: 15px;color: #ffa200;" data-transition-type="backSlide" href="#all" data-toggle="tab">Most Popular</a></li>
        <?php ($popular_categories = \Modules\Customer\Entities\Category::where('is_popular',1)->orderBy('id', 'DESC')->limit(3)->get()); ?>
        
        <?php $__currentLoopData = $popular_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a style="font-size: 15px;color: #ffa200;" data-transition-type="backSlide" href="#<?php echo e($category->id); ?>" data-toggle="tab">Top In <?php echo e($category->name); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul><!-- /.nav-tabs -->
</div>

<div class="tab-content outer-top-xs">
    <div class="tab-pane in active" id="all">			
        <?php echo $__env->make('customer::home.recommended.popular', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->
    
    <?php $__currentLoopData = $popular_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="tab-pane  hidden-xs hidden-sm" id="<?php echo e($category->id); ?>">
        <?php echo $__env->make('customer::home.recommended.popular_category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><!-- /.tab-content -->