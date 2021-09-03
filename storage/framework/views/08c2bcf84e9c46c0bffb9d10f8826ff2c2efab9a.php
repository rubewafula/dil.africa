 
<?php $__env->startSection('content'); ?>
<div class="page-breadcrumb" >
    <?php echo e(Breadcrumbs::render()); ?>

</div>
<div id="main-wrapper" class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
      
                    <div class="card-body">
                        <a href="<?php echo e(url('/logistics/trips/'.$trip->id.'/orders')); ?>" title="Back">
                          <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr><th> Trip Name</th><td> <?php echo e($trip->name); ?> </td></tr>
                                <tr><th> Vehicle </th><td> <?php echo e($trip->vehicle->registration_no); ?> </td></tr>
                                <tr><th> Status </th><td> <?php echo e(($trip->active == 1)?"Active":"Inactive"); ?> </td></tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 style="font-weight: bold;background: #eee;padding: 10px;"> Add Order to this Trip </h3>
                </div>
                 
                <div class="panel-body">
                                            
                    <?php if($errors->any()): ?>
                        <ul class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>

                    <div>
                        
                        <table id="or" class="table table-bordered">
                            <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
                                <tr>
                                    <th>Ref.</th>
                                    <th>Customer</th>
                                    <th>Items Ordered</th>
                                    <th>Delivery Address</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->order_reference); ?></td>
                                <td><?php echo e($order->user->first_name); ?> <?php echo e($order->user->last_name); ?>, <?php echo e($order->user->phone); ?>, <?php echo e($order->user->email); ?></td>
                                <td><?php echo $order->getItemsOrdered(); ?> </td>
                                <td><?php echo $order->getDeliveryAddress(); ?> </td>
                                <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?> (<?php echo e($order->created_at->DiffForHumans()); ?>)</td>
                                <td>
                                    <a href="<?php echo e(url('/logistics/trips/orders/add-to-trip/'.$trip->id.'/' . $order->id)); ?>" title="Add to Trip"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;">Add</button></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                  
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