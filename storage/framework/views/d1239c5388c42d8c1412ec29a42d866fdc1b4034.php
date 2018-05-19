<?php ($product_tags = \Modules\Customer\Entities\Product_tag::get()); ?>
<div class="sidebar-widget-body outer-top-xs">
    <div class="tag-list">
        <?php $__currentLoopData = $product_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($tagname = \Modules\Customer\Entities\Tag::find($product_tag->tag_id)->name); ?>
        <a class="item" title="<?php echo e($tagname); ?>" href="products/tag/<?php echo e($product_tag->tag_id); ?>"><?php echo e($tagname); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div><!-- /.tag-list -->
</div><!-- /.sidebar-widget-body -->