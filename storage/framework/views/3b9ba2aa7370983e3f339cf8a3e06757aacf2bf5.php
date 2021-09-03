<?php $__env->startSection('content'); ?>

           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     
                               <div class="panel-heading clearfix"> <strong>Customer Confirmed Orders </strong> Awaiting  Shipment</div>

                            <div class="panel panel-white">
                            	    <div class="panel-body">
 <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Ref </th>
      <th> Order Details</th>
      <th> Delivery Location</th>
      <th> Order Date </th>
      <th> Assigned To </th>
     </tr>
  </thead>

    <tbody>
     <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <tr>
     	<td> <?php echo e($order->order_reference); ?> </td>
     	<td>  
     		<?php $__currentLoopData = $order->order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <?php if($detail != null): ?>
     		   <ol>
     		   	<li>
              <u> Product: <?php echo e(str_limit($detail->product->name, 50,'...')); ?> </u>
                Qty:<?php echo e($detail->quantity); ?> <br/>
              <a href="">By <?php echo e($detail->product->seller->name); ?> </a>
            </li>
     		   </ol>
        <?php endif; ?>
     		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     	</td> 
      <td>
         <?php echo $order->getDeliveryAddress(); ?>

      </td>
      <td>
      <?php echo e($detail->created_at->format('Y-m-d H:i')); ?> 
      (<?php echo e($detail->created_at->DiffForHumans()); ?>)    
          </td>
    <td> 
         <form method="POST"  action="<?php echo e(url('logistics/assign_warehouse')); ?>">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <div class="form-group">

              <?php $warehouses = App\Warehouse::pluck('name', 'id')->prepend('Select Warehouse', ''); ?>

              <?php echo e(Form::select('warehouse_id', $warehouses, $order->warehouse_id or '',['class'=>'form-control'])); ?>


              <input  style="margin-top: 10px;" type="submit"  class="btn  btn-primary blue-bg" value="Ship to Selected Warehouse">

            </div>
    </form>  

    <a href="<?php echo e(url('logistics/direct-shipment/'.$order->id)); ?>">
      <button class="btn  btn-success orange-bg" style="margin-left: 0px;">Direct Shipment to Customer</button>
    </a>   

    </td>

     </tr>

     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </tbody>
</table>
                                	
                </div>
            </div>

        </div>
    </div>
</div>
              

<?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>