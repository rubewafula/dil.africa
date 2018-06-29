<?php ( $categories = \Modules\Customer\Entities\Category::where('status', 1)
    ->where('level', 1)->get() ); ?>
<?php ($subCount = 0); ?> 

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($subCount = 0); ?> 
        <li class="dropdown menu-item">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon fa <?php echo e($category->icon); ?>" aria-hidden="true"></i>
                <?php echo e(strtoupper($category->name)); ?>

            </a>
            <ul class="dropdown-menu mega-menu">
                <li class="yamm-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <ul class="links list-unstyled">
                                
                                <?php ($subCategories = \Modules\Customer\Entities\Category::where('depends_on',
                                    $category->id)->where('status', 1)->get()); ?>
                                
                                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ($subCount++); ?>
<!--                                    <?php if($subCount != 1): ?><br/><?php endif; ?>-->
                                    <h2 class="title">
                                        <a href="<?php echo e(url('/shop/category/'.$subCategory->id)); ?>" style="padding:0px;"><?php echo e($subCategory->name); ?></a>
                                    </h2>

                                    <?php ($miniCategories = \Modules\Customer\Entities\Category::where('depends_on', 
                                        $subCategory->id)->where('status', 1)->get()); ?>
                                    <?php $__currentLoopData = $miniCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miniCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                        <li>                                        
                                            <a href="<?php echo e(url('/shop/category/'.$miniCategory->id)); ?>"><?php echo e($miniCategory->name); ?></a>
                                        </li>
                                        <?php ($subCount++); ?>
                                        <?php if($subCount == 8): ?>
                                            </ul>
                                            </div><!-- /.col -->
                                            <div class="col-sm-12 col-md-3">
                                            <ul class="links list-unstyled">
                                            <?php ($subCount=0); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div><!-- /.col -->
                        
                        <div class="dropdown-banner-holder">
                            <a href="#"><img alt="" src="<?php echo e(url('assets/images/banners/categories/'.$category->cover_photo)); ?>" /></a>
                        </div>
                    </div><!-- /.row -->
                </li><!-- /.yamm-content -->                    
            </ul><!-- /.dropdown-menu -->            
        </li><!-- /.menu-item -->
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->
