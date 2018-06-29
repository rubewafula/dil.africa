<div class="detail-block">
    <div class="row  wow fadeInUp">

        <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
            <div class="product-item-holder size-big single-product-gallery small-gallery">

                <?php ( $images = $product->getProductImages() ); ?>
                <?php ( $count = 0 ); ?>

                <div id="owl-single-product">

                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                    <div class="single-product-gallery-item" id="slide<?php echo e($count); ?>">
                        <a data-lightbox="image-1" data-title="Gallery" href="<?php echo e(url('assets/images/products/'.$image->image_url)); ?>">
                            <img class="img-responsive" alt="" src="<?php echo e(url('assets/images/blank.gif')); ?>" data-echo="<?php echo e(url('assets/images/products/'.$image->image_url)); ?>" />
                        </a>
                    </div><!-- /.single-product-gallery-item -->
                    <?php ( $count++); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div><!-- /.single-product-slider -->


                <div class="single-product-gallery-thumbs gallery-thumbs">

                    <?php ( $count = 0 ); ?>
                    <div id="owl-single-product-thumbnails">
                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="<?php echo e($count); ?>" href="#slide<?php echo e($count); ?>">
                                <img class="img-responsive" width="85" alt="" src="<?php echo e(url('assets/images/blank.gif')); ?>" data-echo="<?php echo e(url('assets/images/products/'.$image->image_url)); ?>" />
                            </a>
                        </div>
                        <?php ( $count++); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div><!-- /#owl-single-product-thumbnails -->

                </div><!-- /.gallery-thumbs -->

            </div><!-- /.single-product-gallery -->
        </div><!-- /.gallery-holder -->        			
        <div class='col-sm-6 col-md-7 product-info-block'>
            <div class="product-info">
                <h1 class="name"><?php echo e($product->name); ?></h1>

                <div class="rating-reviews m-t-20">
                    <div class="row">
                        <div class="col-sm-3">
<!--                            <div class="rating rateit-small"></div>-->
                                <?php ($reviews = $product->getProductReviews()); ?>
                                <?php ($count = count($reviews)); ?>
                                Average Rating
                                <?php if($count > 0): ?>
                                <?php ($average_rating = round($reviews->sum('rating')/$count)); ?>
                                <?php for($i = 0; $i < $average_rating; $i++): ?>
                                <img src="<?php echo e(url('assets/images/star-on.png')); ?>"/>
                                <?php endfor; ?>
                                <?php endif; ?>
                        </div>
                        <div class="col-sm-8">
                            <div class="reviews">                                                            
                                <!--<a href="#" class="lnk">-->
                                (<?php echo e($count); ?> <?php if($count > 1): ?> Reviews <?php else: ?> Review <?php endif; ?> <span style="color:#FFA200"> - scroll down to view the specific reviews</span>)
                                <!--</a>-->
                            </div>
                        </div>
                    </div><!-- /.row -->		
                </div><!-- /.rating-reviews -->

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Availability :</span>
                            </div>	
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box">
                                <span class="value">

                                    <?php if($product->isAvailable()): ?>
                                    In Stock
                                    <?php else: ?>
                                    Out of Stock
                                    <?php endif; ?>
                                </span>
                            </div>	
                        </div>
                    </div><!-- /.row -->	
                </div><!-- /.stock-container -->

                <div class="description-container m-t-20">
                    <h3>Key  Features</h3>
                    <ul type="disc">
                        
                        <?php $__currentLoopData = $product->product_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li> 
                         <?php if($feature->feature_type_id  == 3): ?>
                           <?php echo e($feature->value); ?>

                         <?php else: ?>
                          <strong> <?php echo e($feature->feature_type->name); ?>: </strong> <?php echo e($feature->value); ?> 
                         <?php endif; ?>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div><!-- /.description-container -->


                <div class="price-container info-container m-t-20">
                    <div class="row">
                        <?php ($product_price = $product->getActivePrice()); ?>
                        <div class="col-sm-6">
                            <div class="price-box">
                                <span class="price">Ksh. <?php echo e($product_price->offer_price); ?> </span>
                                <span class="price-strike">Ksh <?php echo e($product_price->standard_price); ?></span>
                                <input type="hidden" value="<?php echo e($product->id); ?>" id="product_ref" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="favorite-button m-t-10">
                                <a class="btn btn-primary" href="<?php echo e(url('shop/add_to_wishlist/'.$product->id.'/'.$product_price->id)); ?>" title="Add to Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
<!--                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="E-mail" href="#">
                                    <i class="fa fa-envelope"></i>
                                </a>-->
                            </div>
                        </div>

                    </div><!-- /.row -->
                </div><!-- /.price-container -->

                <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                    <div class="quantity-container info-container">
                        <div class="row">

                            <div class="col-sm-2">
                                <span class="label">Qty :</span>
                            </div>

                            <div class="col-sm-2">
                                <div class="cart-quantity">
                                    <div class="quant-input">
                                        <div class="arrows">
                                            <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                            <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                        </div>
                                        <input type="text" name="quantity" value="1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-7">
                                
                                <input type="hidden" value="<?php echo e($product_price->id); ?>" name="product_ref" />
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                </button>
                                
                            </div>

                        </div><!-- /.row -->
                    </div><!-- /.quantity-container -->
                </form>

            </div><!-- /.product-info -->
        </div><!-- /.col-sm-7 -->
    </div><!-- /.row -->
</div>