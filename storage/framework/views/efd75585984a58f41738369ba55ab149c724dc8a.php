<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

    <?php $__currentLoopData = $related_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($product->product == null): ?>
    <?php continue; ?>
    <?php endif; ?>
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>">
                            <img  src="assets/images/products/<?php echo e($product->product->getDefaultImage()->image_url); ?>" alt=""></a>
                    </div><!-- /.image -->			

                    <div class="tag sale"><span>sale</span></div>            		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                    <h3 class="name">
                        <a href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>"><?php echo e($product->product->name); ?></a>
                    </h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>

                    <?php ($productPrice = $product->product->getActivePrice()); ?>
                    <div class="product-price">	
                        <span class="price">
                            KShs. <?php echo e($productPrice->offer_price); ?>				
                        </span>
                        <span class="price-before-discount">
                            KShs. <?php echo e($productPrice->standard_price); ?>

                        </span>

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
                                <a class="add-to-cart" href="<?php echo e(url('shop/add_to_wishlist/'.$productPrice->product->id.'/'.$productPrice->id)); ?>" title="Wishlist">
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