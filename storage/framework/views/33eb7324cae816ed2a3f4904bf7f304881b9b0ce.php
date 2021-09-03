<?php ( $categories = \Modules\Customer\Utilities\Utilities::getMainCategoriesAll() ); ?>
<?php ($subCount = 0); ?> 

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($category->getNoOfProducts() < 3): ?>
        <?php continue; ?>;
        <?php endif; ?>
        <?php ($subCount = 0); ?> 
        <li class="dropdown menu-item">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon fa <?php echo e($category->icon); ?>" aria-hidden="true"></i>
                <?php echo e((strlen($category->name) > 20)?substr(strtoupper($category->name),0, 20).'..':strtoupper($category->name)); ?>

            </a>
            <ul class="dropdown-menu mega-menu">
                <li class="yamm-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <ul class="links list-unstyled">
                                
                                <?php ($subCategories = $category->getSubCategories()); ?>
                                
                                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subCategory->getNoOfProducts() < 3): ?>
                                <?php continue; ?>;
                                <?php endif; ?>
                                    <?php ($subCount++); ?>
                                    <?php if($subCount == 8): ?>
                                            </ul>
                                            </div><!-- /.col -->
                                            <div class="col-sm-12 col-md-3">
                                            <ul class="links list-unstyled">
                                            <?php ($subCount=0); ?>
                                        <?php endif; ?>
                                    <h2 class="title">
                                        <a href="<?php echo e(url('/shop/category/'.$subCategory->slug)); ?>" style="padding:10px 0px 0px 0px;font-weight: normal;"><?php echo e(strtoupper($subCategory->name)); ?></a>
                                    </h2>

                                    <?php ($miniCategories = $subCategory->getSubCategories()); ?>
                                    
                                    <?php $__currentLoopData = $miniCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miniCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($miniCategory->getNoOfProducts() < 3): ?>
                                        <?php continue; ?>;
                                        <?php endif; ?>
                                        <li style="padding-left: 7px;">                                        
                                            <a href="<?php echo e(url('/shop/category/'.$miniCategory->slug)); ?>"><?php echo e(ucwords($miniCategory->name)); ?></a>
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
                        
                        <!-- <div class="dropdown-banner-holder">
                            <a href="#"><img alt="" src="<?php echo e(url('assets/images/banners/categories/'.$category->cover_photo)); ?>" /></a>
                        </div> -->
                    </div><!-- /.row -->
                </li><!-- /.yamm-content -->                    
            </ul><!-- /.dropdown-menu -->            
        </li><!-- /.menu-item -->
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->
