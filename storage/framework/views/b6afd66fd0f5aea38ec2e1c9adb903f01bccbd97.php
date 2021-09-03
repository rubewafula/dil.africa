<script>

$(document).ready(function(){

   var shown_div = 0;

    $(document).on('change', '#item_size', function() {  

        var product_price_id = $(this).val();
        var product_slug = $("#product_slug").val();

        if(product_price_id == ""){return;}

        var BASE_URL = "<?php echo e(url('/shop/')); ?>";

        window.location.replace(BASE_URL+"/product/detail/"+product_slug+"/"+product_price_id);

    })
});

</script>

<?php ($product_price = $product->getActivePrice()); ?>

<?php if(count($product_price) == 1): ?>

<div class="detail-block">
    <div class="row  wow fadeInUp">

        <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder" id="gallery-holder">
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

                <h1 class="name"><?php echo e(ucwords($product->name)); ?></h1>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Product Code:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    <?php echo e(($product->product_code != null)?strtoupper($product->product_code):"Unavailable"); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="rating-reviews m-t-20">
                    <div class="row">
                        <div class="col-sm-3">
<!--                        <div class="rating rateit-small"></div>-->
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
                                <span class="label">Seller:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    <?php echo e(($product->seller != null)?ucwords(strtolower($product->seller->name)):"Not Specified"); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Availability :</span>
                            </div>	
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
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

                <div class="price-container info-container m-t-20">
                    <div class="row" id="price_stuff">
                        
                        <div class="col-sm-6">

                            <?php if($product_price->first() != null): ?>
                            <?php ($offer_price = $product_price->first()->offer_price); ?>
                            <?php ($standard_price = $product_price->first()->standard_price); ?>
                            <?php ($sale_price = 0); ?>
                            <div class="price-box">
                                
                                <span class="price">
                                <?php if($offer_price != null && $offer_price != ""): ?>
                                Ksh <?php echo e(number_format($offer_price)); ?>

                                <?php ($sale_price = $offer_price); ?>
                                </span>
                                <span class="price-strike">
                                    KSh <?php echo e(number_format($standard_price)); ?>

                                    <?php ($sale_price = $standard_price); ?>
                                </span> 
                                <?php else: ?> 
                                <span class="price">
                                Ksh <?php echo e(number_format($standard_price)); ?>

                                <?php ($sale_price = $standard_price); ?>
                                <?php endif; ?>      
                                </span>
                                <input type="hidden" value="<?php echo e($product->id); ?>" id="product_ref" />
                            </div>
                            <?php endif; ?> 
                        </div>

                        <div class="col-sm-6">
                            <div class="favorite-button m-t-10">
                                <a class="btn btn-primary" href="<?php echo e(url('shop/add_to_wishlist/'.$product->id.'/'. $product_price->first()->id)); ?>" title="Add to Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                    </div><!-- /.row -->
                    <?php ( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price)); ?>
                    <div class="eligible-shipping">
                        <?php echo e($shipping_message); ?>

                    </div>
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
                                    
                                    <input type="hidden" value="<?php echo e($product_price->first()->id); ?>" name="product_ref" />
                                    <button type="submit" class="btn btn-primary" style="background: #FFA200;font-weight: bold;">
                                        <i class="fa fa-shopping-cart inner-right-vs"></i> BUY NOW
                                    </button>
                                    
                                </div>

                            </div><!-- /.row -->
                        </div><!-- /.quantity-container -->
                    </form>

                <div class="description-container m-t-20">
                    <h3>Key  Features</h3>
                    <ul type="disc">
                        
                        <?php if(count($product->product_features) > 0): ?>
                        <?php $__currentLoopData = $product->product_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li> 
                         <?php if($feature->feature_type_id  == 0): ?>
                           <?php echo e(ucwords($feature->value)); ?>

                         <?php else: ?>
                          <strong> <?php echo e($feature->feature_type!= null?ucwords($feature->feature_type->name):'General'); ?>: </strong> <?php echo e(ucwords($feature->value)); ?> 
                         <?php endif; ?>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>
                    </ul>
                </div><!-- /.description-container -->

            </div><!-- /.product-info -->
        </div><!-- /.col-sm-7 -->
    </div><!-- /.row -->
</div>

<?php elseif(count($product_price) > 1): ?>
<?php ( $prices = clone $product_price ); ?>
<div class="detail-block" id="multiple_prices">
    <div class="row  wow fadeInUp">

        <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder" id="gallery-holder">
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
                <h1 class="name"><?php echo e(ucwords($product->name)); ?></h1>

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
                                <span class="label">Seller:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    <?php echo e(($product->seller != null)?ucwords(strtolower($product->seller->name)):"Not Specified"); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Availability :</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
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

                <div class="price-container info-container m-t-20">
                    <div class="row" id="price_stuff">
                        <input type="hidden" id="product_slug" name="product_slug" value="<?php echo e($product->slug); ?>" />
                        <?php ($max_price = $product->getMaximumPrice()); ?>
                        <?php ($min_price = $product->getMinimumPrice()); ?>

                        <div class="col-sm-6">
                            <div class="price-box">
                                
                                <span class="price">

                                    <?php if($max_price != $min_price): ?>
                                    KSh <?php echo e(number_format($min_price)); ?> - KSh <?php echo e(number_format($max_price)); ?>

                                    <?php else: ?>
                                    KSh <?php echo e(number_format($min_price)); ?>

                                    <?php endif; ?>
                                    <?php ($sale_price = $max_price); ?>
                                </span>

                            </div>

                        </div>

                    </div><!-- /.row -->
                    <?php ( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price)); ?>
                    <div class="eligible-shipping">
                        <?php echo e($shipping_message); ?>

                    </div>
                    </div><!-- /.price-container -->

                    <div class="quantity-container info-container">
                        <div class="row">

                            <div class="col-sm-2">
                                <span class="label">Size / Color:</span>
                            </div>
                            <div class="col-sm-7">
                                
                                <style>
                                    
                                    select {
                                        
                                        display: block;
                                        width: 100%;
                                        height: 34px;
                                        padding: 6px 12px;
                                        font-size: 14px;
                                        line-height: 1.42857143;
                                        color: #555;
                                        background-color: #fff;
                                        background-image: none;
                                        border: 1px solid #ccc;
                                        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                                    }
                                </style>

                                <div class="col-sm-10" style="padding: 0px;">
                                    <select id="item_size" name="item_size">
                                        <option value="">Select Size / Color</option>
                                        <?php $__currentLoopData = $product_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php ($combination = ""); ?>
                                        <?php if($price->size != null && $price->color == null): ?>
                                            $combination = $price->size; 
                                            <option value="<?php echo e($price->id); ?>"><?php echo e($price->size); ?></option>
                                        <?php elseif($price->size == null && $price->color != null): ?>
                                            $combination = $price->color; 
                                            <option value="<?php echo e($price->id); ?>"><?php echo e($price->color); ?></option>
                                        <?php elseif($price->size != null && $price->color != null): ?>
                                            $combination = $price->size."/".$price->color; 
                                            <option value="<?php echo e($price->id); ?>"><?php echo e($price->size); ?> / <?php echo e($price->color); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <!-- <div class="col-sm-2" style="padding: 0px 5px;margin-top: 2px;">
                                    <button class="btn-sm" style="background: #FFA200;border: 1px solid #FFA200;border-radius:0px;color: #fff;">Filter</button>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div id="cart-form"></div>

                <div class="description-container m-t-20">
                    <h3>Key Features</h3>
                    <ul type="disc">
                        
                        <?php if(count($product->product_features) > 0): ?>
                        <?php $__currentLoopData = $product->product_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li> 
                        <?php if($feature->feature_type_id  == 0): ?>
                           <?php echo e(ucwords($feature->value)); ?>

                        <?php else: ?>
                          <strong> <?php echo e($feature->feature_type!= null?ucwords($feature->feature_type->name):'General'); ?>: </strong> <?php echo e(ucwords($feature->value)); ?> 
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.description-container -->

            </div><!-- /.product-info -->
        </div><!-- /.col-sm-7 -->
    </div><!-- /.row -->
</div>

<?php endif; ?>