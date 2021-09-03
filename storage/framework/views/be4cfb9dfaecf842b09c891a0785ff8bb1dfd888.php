<?php $__env->startSection('content'); ?>

<style>
    label{
        
        font-weight: normal;
    }
</style>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/shop')); ?>">Home</a></li>
                <li class='active'>Login</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="sign-in-page">
            <div class="row">
                <!-- Sign-in -->			
                <div class="col-md-5 col-sm-5 col-md-offset-1 sign-in">
                    <h4 class="">Customer Sign in</h4>
                    
                    <form class="register-form outer-top-xs" method="POST" role="form" action="<?php echo e(url('shop/login')); ?>">
                        <div class="form-group">
                            <label class="info-title" for="email">Email Address <span>*</span></label>
                            <input type="email" class="form-control unicase-form-control text-input" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="password">Password <span>*</span></label>
                            <input type="password" class="form-control unicase-form-control text-input" id="password" name="password">
                        </div>
                        <div>
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="remember_me">Remember me!
                            </label>
                            <a href="#" class="forgot-password pull-right">Forgot your Password?</a>
                        </div>
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" style="margin-top: 10px;">Login</button>
                    </form>	

                    <p style="margin-top: 20px;font-size: 22px;">OR</p>

                    <div class="social-sign-in">
                        <a style="padding: 10px 5px;" href="<?php echo e(url('/shop/auth/facebook')); ?>" class="facebook-sign-in"><i class="fa fa-facebook"></i> Sign In with Facebook</a>
                        <a style="padding: 10px 5px;" href="<?php echo e(url('/shop/auth/twitter')); ?>" class="twitter-sign-in"><i class="fa fa-twitter"></i> Sign In with Twitter</a>
                    </div>				
                </div>
                <!-- Sign-in -->

                <div class="col-md-5 col-sm-5 sign-in">
                    
                    <h4 class="">Not Registered Yet? Choose option below</h4>
                    
                    <div style="border-left: 1px solid #ddd;padding: 38px 20px;">
                        <div>
                            <a style="padding: 10px 5px;" href="<?php echo e(url('/shop/sign-up')); ?>"><button class="btn blue-bg">Register as a Customer</button></a>
                        </div>
                        <div class="social-sign-in" style="margin-top: 40px;">
                            <a style="padding: 10px 5px;" href="<?php echo e(url('/seller/register')); ?>"><button class="btn orange-bg" style="width: 171px;">Register as a Seller</button></a>
                        </div>
                    </div>
                        
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>