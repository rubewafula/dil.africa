<?php ($total_count = count($products)); ?>

<?php ($col_count = 0); ?>

<?php if($total_count > 0): ?>
<div class="row" style="padding: 10px 0px 3px 15px;border-bottom: 2px solid #CCC;">   
    Search Results for <span class="blue-fg"><?php echo e(substr($title, 13)); ?></span>
</div>
<?php else: ?>
 <div class="row" style="padding: 10px 0px 3px 15px;font-size: 14px;border-bottom: 2px solid #CCC;">   
    No products found for <span class="blue-fg">"<?php echo e(substr($title, 13)); ?>"</span>. Please try to search using a different criteria.
</div>
<?php endif; ?>

<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php ($product_price = Modules\Customer\Utilities\Utilities::getActivePrice($product->id)); ?>
<?php if(count($product_price) > 0): ?>
<?php if($col_count == 0): ?>
<div class="row"  style="border-bottom: 1px solid #EEE;">
<?php endif; ?>
<?php ($product_image = Modules\Customer\Utilities\Utilities::getDefaultImage($product->id)); ?>
<div class="col-xs-6 col-sm-6 wow fadeInUp">
    <div class="products">
        <div class="product" style="margin-bottom: 5px;">		
            <div class="product-image">
                <div class="image">
                    <a href="<?php echo e(url('shop/product/detail/'.$product->slug)); ?>">
                        <?php if($product_image != null): ?>
                        <div class="featured-img">
                            <span class="helper"></span>
                            <img  class="img-featured" src="<?php echo e(url('assets/images/products/'.$product_image[0]->image_url)); ?>" width="100px" alt="">
                        </div>
                        <?php else: ?>
                        <div class="featured-img">
                            <span class="helper"></span>
                            <img  class="img-featured" src="<?php echo e(url('assets/images/products/no_image.jpg')); ?>" alt="">
                        </div>
                        <?php endif; ?>
                    </a>
                </div><!-- /.image -->			

                <!--
                <div class="tag new">
                    <span>new</span>
                </div> 
                -->                       		   
            </div><!-- /.product-image -->

            <div class="product-info text-left">

                <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$product->slug)); ?>"><?php echo e(ucwords($product->name)); ?></a></h3>
                <div class="rating rateit-small"></div>
                <div class="description"></div>

                <?php if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>

                <div class="product-price"> 
                    
                    <?php if($product_price[0] != null): ?>
                    <?php ($offer_price = $product_price[0]->offer_price); ?>
                    <?php ($standard_price = $product_price[0]->standard_price); ?>
                    <?php ($sale_price = 0); ?>
                    <span class="price">
                    <?php if($offer_price != null && $offer_price != ""): ?>
                    Ksh <?php echo e(number_format($offer_price)); ?>

                    <?php ($sale_price = $offer_price); ?>
                    </span>
                    <span class="price-before-discount">
                        KSh <?php echo e(number_format($standard_price)); ?>

                        <?php ($sale_price = $standard_price); ?>
                    </span> 
                    <?php else: ?> 
                    <span class="price">
                    Ksh <?php echo e(number_format($standard_price)); ?>

                    <?php ($sale_price = $standard_price); ?>
                    <?php endif; ?>      
                    </span>  
                    <?php endif; ?> 
                    
                </div><!-- /.product-price -->

                <?php elseif(count($product_price) > 1 && \Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>

                <?php ($max_price = \Modules\Customer\Utilities\Utilities::getMaximumPrice($product->id)); ?>
                <?php ($min_price = \Modules\Customer\Utilities\Utilities::getMinimumPrice($product->id)); ?>

                <div class="product-price"> 
                        
                    <span class="price">

                        KSh <?php echo e(number_format($min_price)); ?> - KSh <?php echo e(number_format($max_price)); ?>

                        <?php ($sale_price = $max_price); ?>
                    </span>

                </div>

                <?php endif; ?>

                <?php ( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price)); ?>
                <div class="eligible-shipping">
                    <?php echo e($shipping_message); ?>

                </div>

            </div><!-- /.product-info -->

            <?php if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>
            <div class="cart clearfix animate-effect">
                <div class="action">
                    <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                            <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                                <input type="hidden" value="<?php echo e($product_price[0]->id); ?>" name="product_ref" />
                                <input type="hidden" value="1" name="quantity" />
                                <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="<?php echo e($product_price[0]->id); ?>" title="Buy Now">
                                    <i class="fa fa-shopping-cart"></i>                                                 
                                </button>
                                <button class="btn btn-primary cart-btn" type="button">Buy Now</button>
                            </form>
                        </li>

                        <li class="lnk wishlist">
                            <a class="add-to-cart" href="<?php echo e(url('shop/add_to_wishlist/'.$product->id.'/'.$product_price[0]->id)); ?>" title="Wishlist">
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
<?php ($col_count++); ?>
<?php if($col_count == 2): ?>
</div>
<?php ($col_count = 0); ?>
<?php endif; ?>
<?php else: ?>
<?php ($total_count -= 1); ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($total_count%2 != 0): ?>
</div>
<?php endif; ?>