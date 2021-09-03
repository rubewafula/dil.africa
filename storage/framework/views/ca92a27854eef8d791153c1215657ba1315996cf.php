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


<div class="col-md-12 col-sm-12 create-new-account">

    <h4>Create your new account as a customer</h4>
</div>
<!-- create a new account -->
<div class="col-md-8 col-sm-8 col-md-offset-1 create-new-account hidden-xs hidden-sm">

    <form class="address-form" role="form" method="POST" action="<?php echo e(url('shop/register-customer')); ?>">
        <div class="col-md-6 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="first_name">First Name <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="first_name" name="first_name" placeholder=""/>
            </div>
            <div class="form-group">
                <label class="info-title" for="phone">Phone Number <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="phone" name="phone" placeholder=""/>
            </div>                                                                                      
        </div>
        <div class="col-md-6 col-sm-12 already-registered-login">
            
            <div class="form-group">
                <label class="info-title" for="last_name">Last Name <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="last_name" name="last_name" placeholder=""/>
            </div>
            <div class="form-group">
                <label class="info-title" for="email">Email Address <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="email" name="email" placeholder=""/>
            </div>  
        </div>
        <div class="col-md-6 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="password">Password <span>*</span></label>
                <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" placeholder=""/>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="password">Confirm Password <span>*</span></label>
                <input type="password" class="form-control unicase-form-control text-input" id="conf_password" name="conf_password" placeholder=""/>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 already-registered-login">
            <button type="submit" style="margin-top: 25px;" class="btn-upper btn btn-primary checkout-page-button">Register</button>
        </div>
    </form>

</div>

<div class="col-xs-12 col-sm-12 create-new-account hidden-lg hidden-md">

    <form class="address-form" role="form" method="POST" action="<?php echo e(url('shop/register-customer')); ?>">
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="first_name">First Name <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="first_name" name="first_name" placeholder=""/>
            </div>                                                                                   
        </div>
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="phone">Phone Number <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="phone" name="phone" placeholder=""/>
            </div> 
        </div> 
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="last_name">Last Name <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="last_name" name="last_name" placeholder=""/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="email">Email Address <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="email" name="email" placeholder=""/>
            </div>  
        </div>
       <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="password">Password <span>*</span></label>
                <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" placeholder=""/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="password">Confirm Password <span>*</span></label>
                <input type="password" class="form-control unicase-form-control text-input" id="conf_password" name="conf_password" placeholder=""/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 already-registered-login">
            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Register</button>
        </div>
    </form>

</div>	
<!-- create a new account -->

            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>