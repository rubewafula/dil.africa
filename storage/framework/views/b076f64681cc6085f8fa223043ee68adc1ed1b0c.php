<?php $__env->startSection('content'); ?>
        <div class="body-content">

                <div class="main-header" style="border-bottom: 2px solid #108bea;">

                        <div class="container">
                            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                                <!-- ============================================================= LOGO ============================================================= -->
                                <div class="logo">
                                    <a href="<?php echo e(url('/shop')); ?>">

                                        <img src="<?php echo e(url('assets/images/logo.png')); ?>" alt="">

                                    </a>
                                </div><!-- /.logo -->
                                <!-- ============================================================= LOGO : END ============================================================= -->             </div><!-- /.logo-holder -->

                            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                                <!-- /.contact-row -->
                                <div class="search-area">
                                    
                                </div>              
                            </div><!-- /.top-search-holder -->

                            <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                                
                            </div><!-- /.row -->

                    </div><!-- /.container -->
                </div>

                <div class="container" id="main-wrapper">
                    <div class="row" style="background: #fff;">
                        <div class="col-md-6 col-md-offset-1 center">
                            <div class="login-box panel panel-white">
                                <div class="panel-body">

                                   <div class="row">  
                                        <div class="col-md-7">
                                           <span style="color: #108bea;font-size: 18px;">Sign  Up</span>
                                           <p style="line-height: 1.6em;">
                                           Provide the following information to register
                                            </p>
                                       </div>
                                       <div class="col-md-5">
                                           Already  registered? <a href="<?php echo e(url('seller/login')); ?>" class="btn-primary"> Login </a>
                                       </div>
                                   </div>

                                   <hr/>

                                    <div class="row">
                                
                                        <div class="col-md-12">
                                         <form class="form-horizontal" method="POST" action="<?php echo e(url('seller/register')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                           <div class="form-group<?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name')); ?>" required autofocus>

                                <?php if($errors->has('last_name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('phone') ? ' has-error' : ''); ?>">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="<?php echo e(old('phone')); ?>" required>

                                <?php if($errors->has('phone')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Sign up
                                </button>
                            </div>
                        </div>

                     
                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <img src="<?php echo e(url('assets/images/selling-online-today.png')); ?>" width="400px" style="padding: 10px;" />
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
    <?php $__env->stopSection(); ?>

        <!-- Javascripts -->






<?php echo $__env->make('seller::layouts.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>