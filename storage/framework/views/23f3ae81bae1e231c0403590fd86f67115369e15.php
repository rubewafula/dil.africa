<?php $__env->startSection('content'); ?>

<style>
    .info-title {
        font-family: 'Open Sans', sans-serif, sans-serif;
        font-weight: normal;
        margin-bottom: 5px;
        font-size: 13px;
    }
</style>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                <li class='active'>Checkout</li>
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
                                        <span>1</span>Checkout Method
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne1" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body" id="login-form">
                                    <div class="row">		

                                        <!-- guest-login -->			
                                        <div class="col-md-6 col-sm-6 guest-login">
                                            <h4 class="checkout-subtitle"> Create an Account</h4>
                                            <p class="text title-tag-line">Register with us for future convenience:</p>

                                            <!-- radio-form  -->
                                            <form class="register-form" role="form">
                                                <div class="radio radio-checkout-unicase">  
                                                    <input id="register" type="radio" name="checkout_option" class="choose-option" value="register" checked>  
                                                    <label class="radio-button" for="register">Register</label>
                                                    <br>
                                                    <input id="guest" type="radio" name="checkout_option" value="guest" class="choose-option">  
                                                    <label class="radio-button guest-check" for="guest">Checkout as Guest</label>  
                                                </div>  
                                            </form>
                                            <!-- radio-form  -->

                                            <h4 class="checkout-subtitle outer-top-vs">Register and save time</h4>
                                            <p class="text title-tag-line ">Register with us for future convenience:</p>

                                            <ul class="text instruction inner-bottom-30">
                                                <li class="save-time-reg">- Fast and easy check out</li>
                                                <li>- Easy access to your order history and status</li>
                                            </ul>

                                            <button type="submit" class="btn-upper btn btn-warning checkout-page-button checkout-continue" id="checkout_continue">Continue</button>
                                        </div>
                                        <!-- guest-login -->

                                        <!-- already-registered-login -->
                                        <div class="col-md-6 col-sm-6 already-registered-login">
                                            <h4 class="checkout-subtitle">Already registered?</h4>
                                            <p class="text title-tag-line">Please log in below:</p>
                                            <form class="register-form" role="form" method="POST" action="<?php echo e(url('shop/login')); ?>">
                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email Address <span>*</span></label>
                                                    <input type="email" class="form-control unicase-form-control text-input" id="email" name="email" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="password">Password <span>*</span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" placeholder="">
                                                    <a href="#" class="forgot-password">Forgot your Password?</a>
                                                </div>
                                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                                            </form>
                                        </div>	
                                        <!-- already-registered-login -->		

                                    </div>			
                                </div>


                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height: 432px;">
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