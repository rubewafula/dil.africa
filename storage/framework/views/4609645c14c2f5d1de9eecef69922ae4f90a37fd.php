<style>
    .product .cart .action ul li.lnk.wishlist {
        padding: 10px 2px;
    }
</style>

<div class="row">
    <div class="col-sm-6 hidden-xs">
        
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
   <?php ($trending_categories = new \Modules\Customer\Entities\Trending_category()); ?>
   <?php ($categories = $trending_categories->getHairBeautyTrendingCategories()); ?>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <?php ($count=0); ?>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php ($count++); ?>
    <?php if($count == 1): ?>
    <div class="item active">
    <?php else: ?>
    <div class="item">
    <?php endif; ?>
        <a href="<?php echo e(url('/shop/category/'.$category->category->slug)); ?>">
      <img src="<?php echo e(url('/assets/images/carousel/'.$category->image_url)); ?>" alt="<?php echo e($category->category->name); ?>" width="550px">
  </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  
</div>
<div id="lowerCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#lowerCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#lowerCarousel" data-slide-to="1"></li>
    <li data-target="#lowerCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" style="width: 107%;">

    <?php ($count=0); ?>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php ($count++); ?>
    <?php if($count == 1): ?>
    <div class="item active">
    <?php else: ?>
    <div class="item">
    <?php endif; ?>
    <?php if($count%2 == 0): ?>
      <div style="height:107px;background-image: url(assets/images/carousel/wave-orange.png);width: 107%;text-align: center;
    padding: 23px 0px 0px 0px;
    font-size: 2em;
    font-weight: bold;">
    <?php else: ?>
    <div style="height:107px;background-image: url(assets/images/carousel/orange-waves.png);width: 107%;text-align: center;
    padding: 23px 0px 0px 0px;
    font-size: 2em;
    font-weight: bold;">
    <?php endif; ?>
    <a href="<?php echo e(url('/shop/category/'.$category->category->slug)); ?>" style="color: #565656;">
        <?php echo e($category->category->name); ?>

    </a>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   </div>

  </div>

    </div>
    <div class="col-sm-6 col-xs-12">
    <?php ($featured_products = new \Modules\Customer\Entities\Trending_product()); ?>
    <?php ($products = $featured_products->getHairBeautyTrendingProducts()); ?>
    <?php ($count = 0); ?>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($product->product == null): ?>
    <?php continue; ?>
    <?php endif; ?>
    <?php ($count++); ?>
    <?php if($count == 0 || $count == 2): ?>
    <div class="row">
    <?php endif; ?>
    <?php if($count == 5): ?>
    <?php break; ?>
    <?php endif; ?>
    <div class="col-sm-6 col-xs-6" style="border-top: 1px solid #eee;border-left: 1px solid #eee;">
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="<?php echo e(url('shop/product/detail/'.$product->product->slug)); ?>">
                            <div class="featured-img">
                                <!-- <span class="helper"></span> -->
                                <img class="img-featured" src="<?php echo e(url('assets/images/products/'.$product->product->getDefaultImage()->image_url)); ?>" alt="" />
                            </div>
                        </a>
                    </div><!-- /.image -->			

                    <!-- <div class="tag hot"><span>hot</span></div> -->	 	   
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
                            </span>
                            <span class="price-before-discount">
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

                    <?php if($product_price->first() != null): ?>
                    <?php if(count($product_price) == 1 || !$product->product->hasDifferentPrices()): ?>
                    <div class="cart clearfix animate-effect hidden-xs hidden-sm">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="<?php echo e(url('shop/add_to_cart')); ?>">
                                        <input type="hidden" value="<?php echo e($product->product->getActivePrice()->first()->id); ?>" name="product_ref" />
                                        <input type="hidden" value="1" name="quantity" />
                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="<?php echo e($product->product->getActivePrice()->first()->id); ?>" title="Buy Now">
                                            <i class="fa fa-shopping-cart"></i>                                                 
                                        </button>
                                        <button class="btn btn-primary cart-btn" type="button">Buy Now</button>
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
                    <?php endif; ?>
                </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    </div>
     <?php if($count == 0 || $count == 2): ?>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    
</div><!-- /.home-owl-carousel -->