    <!-- ================================== TOP NAVIGATION ================================== -->
    <!-- /.side-menu -->
    <!-- ================================== TOP NAVIGATION : END ================================== -->	            <div class="sidebar-module-container">

        <div class="sidebar-filter">
            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
            <div class="sidebar-widget wow fadeInUp">
                <h3 class="section-title">shop by</h3>
                <div class="widget-header">
                    <h4 class="widget-title"> <?php echo e(isset($category)?$category->name:"Categories"); ?> </h4>
                </div>
                <div class="sidebar-widget-body">
                    <div class="accordion">
                        <?php if(isset($category)): ?>
                        <?php ( $childcategories = $category->getSubCategories() ); ?>
                        <?php else: ?>
                        <?php ( $childcategories = \Modules\Customer\Entities\Category::where('status', 1)
                                ->where('level', 1)->get() ); ?>
                        <?php endif; ?> 
                        <?php ($count=0); ?> 
                        <?php $__currentLoopData = $childcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($count++); ?>
                        <?php ($sub_categories = $child->getSubCategories()); ?>
                        <?php if(count($sub_categories) > 0): ?>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#collapse<?php echo e($count); ?>" data-toggle="collapse" class="accordion-toggle collapsed">
                                    <?php echo e($child->name); ?>

                                </a>
                            </div><!-- /.accordion-heading -->
                            
                            <div class="accordion-body collapse" id="collapse<?php echo e($count); ?>" style="height: 0px;">
                                <div class="accordion-inner">
                                    <ul>
                                        <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url('/shop/category/'.$sub_cat->slug)); ?>"><?php echo e($sub_cat->name); ?></a></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div><!-- /.accordion-inner -->
                            </div><!-- /.accordion-body -->
                        </div><!-- /.accordion-group -->
                        <?php else: ?>
                        <div style="padding: 2px 7px;"> 
                            - <a style="color: #666666;" href="<?php echo e(url('/shop/category/'.$child->slug)); ?>"><?php echo e($child->name); ?></a>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div><!-- /.accordion -->
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->

            <!-- ============================================== PRICE SILDER============================================== -->
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Price Slider</h4>
                </div>
                <div class="sidebar-widget-body m-t-10">
                    <div class="price-range-holder">
                        <span class="min-max">
                            <span class="pull-left">KES <?php echo e($minimum_price); ?></span>
                            <span class="pull-right">KES <?php echo e($maximum_price); ?></span>
                        </span>
                        <input type="text" id="amount" style="border:0; color:#666666; font-weight:bold;text-align:center;"/>

                        <input type="text" id="price-slider-id" class="price-slider" value="" >

                    </div><!-- /.price-range-holder -->
                    <button id="show_now" class="lnk btn btn-primary">Show Now</button>
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <!-- ============================================== PRICE SILDER : END ============================================== -->
            <!-- ============================================== MANUFACTURES============================================== -->
            <?php if(count($brands) > 0): ?>
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Brands</h4>
                </div>
                <div class="sidebar-widget-body">
                    <ul class="list">
                        <?php ($brands_array = []); ?>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!in_array($brand->brand_name, $brands_array)): ?>
                        <li>
                            <a href="<?php echo e(url('/shop/brand/'.$brand->brand_slug)); ?>"><?php echo e(ucfirst($brand->brand_name)); ?></a>
                        </li>
                        <?php (array_push($brands_array, $brand->brand_name)); ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <!--<a href="#" class="lnk btn btn-primary">Show Now</a>-->
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <?php endif; ?>
            
            <!-- ============================================== MANUFACTURES: END ============================================== -->
            <!-- ============================================== COLOR============================================== -->
            <?php if(count($colors) > 0): ?>
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Colors</h4>
                </div>
                <div class="sidebar-widget-body">
                    <ul class="list">
                        <?php ($colors_array = []); ?>
                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!in_array(strtoupper(trim($color->color)), $colors_array)): ?>
                        <li>
                            <?php if(isset($category)): ?>
                            <a href="<?php echo e(url('/shop/category/search/color/'.$category->slug.'/'.$color->id)); ?>"><?php echo e(ucwords(strtolower($color->color))); ?></a>
                            <?php else: ?>
                            <a href="<?php echo e(url('/shop/category/search/color/custom-search/'.$color->id)); ?>"><?php echo e(ucwords(strtolower($color->color))); ?></a>
                            <?php endif; ?>
                        </li>
                        <?php (array_push($colors_array, strtoupper(trim($color->color)))); ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <?php endif; ?>
            <!-- ============================================== COLOR: END ============================================== -->
            <!-- ============================================== COMPARE============================================== -->
<!--            <div class="sidebar-widget wow fadeInUp outer-top-vs">
                <h3 class="section-title">Compare products</h3>
                <div class="sidebar-widget-body">
                    <div class="compare-report">
                        <p>You have no <span>item(s)</span> to compare</p>
                    </div> /.compare-report 
                </div> /.sidebar-widget-body 
            </div> /.sidebar-widget -->


        </div><!-- /.sidebar-filter -->

    </div>