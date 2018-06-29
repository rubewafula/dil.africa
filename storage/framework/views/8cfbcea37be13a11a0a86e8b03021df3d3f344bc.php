<div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

    <?php ($new_arrival = new \Modules\Customer\Entities\New_arrival()); ?>
    <?php ($arrivals = $new_arrival->getNewArrivals()); ?>

    <?php $__currentLoopData = $arrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arrival): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($arrival->product == null): ?>
    <?php continue; ?>
    <?php endif; ?>
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="<?php echo e(url('shop/product/detail/'.$arrival->product_id)); ?>">
                            <img  src="assets/images/products/<?php echo e($arrival->product->getDefaultImage()->image_url); ?>" alt="">
                        </a>
                    </div><!-- /.image -->			

                    <div class="tag new"><span>new</span></div>                        		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                    <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$arrival->product_id)); ?>"><?php echo e($arrival->product->name); ?></a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>

                    <?php ($productPrice = $arrival->product->getActivePrice()); ?>
                    <div class="product-price">	
                        <span class="price">
                            Ksh <?php echo e($productPrice->offer_price); ?>				
                        </span>
                        <span class="price-before-discount">
                            Ksh <?php echo e($productPrice->standard_price); ?>

                        </span>
                        <input type="hidden" value="<?php echo e($arrival->id); ?>" id="product_arrivals_ref" />
                    </div><!-- /.product-price -->

                </div><!-- /.product-info -->
                <div class="cart clearfix animate-effect">
                    <div class="action">
                        <ul class="list-unstyled">
                            <li class="add-cart-button btn-group">
                                <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                                    <input type="hidden" value="<?php echo e($productPrice->id); ?>" name="product_ref" />
                                    <input type="hidden" value="1" name="quantity" />
                                    <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="<?php echo e($productPrice->id); ?>" title="Add Cart">
                                        <i class="fa fa-shopping-cart"></i>													
                                    </button>
                                    <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                </form>
                            </li>

                            <li class="lnk wishlist">
                                <a class="add-to-cart" href="<?php echo e(url('shop/add_to_wishlist/'.$arrival->product->id.'/'.$productPrice->id)); ?>" title="Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.action -->
                </div><!-- /.cart -->
            </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><!-- /.home-owl-carousel -->