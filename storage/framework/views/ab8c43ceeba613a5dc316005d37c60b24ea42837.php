 

<?php $__env->startSection('content'); ?>
                <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h3 style="font-weight: bold;padding-top: 10px;">  Direct Shipment to Customer </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                </div>
                                 <a href="<?php echo e(url('/logistics/customer/confirmed-orders')); ?>" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                <div class="panel-body">
                                           
                        <?php if($errors->any()): ?>
                            <ul class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(url('/logistics/direct_shipment')); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                           <?php if(!isset($trip)): ?>  <?php $trip =  new  App\Trip; ?>  <?php endif; ?>

                            <input type="hidden" value="<?php echo e($order_id); ?>" name="order_id"/>
                            <div class="form-group <?php echo e($errors->has('departure_date') ? 'has-error' : ''); ?>">
                                <label for="departure_date" class="col-md-4 control-label"><?php echo e('Departure Date'); ?></label>
                                <div class="col-md-6">
                                    <input class="form-control" name="departure_date" type="text" id="departure_date" value="<?php echo e(isset($trip->departure_date) ? $trip->departure_date : ''); ?>" >
                                    <?php echo $errors->first('departure_date', '<p class="help-block">:message</p>'); ?>

                                </div>
                            </div>
                            <div class="form-group <?php echo e($errors->has('departure_time') ? 'has-error' : ''); ?>">
                                <label for="departure_time" class="col-md-4 control-label"><?php echo e('Departure Time'); ?></label>
                                <div class="col-md-6">
                                    <input class="form-control" name="departure_time" type="text" id="departure_time" value="<?php echo e(isset($trip->departure_time) ? $trip->departure_time : ''); ?>" >
                                    <?php echo $errors->first('departure_time', '<p class="help-block">:message</p>'); ?>

                                </div>
                            </div>
                            <div class="form-group <?php echo e($errors->has('vehicle_id') ? 'has-error' : ''); ?>">
                                <label for="vehicle_id" class="col-md-4 control-label"><?php echo e('Bike / Vehicle'); ?></label>
                                <div class="col-md-6">

                                    <?php $vehicles = \App\Vehicle::pluck('registration_no', 'id')->prepend('Select Bike / Vehicle', ''); ?>
                                    <?php echo e(Form::select('vehicle_id', $vehicles, $trip->vehicle_id, ['class'=>'form-control'])); ?>

                                    <?php echo $errors->first('vehicle_id', '<p class="help-block">:message</p>'); ?>

                                </div>   
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-4">
                                    <input class="btn btn-primary" type="submit" value="<?php echo e(isset($submitButtonText) ? $submitButtonText : 'Create'); ?>">
                                </div>
                            </div>
                        </form>
                                  
                                </div>
                            </div>
                           
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <div class="page-footer">
                    <div class="container">
                        <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA </p>
                    </div>
                </div>
       
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>