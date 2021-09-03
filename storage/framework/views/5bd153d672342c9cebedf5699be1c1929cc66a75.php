<div class="product-slider">
    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme">
        
        <?php $__currentLoopData = $category->popular_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($product->product == null): ?>
        <?php continue; ?>
        <?php endif; ?>
        <div class="item item-carousel">
            <div class="products">

                <div class="product">		
                    <div class="product-image">
                        <div class="image">
                            <a href="<?php echo e(url('shop/product/detail/'.$product->product->slug)); ?>">
                                <div class="featured-img">
                                    <span class="helper"></span>
                                    <img  class="img-featured" src="<?php echo e(url('assets/images/products/'.$product->product->getDefaultImage()->image_url)); ?>" alt="">
                                </div>
                            </a>
                        </div><!-- /.image -->			

                       <!-- <div class="tag sale"><span>sale</span></div> -->           		   
                    </div><!-- /.product-image -->


                    <div class="product-info text-left">
                        <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$product->product->slug)); ?>"><?php echo e($product->product->name); ?></a></h3>
                        <div class="rating rateit-small"></div>
                        <div class="description"></div>

                        <?php ($product_price = $product->product->getActivePrice()); ?>

                        <?php if(count($product_price) == 1 || !$product->product->hasDifferentPrices()): ?>

                        <div class="product-price"> 
                            
                            <?php if($product_price->first() != null): ?>
                            <?php ($offer_price = $product_price->first()->offer_price); ?>
                            <?php ($standard_price = $product_price->first()->standard_price); ?>
                            <?php ($sale_price = 0); ?>
                            <span class="price">
                            <?php if($offer_price != null && $offer_price != ""): ?>
                            Ksh <?php echo e(number_format($offer_price + $product->product->getShippingCost())); ?>

                            <?php ($sale_price = $offer_price); ?>
                            </span> <span class="price-before-discount">
                                KSh <?php echo e(number_format($standard_price + $product->product->getShippingCost())); ?>

                                <?php ($sale_price = $standard_price); ?>
                            </span> 
                            <?php else: ?> 
                            <span class="price">
                            Ksh <?php echo e(number_format($standard_price + $product->product->getShippingCost())); ?>

                            <?php ($sale_price = $standard_price); ?>
                            <?php endif; ?>      
                            </span>  
                            <?php endif; ?> 
                            
                        </div><!-- /.product-price -->

                        <?php elseif(count($product_price) > 1 && $product->product->hasDifferentPrices()): ?>

                        <?php ($max_price = $product->product->getMaximumPrice()); ?>
                        <?php ($min_price = $product->product->getMinimumPrice()); ?>

                        <div class="product-price"> 
                                
                                <span class="price">

                                    KSh <?php echo e(number_format($min_price + $product->product->getShippingCost())); ?> - KSh <?php echo e(number_format($max_price + $product->product->getShippingCost())); ?>

                                    <?php ($sale_price = $max_price); ?>
                                </span>

                        </div>

                        <?php endif; ?>

                        <?php ( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price)); ?>
                        <div class="eligible-shipping">
                            <?php echo e($shipping_message); ?>

                        </div>

                    </div><!-- /.product-info -->

                    <?php if(count($product_price) == 1 || !$product->product->hasDifferentPrices()): ?>
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                                        <input type="hidden" value="<?php echo e($product->product->getActivePrice()->first()->id); ?>" name="product_ref" />
                                        <input type="hidden" value="1" name="quantity" />
                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="<?php echo e($product->product->getActivePrice()->first()->id); ?>" title="Add Cart">
                                            <i class="fa fa-shopping-cart"></i>													
                                        </button>
                                        <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                    </form>
                                </li>

                                <li class="lnk wishlist">
                                    <a class="add-to-cart" href="<?php echo e(url('shop/add_to_wishlist/'.$product->product->id.'/'.$product->product->getActivePrice()->first()->id)); ?>" title="Add to Wishlist">
                                        <i class="icon fa fa-heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.action -->
                    </div><!-- /.cart -->
                    <?php endif; ?>
                </div><!-- /.product -->

            </div><!-- /.products -->
        </div><!-- /.item -->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div><!-- /.home-owl-carousel -->
</div><!-- /.product-slider -->