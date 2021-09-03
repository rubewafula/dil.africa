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

<style>
    .info-title {
        font-family: 'Open Sans', sans-serif, sans-serif;
        font-weight: normal;
        margin-bottom: 5px;
        font-size: 13px;
    }
</style>

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>Transaction Complete
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row" style="line-height: 2em;">
                                        <?php ($order = \Modules\Customer\Entities\Order::findorfail($order_id)); ?>
                                        Thank you for shopping with us. Your order <?php echo e($order->order_reference); ?> has been placed and is pending confirmation. If we need to confirm any information regarding your purchase, we will call you within 1 hour 
                                        (calling hours: Mon-Fri 8am - 8pm; Sat-Sun 9am - 3pm) or email you if you are not reachable. If you don't respond within 48 hours, we will cancel your order and notify you via email.
                                        If the information we have is complete, your order will be automatically confirmed and you will receive an e-mail with further details. Please note: If you'd like to change your order details
                                        (e.g recipient, delivery address), please contact us now at 0797 522522 or email us at customercare@dil.africa. You will no longer be able to change them at a later stage.
                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                    <!-- checkout-step-01  -->

                </div><!-- /.checkout-steps -->

            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.checkout_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>