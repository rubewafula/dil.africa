<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="MediaCenter, Template, eCommerce">
        <meta name="robots" content="all">

        <title><?php echo e(isset($title)?$title:"DIL.AFRICA"); ?></title>

        <link rel="icon" type="image/png" href="<?php echo e(url('favicon.png')); ?>" />

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="<?php echo e(url('assets/css/bootstrap.min.css')); ?>">
        <!-- Customizable CSS -->
        <link rel="stylesheet" href="<?php echo e(url('assets/css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/blue.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/owl.carousel.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/owl.transitions.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/animate.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/rateit.css')); ?>">       
        <link rel="stylesheet" href="<?php echo e(url('assets/css/bootstrap-select.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(url('assets/css/anto_custom.css')); ?>">

        <!-- Icons/Glyphs -->
        <link rel="stylesheet" href="<?php echo e(url('assets/css/font-awesome.css')); ?>">

        <!-- Fonts --> 
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <script src="<?php echo e(url('assets/js/jquery-1.11.1.min.js')); ?>"></script>
    </head>
    <body class="cnt-home">

        <div id="successdialog" title="Success" style="color: #0F7DC2;overflow: hidden;">

        </div>

        <div id="failuredialog" title="Failed" style="color: #CC0000;overflow: hidden;">

        </div>

        <?php echo $__env->make('customer::layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('customer::layouts/notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make('customer::layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- For demo purposes – can be removed on production -->

        <!-- For demo purposes – can be removed on production : End -->

        <!-- JavaScripts placed at the end of the document so the pages load faster -->

        <script src="<?php echo e(url('assets/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/bootstrap-hover-dropdown.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/owl.carousel.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/echo.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/jquery.easing-1.3.min.js')); ?>"></script>     
        <script src="<?php echo e(url('assets/js/bootstrap-slider.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/jquery.rateit.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/lightbox.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/bootstrap-select.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/wow.min.js')); ?>"></script>
        <script src="<?php echo e(url('assets/js/scripts.js')); ?>"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123147179-1"></script>
        
        <script type="text/javascript">function add_chatinline(){var hccid=62277915;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline(); </script>
        
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-123147179-1');
        </script>

    </body>
</html>