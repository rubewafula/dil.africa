<?php ( $elec_categories = \App\Featured_category::where('main_category', 75)->get() ); ?>

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        <?php $__currentLoopData = $elec_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li style="padding-left: 7px;">                                        
            <a href="<?php echo e(url('/shop/category/'.$category->category->slug)); ?>" style="color: #565656;"><?php echo e(ucwords($category->category->name)); ?></a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->