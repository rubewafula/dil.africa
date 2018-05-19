<div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

    <?php ($featured_products = new \Modules\Customer\Entities\Featured_product()); ?>
    <?php ($products = $featured_products->getFeaturedProducts()); ?>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>"><img  src="assets/images/products/<?php echo e($product->product->getDefaultImage()->image_url); ?>" alt=""></a>
                    </div><!-- /.image -->			

                    <div class="tag hot"><span>hot</span></div>		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                    <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>"><?php echo e($product->product->name); ?></a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>

                    <div class="product-price">	
                        <span class="price">
                            Ksh <?php echo e($product->product->getActivePrice()->offer_price); ?>				
                        </span>
                        <span class="price-before-discount">KSh <?php echo e($product->product->getActivePrice()->standard_price); ?></span>

                    </div><!-- /.product-price -->

                </div><!-- /.product-info -->
                <div class="cart clearfix animate-effect">
                    <div class="action">
                        <ul class="list-unstyled">
                            <li class="add-cart-button btn-group">
                                <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                    <i class="fa fa-shopping-cart"></i>													
                                </button>
                                <button class="btn btn-primary cart-btn" type="button">Add to cart</button>

                            </li>

                            <li class="lnk wishlist">
                                <a class="add-to-cart" href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>" title="Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </li>

                            <li class="lnk">
                                <a class="add-to-cart" href="<?php echo e(url('shop/product/detail/'.$product->id)); ?>" title="Compare">
                                    <i class="fa fa-signal" aria-hidden="true"></i>
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