<div class="row" style="padding: 10px 0px 0px 15px;">
    Search Results for <span class="blue-fg"><?php echo e(substr($title, 13)); ?></span>
</div>

<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(count(Modules\Customer\Utilities\Utilities::getActivePrice($product->id)) == 0): ?>
<?php continue; ?>
<?php endif; ?>
<?php ($product_image = Modules\Customer\Utilities\Utilities::getDefaultImage($product->id)); ?>
<div class="category-product-inner wow fadeInUp">
    <div class="products">
        <div class="product-list product">
            <div class="row product-list-row">
                <div class="col col-sm-4 col-lg-4">
                    <div class="product-image">
                        <div class="image">
                            <a href="<?php echo e(url('shop/product/detail/'.$product->slug)); ?>">
                                <?php if($product_image != null): ?>
                                <div class="featured-img">
                                    <span class="helper"></span>
                                    <img class="img-featured" src="<?php echo e(url('assets/images/products/'.$product_image[0]->image_url)); ?>" width="100px" alt="">
                                </div>
                                <?php else: ?>
                                <div class="featured-img">
                                    <span class="helper"></span>
                                    <img class="img-featured" src="<?php echo e(url('assets/images/products/no_image.jpg')); ?>" alt="">
                                </div>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div><!-- /.product-image -->
                </div><!-- /.col -->
                <div class="col col-sm-8 col-lg-8">
                    <div class="product-info">
                        <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$product->slug)); ?>">
                                <?php echo e(ucwords($product->name)); ?>

                            </a></h3>
                        <div class="rating rateit-small"></div>
                        <?php ($product_price = Modules\Customer\Utilities\Utilities::getActivePrice($product->id)); ?>

                        <?php if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>

                        <div class="product-price">

                            <?php if($product_price[0] != null): ?>
                            <?php ($offer_price = $product_price[0]->offer_price); ?>
                            <?php ($standard_price = $product_price[0]->standard_price); ?>
                            <?php ($sale_price = 0); ?>
                            <span class="price">
                                <?php if($offer_price != null && $offer_price != ""): ?>
                                Ksh <?php echo e(number_format($offer_price + $product->getShippingCost())); ?>

                                <?php ($sale_price = $offer_price); ?>
                            </span>
                            <span class="price-before-discount">
                                KSh <?php echo e(number_format($standard_price + $product->getShippingCost())); ?>

                                <?php ($sale_price = $standard_price); ?>
                            </span>
                            <?php else: ?>
                            <span class="price">
                                Ksh <?php echo e(number_format($standard_price + $product->getShippingCost())); ?>

                                <?php ($sale_price = $standard_price); ?>
                                <?php endif; ?>
                            </span>
                            <?php endif; ?>

                        </div><!-- /.product-price -->

                        <?php elseif(count($product_price) > 1 && Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>

                        <?php ($max_price = \Modules\Customer\Utilities\Utilities::getMaximumPrice($product->id)); ?>
                        <?php ($min_price = \Modules\Customer\Utilities\Utilities::getMinimumPrice($product->id)); ?>
                        <div class="product-price">

                            <span class="price">

                                KSh <?php echo e(number_format($min_price + $product->getShippingCost())); ?> - KSh <?php echo e(number_format($max_price + $product->getShippingCost())); ?>

                                <?php ($sale_price = $max_price); ?>
                            </span>

                        </div>

                        <?php endif; ?>

                        <?php ( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price)); ?>
                        <div class="eligible-shipping">
                            <?php echo e($shipping_message); ?>

                        </div>

                        <div class="description m-t-10">
                            <?php ($product_features = \Modules\Customer\Utilities\Utilities::product_features($product->id)); ?>

                            <?php if(!is_null($product_features)): ?>
                            <?php if(count($product_features) > 0): ?>
                            <h3>Key Features</h3>
                            <?php $__currentLoopData = $product_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php if($feature->feature_type_id == 3): ?>
                                <?php echo e($feature->value); ?>

                                <?php else: ?>
                                <strong> <?php echo e(($feature->feature_type != null)?$feature->feature_type->name: 'General'); ?>: </strong> <?php echo e($feature->value); ?>

                                <?php endif; ?>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php if(count($product_price) == 1 || !\Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id)): ?>
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

                    </div><!-- /.product-info -->
                </div><!-- /.col -->
            </div><!-- /.product-list-row -->
            <div class="tag new"><span>new</span></div>
        </div><!-- /.product-list -->
    </div><!-- /.products -->
</div><!-- /.category-product-inner -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>