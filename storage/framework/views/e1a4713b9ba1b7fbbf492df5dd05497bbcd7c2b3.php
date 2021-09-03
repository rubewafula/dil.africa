	

	<?php $__env->startSection('content'); ?>
	<div id="main-wrapper" class="container" >
    <div class="row">
        <div class="col-md-6">

            <div class="panel">
          	<div class="panel-body" style="min-height: 400px;">

      		<div class="row">
        	<div class="col-lg-12 col-md-12">
            <h3>Latest  Seller Orders </h3>

              <table id="or" class="table table-bordered">

					<thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
						<tr>
						<th>Ref.</th>
						<th>Seller</th>
						<th>Product</th>
						<th>Qty</th>
						<th>Order Date</th>

						</tr>
					</thead>
					<tbody>

					<?php $__currentLoopData = $seller_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
					<td><?php echo e($order->order_reference); ?></td>
					<td><?php echo e(ucwords($order->seller->name)); ?></td>
					<?php if($order->order_detail != null): ?>
					<?php if($order->order_detail->product != null): ?>
					<td><?php echo e($order->order_detail->product->name); ?> </td>
					<?php endif; ?>
					<?php endif; ?>
					<td><?php echo e($order->order_detail->quantity); ?></td>
					<td><?php echo e($order->order_detail->created_at->format('d/m/Y H:i')); ?> (<?php echo e($order->order_detail->created_at->DiffForHumans()); ?>)</td>

					</tr>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					</tbody>
					</table>
					        </div>
					    </div>

                    </div>
                </div>

            </div>

           <div  class="col-md-6">
            
            <div class="panel">
          
          		<div class="panel-body" style="min-height: 400px;">

		      		<div class="row">
		        	<div class="col-lg-12 col-md-12">
		            <h3>Latest  Customer Orders </h3>

		              <table id="or" class="table table-bordered">

							<thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
								<tr>
								<th>Ref.</th>
								<th>Customer</th>
								<th>Delivery Address</th>
								<th>Order Date</th>
								</tr>
							</thead>
							<tbody>
							<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							<tr>
								<td><?php echo e($order->order_reference); ?></td>
								<td><?php echo e(ucwords($order->user->first_name)); ?> <?php echo e(ucwords($order->user->last_name)); ?>, <?php echo e($order->user->phone); ?>, <?php echo e($order->user->email); ?></td>
								<td><?php echo ucwords($order->getDeliveryAddress()); ?> </td>
								<td><?php echo e($order->created_at->format('d/m/Y H:i')); ?> (<?php echo e($order->created_at->DiffForHumans()); ?>)</td>
							</tr>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</tbody>
							</table>
						</div>
					</div>

		        </div>
        	</div>

           </div>
        </div>
    </div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>