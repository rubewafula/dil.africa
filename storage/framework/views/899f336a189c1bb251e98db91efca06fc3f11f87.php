 

<?php $__env->startSection('content'); ?>
<div class="page-breadcrumb" >
   <?php echo e(Breadcrumbs::render()); ?>


</div>
<div class="page-title">
    <div class="container">
        <h3> Edit  Trip #<?php echo e($trip->id); ?> </h3>
    </div>
</div>
<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                </div>
                 <a href="<?php echo e(url('/logistics/trips')); ?>" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <div class="panel-body">

                <form method="POST" action="<?php echo e(url('/logistics/trips/' . $trip->id)); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    <?php echo e(method_field('PATCH')); ?>

                    <?php echo e(csrf_field()); ?>


                    <?php echo $__env->make('logistics::trips.form', ['submitButtonText' => 'Update'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </form>
                  
        </div>
    </div>
           
    </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->
<div class="page-footer">
    <div class="container">
        <p class="no-s"><?php echo date('Y') ?>&copy; DIL.AFRICA</p>
    </div>
</div>
           
<?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>