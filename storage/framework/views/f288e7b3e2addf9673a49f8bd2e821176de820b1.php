<div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">

    <?php ($hot_deal = new \Modules\Customer\Entities\Hot_deal()); ?>
    <?php ($deals = $hot_deal->getHotDeals()); ?>

    <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($deal->product == null): ?>
    <?php continue; ?>
    <?php endif; ?>
    <div class="item">
        <div class="products">
            <div class="hot-deal-wrapper">
                <div class="image">
                    <img src="assets/images/products/<?php echo e($deal->product->getDefaultImage()->image_url); ?>" alt="">
                </div>
                <div class="sale-offer-tag"><span><?php echo e($deal->discount); ?>%<br>off</span></div>
                <?php ($expires_on = strtotime($deal->expires_on)); ?>
                <?php ($now = strtotime(date('Y-m-d H:i:s'))); ?>
                <?php ($remaining = $expires_on - $now); ?>
                <?php ($days_with_decimal = $remaining / 86400); ?>
                <?php ($days = floor($days_with_decimal)); ?>
                <?php ($hours_in_decimal = ($days_with_decimal - $days) * 24); ?>
                <?php ($hours = floor($hours_in_decimal)); ?>
                <?php ($minutes_in_decimal = ($hours_in_decimal - $hours) * 60); ?>
                <?php ($minutes = floor($minutes_in_decimal)); ?>
                <?php ($seconds_in_decimal = ($minutes_in_decimal - $minutes) * 60); ?>
                <?php ($seconds = floor($seconds_in_decimal)); ?>
                
                <div class="timing-wrapper">
                    <div class="box-wrapper">
                        <div class="date box">
                            <span class="key"><?php echo e($days); ?></span>
                            <span class="value"><?php echo e(($days > 1)?"DAYS":"DAY"); ?></span>
                        </div>
                    </div>

                    <div class="box-wrapper">
                        <div class="hour box">
                            <span class="key"><?php echo e($hours); ?></span>
                            <span class="value"><?php echo e(($hours > 1)?"HRS":"HR"); ?></span>
                        </div>
                    </div>

                    <div class="box-wrapper">
                        <div class="minutes box">
                            <span class="key"><?php echo e($minutes); ?></span>
                            <span class="value"><?php echo e(($minutes > 1)?"MINS":"MIN"); ?></span>
                        </div>
                    </div>

                    <div class="box-wrapper hidden-md">
                        <div class="seconds box">
                            <span class="key"><?php echo e($seconds); ?></span>
                            <span class="value"><?php echo e(($seconds > 1)?"SECS":"SEC"); ?></span>
                        </div>
                    </div>
                </div>
            </div><!-- /.hot-deal-wrapper -->

            <div class="product-info text-left m-t-20">
                <h3 class="name"><a href="<?php echo e(url('shop/product/detail/'.$deal->product_id)); ?>"><?php echo e($deal->product->name); ?> </a></h3>
                <div class="rating rateit-small"></div>

                <div class="product-price">	
                    <span class="price">
                        <?php echo e($deal->offer_price); ?>

                    </span>

                    <span class="price-before-discount"><?php echo e($deal->price_before); ?></span>					

                </div><!-- /.product-price -->

            </div><!-- /.product-info -->
            <?php ($productPrice = $deal->product->getActivePrice()); ?>

            <div class="cart clearfix animate-effect">
                <div class="action">

                    <div class="add-cart-button btn-group">
                        <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                            <input type="hidden" value="<?php echo e($productPrice->id); ?>" name="product_ref" />
                            <input type="hidden" value="1" name="quantity" />
                            <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="<?php echo e($productPrice->id); ?>" title="Add Cart">
                                <i class="fa fa-shopping-cart"></i>													
                            </button>
                            <button class="btn btn-primary cart-btn" type="submit">Add to cart</button>
                        </form>

                    </div>

                </div><!-- /.action -->
            </div><!-- /.cart -->
        </div>	
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   	        
    
</div><!-- /.sidebar-widget -->