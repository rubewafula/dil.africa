<!DOCTYPE html>
   <html>
    <head>
        
        <!-- Title -->
        <title> DIL.AFRICA | <?php if(isset($title)): ?> <?php echo e($title); ?> <?php else: ?> Seller  Dashboard  <?php endif; ?> </title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="DIL.AFRICA" />
        <meta name="keywords" content="DIL.AFRICA" />
        <meta name="author" content="Steelcoders" />

        <link rel="icon" type="image/png" href="<?php echo e(url('favicon.png')); ?>" />
        
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

        <link href="<?php echo e(url('assets/backend/css/jquery-te-1.4.0.css')); ?>" rel="stylesheet" type="text/css"/>

        <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?php echo e(url('assets/css/main.css')); ?>">
        
        <script src="<?php echo e(url('assets/backend/plugins/3d-bold-navigation/js/modernizr.js')); ?>"></script>
        <script src="<?php echo e(url('assets/backend/plugins/jquery/jquery-2.1.4.min.js')); ?>"></script>

        <script src="<?php echo e(url('assets/backend/js/jquery-te-1.4.0.min.js')); ?>"></script>
        <script src="<?php echo e(url('vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script>
        <script src="<?php echo e(url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')); ?>"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
        <![endif]-->

        <script type="text/javascript">

            $(document).ready(function(){

                 $('#start_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                 $('#end_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                 $('#product_expiry_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                // $('#product_expiry_date').prop('disabled', 'disabled');

                //  $("#product_expiry_box").change(function() {
                //     if(this.checked) {
                //         $('#product_expiry_date').prop('disabled', false);
                //     }else{
                //         $('#product_expiry_date').prop('disabled', 'disabled');
                //     }
                // });

                var options = {
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                  };

                  // $('textarea').ckeditor(options);
                  
                  CKEDITOR.replace( 'desc' );

            });

        </script>
        
    </head>
    <body class="compact-menu page-horizontal-bar">
        <div class="overlay"></div>
      
        <main class="content-wrap">
            
            <?php echo $__env->make('seller::layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         
            <div class="page-inner container">
                     
                <?php echo $__env->make('seller::layouts.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      
                <?php echo $__env->yieldContent('content'); ?>

                <?php echo $__env->make('seller::layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                
            </div><!-- Page Inner -->

        </main><!-- Page Content -->
       
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