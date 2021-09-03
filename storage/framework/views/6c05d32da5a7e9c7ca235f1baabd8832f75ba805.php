<?php $__env->startSection('content'); ?>

<div class="breadcrumb" style="margin: 5px 0px;">
    <div class="container">
        <div class="col-md-8">
            <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout')); ?>">Checkout</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout/delivery')); ?>">Address</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout/payment')); ?>">Payment</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
        </div>
        <div class="col-md-4" style="text-align: right;padding-right: 0px;">
            <form method="POST" action="<?php echo e(url('shop/checkout/complete-transaction')); ?>">
                <input type="hidden" name="payment_option" value="<?php echo e($payment_option); ?>"/>
                <input type="hidden" name="user_address_id" value="<?php echo e($user_address_id); ?>"/>
                <input type="hidden" name="order_value" value="<?php echo e($order_value); ?>"/>
                <input type="hidden" name="shipping_cost" value="<?php echo e($shipping_cost); ?>"/>
                <input type="hidden" name="userId" value="<?php echo e($userId); ?>"/>
                <button type="submit" class="btn-upper btn btn-success" style="background:">Confirm Your  Order</button>
            </form>
        </div>
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="panel-group checkout-steps">

                        <div class="panel panel-default checkout-step-01" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>Order Details
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row  wow fadeInUp">

                                        <div class='col-sm-12 col-md-12 product-info-block'>
                                            <div class="row">
                                                <?php ($cart_items = Session::get('cart_items')); ?>
                                            </div>
                                            <ul>
                                                <li>
                                                    <?php if($cart_items != null): ?>
                                                    <?php $__currentLoopData = $cart_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="cart-item product-summary">
                                                        <div class="row">
                                                            <div class="col-xs-1">
                                                                <div class="image">
                                                                   
                                                                        <img src="<?php echo e(url('assets/images/products/'.$item->getProductImage())); ?>" width="40px" alt="">
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-5">

                                                                <div class="product-info text-left" style="margin-bottom: 5px;color: #ccc;font-size: 10px;">
                                                                    <?php echo e($item->getSeller()); ?>

                                                                </div>
                                                                <h4 class="name" style="font-size: 13px;color: #0F7DC2;">
                                                                    <?php echo e($item->getProductName()); ?>

                                                                </h4>                                                               
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="price" style="font-size: 13px;"> <?php echo e($item->getQuantity()); ?></div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="price"  style="font-size: 13px;"> KSh. <?php echo e(number_format($item->getUnitPrice())); ?></div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="price" style="text-align: right;font-size: 13px;"> KSh. <?php echo e(number_format($item->getSubtotal())); ?></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.cart-item -->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>

                                                    <div class="clearfix"></div>
                                                    <hr>

                                                    <div class="clearfix cart-total">
                                                        <div class="row">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <span class='price' style="font-weight: bold;color: #ffa200;font-size: 14px;">KSh. <?php echo e(number_format(Session::get('order_value'))); ?></span>                                           
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="font-weight: bold;font-size: 14px;">Total : </span>
                                                            </div>                                           

                                                        </div>
                                                        <div class="row" style="margin-top: 7px;">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <span class='price' style="color: #ccc;">KSh <?php echo e(number_format(Session::get('tax'))); ?></span>                                           
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="color: #ccc;padding-left: 3px;">VAT : </span>
                                                            </div>                                           

                                                        </div>
                                                        <?php ($voucher_deducted = 0); ?>
                                                        <?php ($voucher = Session::get('voucher_type')); ?>
                                                        <?php if($voucher != null): ?>
                                                        <div class="row" style="margin-top: 7px;color: #0f7dc2;">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <?php if($voucher == 'AMOUNT'): ?>
                                                                <?php ($voucher_deducted = Session::get('voucher_amount')); ?>
                                                                <span class='price'> ( KSh <?php echo e($voucher_deducted); ?> )</span>
                                                                <?php elseif($voucher == 'PERCENT_DISCOUNT'): ?>
                                                                <?php ($percent = Session::get('voucher_percent')); ?>
                                                                <?php ($amount_to_deduct = Session::get('order_value') * ($percent/100)); ?>
                                                                <?php ($voucher_deducted = $amount_to_deduct); ?>
                                                                <span class='price'> ( KSh <?php echo e(number_format(round($amount_to_deduct,2))); ?> )</span>
                                                                <?php else: ?>
                                                                <span class='price'> -- </span>
                                                                <?php endif; ?>

                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="padding-left: 3px;">Voucher : </span>
                                                            </div>                                           
                                                            
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="row" style="margin-top: 7px;">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <span class='price' style="color: #ccc;">

                                                                    <?php if($voucher != null): ?>
                                                                    <?php if($voucher == 'FREE_SHIPPING'): ?>

                                                                    Free Shipping (Voucher)
                                                                    <?php else: ?>
                                                                    KSh <?php echo e(number_format(Session::get('shipping_cost'))); ?>

                                                                    <?php endif; ?>
                                                                    <?php else: ?>
                                                                    KSh <?php echo e(number_format(Session::get('shipping_cost'))); ?>

                                                                    <?php endif; ?>
                                                                
                                                            </span>                                           
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="color: #ccc;padding-left: 3px;">Shipping : </span>
                                                            </div>                                           

                                                        </div>
                                                        <?php ($transaction_cost = Session::get('transaction_cost')); ?>
                                                        <?php if($transaction_cost > 0): ?>
                                                        <div class="row" style="margin-top: 7px;">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <span class='price' style="color: #ccc;">KSh <?php echo e(number_format($transaction_cost)); ?></span>                                           
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="color: #ccc;padding-left: 3px;">Transaction Charges : </span>
                                                            </div>                                           

                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="row" style="margin-top: 5px;">
                                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                                <span class='price' style="font-weight: bold;color: #0F7DC2;font-size: 14px;">KSh. <?php echo e(number_format(Session::get('order_value') + $shipping_cost + $transaction_cost - $voucher_deducted)); ?></span>                                           
                                                            </div>
                                                            <div class="col-md-2 pull-right">
                                                                <span class="text" style="font-weight: bold;font-size: 14px;color: #0F7DC2;">Grand Total : </span>
                                                            </div>                                           

                                                        </div>
                                             <div  class="row"  style="margin-top:5 px">
                                                      <div  class="col-md-2 pull-right">
                                                       <form method="POST" action="<?php echo e(url('shop/checkout/complete-transaction')); ?>">
                <input type="hidden" name="payment_option" value="<?php echo e($payment_option); ?>"/>
                <input type="hidden" name="user_address_id" value="<?php echo e($user_address_id); ?>"/>
                <input type="hidden" name="order_value" value="<?php echo e($order_value); ?>"/>
                <input type="hidden" name="shipping_cost" value="<?php echo e($shipping_cost); ?>"/>
                <input type="hidden" name="userId" value="<?php echo e($userId); ?>"/>
                <button type="submit" class="btn-upper btn btn-success" style="background: ;">Confirm your Order</button>
            </form>      
        </div>

                                                        </div>
                                                        <div class="clearfix"></div>

                                                    </div><!-- /.cart-total-->                                                                                      
                                                </li>
                                            </ul><!-- /.dropdown-menu-->
                                        </div><!-- /.col-sm-7 -->
                                    </div><!-- /.row -->
                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-02" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>2</span>Personal Details
                                    </a>
                                </h4>
                            </div>

                            <!-- panel-heading -->
                            <?php ($user_address = \Modules\Customer\Entities\User_address::findorfail($user_address_id)); ?>
                            <?php ($user = \Modules\Customer\Entities\User::findorfail($userId)); ?>
                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-3 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Name: <span style="font-weight: normal;"> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">Phone Number: <span style="font-weight: normal;"> <?php echo e($user_address->telephone); ?></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">Email Address: <span style="font-weight: normal;"> <?php echo e($user->email); ?></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-4 already-registered-login">
                                            <div class="form-group">
                                                <a href="<?php echo e(url('shop/checkout/guest/update/'.$user->id)); ?>">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->

                        <?php ($delivery_type = Session::get('delivery_type')); ?>
                        <?php if($delivery_type == 'home_office_delivery'): ?>
                        <div class="panel panel-default checkout-step-03" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Preferred Delivery Address
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Phone Number: <span style="font-weight: normal;"> <?php echo e($user_address->telephone); ?></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Area: <span style="font-weight: normal;"> <?php echo e($user_address->google_area); ?></span></label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">City/Town: <span style="font-weight: normal;"> <?php echo e(($user_address->city != null)?$user_address->city->name:""); ?></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Country: <span style="font-weight: normal;"> <?php echo e($user_address->country->name); ?></span></label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Delivery Address </label><br/>
                                                <span style="font-weight: normal;"> 
                                                    <?php echo e($user_address->delivery_address); ?>

                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <a href="<?php echo e(url('shop/checkout/delivery/update/'.$user_address->id)); ?>">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;padding: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>

                                        </div>

                                    </div>

                                </div>			
                            </div>                           
                            <!-- panel-body  -->
                        </div><!-- row -->
                        <?php elseif($delivery_type == 'pickup'): ?> 
                        <?php ($user_pickuplocation = \Modules\Customer\Entities\User_pickup_location::findorfail($user_address_id)); ?>
                        <div class="panel panel-default checkout-step-03" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Preferred Pickup Location
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Pickup Location: <span style="font-weight: normal;"> <?php echo e($user_pickuplocation->warehouse->name); ?></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Area: <span style="font-weight: normal;"> <?php echo e($user_pickuplocation->warehouse->area->name); ?></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Zone: <span style="font-weight: normal;"> <?php echo e($user_pickuplocation->warehouse->area->zone->name); ?></span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">City: <span style="font-weight: normal;"> <?php echo e($user_pickuplocation->warehouse->area->zone->city->name); ?></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Country: <span style="font-weight: normal;"> <?php echo e($user_pickuplocation->warehouse->area->zone->city->country->name); ?></span></label>
                                            </div>
                                        </div>                     

                                    </div>

                                </div>			
                            </div>                           
                            <!-- panel-body  -->
                        </div><!-- row --> 
                        <?php endif; ?>
                        <div class="panel panel-default checkout-step-04" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>4</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-3 col-sm-8 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Payment Method: <span style="font-weight: normal;"> <?php echo e($payment_option); ?></span></label>
                                            </div>

                                        </div>
                                        <div class="col-md-1 col-sm-4 already-registered-login">
                                            <div class="form-group">
                                                <a href="<?php echo e(url('shop/checkout/payment')); ?>">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                </div>

            </div><!-- /.row -->
            <div  class="row">
                <div  class="col-md-2 pull-right">
            <form method="POST" action="<?php echo e(url('shop/checkout/complete-transaction')); ?>">
                <input type="hidden" name="payment_option" value="<?php echo e($payment_option); ?>"/>
                <input type="hidden" name="user_address_id" value="<?php echo e($user_address_id); ?>"/>
                <input type="hidden" name="order_value" value="<?php echo e($order_value); ?>"/>
                <input type="hidden" name="shipping_cost" value="<?php echo e($shipping_cost); ?>"/>
                <input type="hidden" name="userId" value="<?php echo e($userId); ?>"/>
                <button type="submit" class="btn-upper btn btn-success checkout-page-button">Confirm your Order</button>
            </form>
        </div>
        </div>
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.checkout_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>