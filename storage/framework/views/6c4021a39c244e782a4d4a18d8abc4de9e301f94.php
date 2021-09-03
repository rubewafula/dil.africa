<div class="container">
    <?php if(Session::has('flash_message')): ?>
    <div class="alert <?php echo e(Session::get('alert-class', 'alert-success')); ?> 
         alert-dismissable mess" style="margin: 5px 0px 0px 0px;background: #F3F3F3;border-color: #3c763d;padding: 5px 30px 5px 10px;">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <?php echo e(Session::get('flash_message')); ?>

    </div>
    <?php endif; ?>

    <?php if(Session::has('flash_message_error')): ?>
    <div class="alert <?php echo e(Session::get('alert-class', 'alert-danger')); ?> 
         alert-dismissable mess" style="margin: 5px 0px 0px 0px;background: #F3F3F3;border-color: #cc0000;padding: 5px 30px 5px 10px;">

        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <?php echo e(Session::get('flash_message_error')); ?>

    </div>
    <?php endif; ?>

    <?php if(isset($errors)): ?>
    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissable mess">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<!--<div class="row">
<div class="col-sm-12">


</div>
</div>-->
<script>
    $(document).ready(function () {

        $(".mess").fadeTo(8000, 4000).slideUp(4000, function () {
            $(".mess").slideUp(1000);
        });

        $(".mess2").fadeTo(8000, 4000).slideUp(4000, function () {
            $(".mess2").slideUp(4000);
        });
    });
</script>