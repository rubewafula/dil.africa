<?php $__env->startSection('content'); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout')); ?>">Checkout</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout/delivery')); ?>">Address</a></li>
                <li class='active'><a href="<?php echo e(url('shop/checkout/payment')); ?>">Payment</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div class="blue-text" style="margin-top: 20px;">
                                Prepay your order to enjoy even faster delivery timeline of 3 Hours within Nairobi
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <form class="address-form" role="form" method="POST" action="<?php echo e(url('shop/checkout/payment-method')); ?>">
                                        <input type="hidden" name="user_address_id" value="<?php echo e(isset($user_address_id)?$user_address_id:""); ?>"/>
                                        <input type="hidden" name="userId" value="<?php echo e(isset($userId)?$userId:""); ?>"/>
                                        <div class="row" style="margin-bottom: 15px;border-bottom: 1px solid #eee;padding-bottom: 10px;">		
                                            
                                            <?php if(isset($user_address)): ?>
                                            <?php ( $delivery_type = Session::get('delivery_type') ); ?>
                                            <?php ($city = ""); ?>
                                            <?php if($delivery_type == 'pickup'): ?>
                                            <?php ( $city = $user_address->warehouse->city->name ); ?>
                                            <?php elseif($delivery_type == 'home_office_delivery'): ?>
                                            <?php ($city = $user_address->city->name); ?>
                                            <?php endif; ?>
                                            <?php ($eligible_cash = \Modules\Customer\Utilities\Utilities::isEligibleForCashPayment($city)); ?>
                                            <?php if($eligible_cash == 1): ?>
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">                                           
                                                <input type="radio" name="payment_option" value="MPESA ON DELIVERY">
                                                <img src="<?php echo e(url('assets/images/cash.png')); ?>" width="180px" alt="Cash"/>
                                            </div>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">
                                                <input type="radio" name="payment_option" value="MPESA (PREPAID)">
                                                <img src="<?php echo e(url('assets/images/mpesa.png')); ?>" width="180px" alt="M-PESA Prepayment"/>
                                            </div>
                                            <!--
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">
                                                <input type="radio" name="payment_option" value="PAYPAL">
                                                <img src="<?php echo e(url('assets/images/paypal.png')); ?>" width="180px" alt="PayPal"/>
                                            </div>
                                        -->

                                        </div>
                                        <?php if($eligible_cash == "not-nairobi"): ?>

                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;>
                                            Please note that payment on delivery is unavailable for this order since it is to be shipped outside Nairobi. Please prepay via M-PESA and our customer care agent will be in touch with you immediately.
                                        </div>
                                        <?php elseif($eligible_cash == "bulky"): ?>
                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;">
                                            Please note that payment on delivery is unavailable for this order since there is a bulky item that is included in the order. Please prepay via M-PESA and our customer care agent will be in touch with you immediately.
                                        </div>
                                        <?php elseif($eligible_cash == "huge-total"): ?>
                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;">
                                            Please note that payment on delivery is unavailable for this order as it exceeds the maximum allowable for payment on delivery <span style="font-weight: bold;color: #0F7DC2;">(KES 50,000)</span>. Please prepay via M-PESA  and our customer care agent will be in touch with you immediately.
                                        </div>
                                        <?php endif; ?>
                                        <button type="submit" style="margin-top: 10px;" class="btn-upper btn btn-primary checkout-page-button">Continue</button>
                                    </form>
                                </div>
                                <!-- panel-body  -->

                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height: 242px;">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                </div>
                                <div class="">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        <li><a href="<?php echo e(url('shop/checkout')); ?>">Checkout Method</a></li>
                                        <li><a href="<?php echo e(url('shop/checkout/delivery')); ?>">Delivery Address Information</a></li>
                                        <li><a href="<?php echo e(url('shop/checkout/payment')); ?>">Payment Information</a></li>
                                        <li><a href="<?php echo e(url('shop/checkout/order-review')); ?>">Order Review</a></li>
                                    </ul>		
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- checkout-progress-sidebar -->				
                </div>
            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.checkout_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>