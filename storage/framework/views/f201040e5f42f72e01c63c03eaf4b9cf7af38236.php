<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title> DIL.AFRICA | <?php if(isset($title)): ?> <?php echo e($title); ?> <?php else: ?> Home  <?php endif; ?></title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="<?php echo e(url('assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(url('assets/backend/plugins/uniform/css/uniform.default.min.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(url('assets/backend/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/fontawesome/css/font-awesome.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/line-icons/simple-line-icons.css')); ?>" rel="stylesheet" type="text/css"/> 
        <link href="<?php echo e(url('assets/backend/plugins/waves/waves.min.css')); ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo e(url('assets/backend/plugins/switchery/switchery.min.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/3d-bold-navigation/css/style.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/slidepushmenus/css/component.css')); ?>" rel="stylesheet" type="text/css"/> 
        <link href="<?php echo e(url('assets/backend/plugins/weather-icons-master/css/weather-icons.min.css')); ?>" rel="stylesheet" type="text/css"/>   
        <link href="<?php echo e(url('assets/backend/plugins/metrojs/MetroJs.min.css')); ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo e(url('assets/backend/plugins/toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>    
            
        <!-- Theme Styles -->
        <link href="<?php echo e(url('assets/backend/css/modern.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/css/custom.css')); ?>" rel="stylesheet" type="text/css"/>
 <link href="<?php echo e(url('assets/backend/plugins/bootstrap-datepicker/css/datepicker3.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/bootstrap-colorpicker/css/colorpicker.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('assets/backend/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')); ?>" rel="stylesheet" type="text/css"/>
        <script src="<?php echo e(url('assets/backend/plugins/jquery/jquery-2.1.4.min.js')); ?>"></script>

 <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

         <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


        
        <script src="<?php echo e(url('assets/backend/plugins/3d-bold-navigation/js/modernizr.js')); ?>"></script>

         <script src="<?php echo e(url('vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script>
        <script src="<?php echo e(url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')); ?>"></script>

           <script type="text/javascript">
            $(document).ready(function(){

                var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };

                  $(".textarea").ckeditor(options);


            });

        </script>

        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
        <![endif]-->

        <style type="text/css">
            
            .page-title .container{
                padding-top: 15px;
            }

        </style>
        
    </head>
    <body class="page-header-fixed compact-menu page-horizontal-bar">
        <div class="overlay"></div>
         <?php echo $__env->make('backend::layouts.chat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div><!-- Input Group -->
        </form><!-- Search Form -->
        <main class="page-content content-wrap">
            <div class="navbar" style="border-bottom: 0px;">
                <div class="navbar-inner container">
                    
                    <div class="logo-box">
                        <a href="<?php echo e(url('backend')); ?>" class="logo-text">
                           <img src="<?php echo e(url('assets/backend/images/logo.png')); ?>" alt="Logo"> </a>
                    </div><!-- Logo Box -->
                   
                    <div class="topmenu-outer">
                        <div class="top-menu">
                       
                            <ul class="nav navbar-nav navbar-right">
                            
                               <?php echo $__env->make('backend::layouts.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                               <?php echo $__env->make('backend::layouts.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                              <?php echo $__env->make('backend::layouts.profile_overview', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>

                </div>
                                <?php echo $__env->make('backend::layouts.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    </div>

           <?php echo Toastr::render(); ?>


            <div class="page-inner" style="margin-top:100px;">
                 <?php if(Session::has('flash_message')): ?>
<div class="mess alert <?php echo e(Session::get('alert-class', 'alert-success')); ?> alert-dismissable" style="margin-top: 10px;"> 
 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
<?php echo e(Session::get('flash_message')); ?></div>
 <?php endif; ?>
                    <?php if($errors->any()): ?>

                    <ul class="alert alert-danger"  style="margin-top: 10px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                   

                <?php echo $__env->yieldContent('content'); ?>
            
            </div><!-- Page Inner -->

        </main><!-- Page Content -->
        <nav class="cd-nav-container" id="cd-nav">
            <header>
                <h3>Navigation</h3>
                <a href="#0" class="cd-close-nav">Close</a>
            </header>
            <ul class="cd-nav list-unstyled">
                <li class="cd-selected" data-menu="index">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li data-menu="profile">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <p>Profile</p>
                    </a>
                </li>
                <li data-menu="inbox">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-envelope"></i>
                        </span>
                        <p>Mailbox</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-tasks"></i>
                        </span>
                        <p>Tasks</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-cog"></i>
                        </span>
                        <p>Settings</p>
                    </a>
                </li>
                <li data-menu="calendar">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <p>Calendar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="cd-overlay"></div>
    

        <!-- Javascripts -->
        <script src="<?php echo e(url('assets/backend/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/pace-master/pace.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/jquery-blockui/jquery.blockui.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/switchery/switchery.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/uniform/jquery.uniform.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/classie/classie.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/waves/waves.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/3d-bold-navigation/js/main.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/waypoints/jquery.waypoints.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/jquery-counterup/jquery.counterup.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/toastr/toastr.min.js')); ?>"></script>
       <script src="<?php echo e(url('assets/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>"></script>

    </body>
</html>