<?php $__env->startSection('content'); ?>

<script type="text/javascript">
    
    $(document).ready(function(){

        var BASE_URL = "<?php echo e(url('/shop/')); ?>";

        $("#update-button").click( function() {

            var arr = new Array();

            $(".product_id_class").each(function() {              
                
                var product_id = $(this).val();

                $quantity = $("#quantity_field-"+product_id).val();

                if($quantity == '' || !$.isNumeric($quantity) || $quantity == 0){

                    alert("Please enter a valid value for quantity");
                    return;
                }

                arr.push(product_id+":"+$quantity);

            });

            var filedata = new FormData();
        
            filedata.append('data', arr);
            $.ajax({
                url: BASE_URL + "/cart/update",
                data: filedata,
                cache: false,
                processData: false, // Don't process the files
                contentType: false,
                type: 'post',
                success: function (output) {

                    if (output.status == '200') {
                        
                       window.location.replace(BASE_URL+"/cart");                              
                    }else {

                        alert("An error occured and your cart was not updated. Please try again");
                    }
                }
            });

        })
        
    });
</script>

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            <?php echo $__env->make('customer::product.sidebar.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class='col-md-9'>
                <div class="detail-block">
                    <div class="row  wow fadeInUp">

                        <div class='col-md-12 product-info-block'>
                            
                            <ul>
                                <li>
                                    <div class="row  hidden-xs hidden-sm" style="margin-bottom: 20px;padding:0px 0px 15px 15px;border-bottom: 2px solid #565656;font-weight: bold;">
                                        <div class="cart-item product-summary">
                                            <div class="col-md-6">
                                                Product Description
                                            </div>
                                            <div class="col-md-2" style="padding-left: 0px;">
                                                Quantity
                                            </div>
                                            <div class="col-md-2" style="padding-left: 10px;">
                                                Unit Price
                                            </div>
                                            <div class="col-md-2" style="text-align: right;padding-left: 10px;">
                                                Total Price
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <?php if(count($cart_items) > 0): ?>
                                    <?php ($count = 0); ?>
                                    <div class="hidden-xs hidden-sm"> 
                                    <?php $__currentLoopData = $cart_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                                    <?php ($product_id = \Modules\Customer\Entities\Product_price::find($item->getProductPriceId())->product_id); ?>
                                    <?php ($slug = \Modules\Customer\Entities\Product::find($product_id)->slug); ?>
                                    <div class="cart-item product-summary">
                                        <input type="hidden" class="product_id_class" value="<?php echo e($item->getProductPriceId()); ?>"/>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="image">
                                                    <a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>">
                                                        <img src="<?php echo e(url('assets/images/products/'.$item->getProductImage())); ?>" width="50px" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-5">

                                                <div class="product-info text-left" style="margin-bottom: 10px;color: #ccc;padding-left: 20px;">
                                                    <?php echo e($item->getSeller()); ?>

                                                </div>
                                                
                                                <h4 class="name" style="font-weight: bold;font-size: 15px;padding-left: 20px;">
                                                    <a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>"><?php echo e($item->getProductName()); ?></a>
                                                </h4>
                                                <div class="product-info text-left" style="margin-bottom: 10px;color: #ccc;">
                                                    <a href="<?php echo e(url('shop/cart/remove/'.$count)); ?>" style="color: #FFA200;padding-left: 20px;">
                                                        <i class="fa fa-trash"></i> Remove</a>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="price">
                                                    <input type="number" value="<?php echo e($item->getQuantity()); ?>" style="width: 80%;" id="quantity_field-<?php echo e($item->getProductPriceId()); ?>" class="quantity_field">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="price"> KSh. <?php echo e(number_format($item->getUnitPrice())); ?></div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="price" style="text-align: right;"> KSh. <?php echo e(number_format($item->getSubtotal())); ?></div>
                                            </div>
                                        </div>
                                    </div><!-- /.cart-item -->
                                    <?php ($count++); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <?php ($count = 0); ?>
                                    <div class="hidden-md hidden-lg"> 
                                    <?php $__currentLoopData = $cart_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                                    <?php ($product_id = \Modules\Customer\Entities\Product_price::find($item->getProductPriceId())->product_id); ?>
                                    <?php ($slug = \Modules\Customer\Entities\Product::find($product_id)->slug); ?>
                                    <div class="cart-item product-summary">
                                        <input type="hidden" class="product_id_class" value="<?php echo e($item->getProductPriceId()); ?>"/>
                                        <div class="row">
                                            <div class="col-xs-2 col-sm-2">
                                                <div class="image">
                                                    <a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>">
                                                        <img src="<?php echo e(url('assets/images/products/'.$item->getProductImage())); ?>" width="50px" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8">

                                                <div class="product-info text-left" style="margin-bottom: 10px;color: #ccc;padding-left: 20px;">
                                                    <?php echo e($item->getSeller()); ?>

                                                </div>
                                                <h4 class="name" style="font-weight: bold;font-size: 15px;padding-left: 20px;">
                                                    <a href="<?php echo e(url('/shop/product/detail/'.$slug)); ?>"><?php echo e($item->getProductName()); ?></a>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-xs-4 col-sm-4 cart-item product-summary">
                                                Quantity
                                            </div>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="price">
                                                    <input type="text" value="<?php echo e($item->getQuantity()); ?>" style="width: 50%;" id="quantity_field-<?php echo e($item->getProductPriceId()); ?>" class="quantity_field">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-xs-4 col-sm-4 cart-item product-summary">
                                                Unit Price
                                            </div>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="price"> KSh. <?php echo e(number_format($item->getUnitPrice())); ?></div>
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            <div class="col-xs-4 col-sm-4 cart-item product-summary">
                                                Total Price
                                            </div>
                                            <div class="col-xs-6 col-sm-6">
                                                <div class="price"> KSh. <?php echo e(number_format($item->getSubtotal())); ?></div>
                                            </div>
                                        </div>
                                        <div class="row m-t-10">
                                            
                                            <div class="col-xs-4 col-sm-4 product-info text-left" style="margin-bottom: 10px;color: #ccc;">
                                                <a href="<?php echo e(url('shop/cart/remove/'.$count)); ?>" style="color: #FFA200;">
                                                    <i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div><!-- /.cart-item -->
                                    <div style="border-bottom: 1px solid #ddd;margin:5px 0px 15px 0px;"></div>
                                    <?php ($count++); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <div class="clearfix"></div>
                                    <hr class="hidden-xs hidden-sm">
                                    <div class="hidden-md hidden-lg" style="border-bottom: 2px solid #565656;">
                                    </div>

                                    <div class="clearfix cart-total" style="background: #f8f8f8;padding: 10px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button class="btn btn-upper btn-primary btn-block" id="update-button" style="margin-bottom: 10px;">Update Shopping Cart</button>
                                            </div>
                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                <span class='price' style="font-weight: bold;color: #ffa200;font-size: 18px;">KSh. <?php echo e(number_format($total)); ?></span>                                           
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="text" style="font-weight: bold;font-size: 18px;">Total : </span>
                                            </div>                                           
                                            
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                <span class='price' style="color: #ccc;">KSh <?php echo e(number_format($tax)); ?></span>                                           
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="text" style="color: #ccc;padding-left: 3px;">VAT : </span>
                                            </div>                                           
                                            
                                        </div>
                                        <?php ($voucher = Session::get('voucher_type')); ?>
                                        <?php if($voucher != null): ?>
                                        <div class="row" style="margin-top: 10px;color: #0f7dc2;">
                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                <?php if($voucher == 'AMOUNT'): ?>
                                                <span class='price'> ( KSh <?php echo e(Session::get('voucher_amount')); ?> )</span>
                                                <?php elseif($voucher == 'PERCENT_DISCOUNT'): ?>
                                                <?php ($percent = Session::get('voucher_percent')); ?>
                                                <?php ($amount_to_deduct = $total * ($percent/100)); ?>
                                                <span class='price'> (  KSh <?php echo e(number_format(round($amount_to_deduct,2))); ?> )</span>
                                                <?php else: ?>
                                                <span class='price'> -- </span>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="text" style="padding-left: 3px;">Voucher : </span>
                                            </div>                                           
                                            
                                        </div>
                                        <?php endif; ?>
                                        <div class="row" style="margin-top: 10px;">
                                            <form method="POST" action="<?php echo e(url('/shop/apply-voucher')); ?>">
                                                <div class="col-md-4 col-sm-6">                         
                                                    <input type="text" class="m-t-20" style="height: 35px;width: 99%;" name="voucher_no" placeholder=" Enter Voucher No. if you have one" title="Enter your voucher / coupon code if you have one.."/>                                      
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <button class="btn btn-upper btn-primary btn-block m-t-20">Apply Voucher</button>     
                                                </div>

                                            </form>
                                            <div class="col-md-4 col-sm-12 pull-right" style="text-align: right;">
                                                <span class='price' style="color: #ccc;margin-top: 10px;">
                                                    <?php if($voucher != null): ?>
                                                    <?php if($voucher == 'FREE_SHIPPING'): ?>

                                                    Free Shipping (Voucher)
                                                    <?php else: ?>
                                                    Shipping fees not included yet
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    Shipping fees not included yet
                                                    <?php endif; ?>
                                                </span>                                           
                                            </div>                                                                               
                                        </div>
                                        <div class="clearfix"></div>
                                        
                                    </div><!-- /.cart-total-->

                                    <div class="row" style="border-bottom: 1px solid #ddd;padding-bottom: 10px;">
                                        <div class="col-md-4 col-sm-12 pull-right" style="margin-right: 15px;">
                                            <a href="<?php echo e(url('/shop/checkout')); ?>" class="btn btn-upper btn-primary btn-block m-t-20"  style="background: #FFA200;">Proceed to Checkout</a>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 pull-right" style="margin-right: 15px;">
                                            <a href="<?php echo e(url('/shop')); ?>" class="btn btn-upper btn-primary btn-block m-t-20 pull-right hidden-xs hidden-sm">Continue Shopping</a>
                                            <a style="width: 163px;" href="<?php echo e(url('/shop')); ?>" class="btn btn-upper btn-primary btn-block m-t-20 pull-right hidden-md hidden-lg">Continue Shopping</a>
                                        </div>
                                    </div>
                                    
                                    <?php else: ?> 
                                    <div class="col-md-8 col-sm-12" style="font-size: 16px;color: #FFA200;">
                                        You have no items in your shopping cart!
                                    </div>
                                    <div class="col-md-3 col-sm-12 pull-right" style="padding-right: 0px;">
                                        <a href="<?php echo e(url('/shop')); ?>" class="btn btn-upper btn-primary btn-block">Continue Shopping</a>
                                    </div>
                                    <?php endif; ?>
                                </li>
                            </ul><!-- /.dropdown-menu-->
                        </div><!-- /.col-sm-7 -->
                    </div><!-- /.row -->
                </div>

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">

                        <?php echo $__env->make('customer::home.recommended.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div><!-- /.scroll-tabs -->
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>