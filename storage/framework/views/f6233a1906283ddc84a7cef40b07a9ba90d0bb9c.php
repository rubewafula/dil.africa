<?php $__env->startSection('content'); ?>
        <div class="body-content">

                <div class="main-header" style="border-bottom: 2px solid #108bea;">

                        <div class="container">
                            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                                <!-- ============================================================= LOGO ============================================================= -->
                                <div class="logo">
                                    <a href="<?php echo e(url('/')); ?>">

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

                        <?php if($errors->any()): ?>
                            <ul class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>

            <h3> QUALITY  CONTROL</h3>
                                    <div class="row">
                                
                                        <div class="col-md-12">
                                        <form class="form-horizontal" method="POST" action="<?php echo e(url('/shop/login')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus>

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
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

                    
                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-5">
                            <img src="<?php echo e(url('assets/images/qc.png')); ?>" width="400px" style="padding: 10px;" />
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
    <?php $__env->stopSection(); ?>

        <!-- Javascripts -->
<?php echo $__env->make('qc::layouts.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>