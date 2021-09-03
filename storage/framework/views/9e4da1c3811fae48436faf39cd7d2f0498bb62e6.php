<?php $__env->startSection('content'); ?>

<div  class="container">
           <div class="page-breadcrumb " >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Delivered Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                      <div class="col-md-12">
                            				
                    <table class="table table-bordered" style="margin-left: 15px;width: 99%;">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Order Ref </th>
      <th> Customer Name</th>
      <th> Email Address </th>
      <th> Order Value</th>
      <th> Order  Status </th>
      <th> Ordered At</th>
      <th> Action</th>
     </tr>
  </thead>
  <tbody>

  	<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  	<tr>
  		<td><?php echo e($order->order_reference); ?></td>
  	     <td><?php echo e($order->user->first_name); ?> <?php echo e($order->user->last_name); ?></td>
  	     <td>   
          <?php echo e($order->user->email); ?>

  	     </td>
         <td><?php echo e($order->total_value); ?></td>
        <td><?php echo e($order->order_status); ?></td>
        <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
        <td> 
           <a style="margin-bottom: 10px;" href="<?php echo e(url('logistics/order-details/'.$order->id)); ?>" class="btn btn-success btn-sm" >  View Order Details</a>
        </td>
  	</tr>

  	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </tbody>
</table>
</div>
</div>	
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>