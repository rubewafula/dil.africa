<?php $__env->startSection('content'); ?>

           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Orders  </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> Realtime  Orders  </div>

                            <div class="panel panel-white">
                              <div class="panel-body">
                              	<div  class="row">
                              		<div class="col-md-12">
                              			


                          <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#FFA200;color:#fff">
    <tr>
      <th> Order Ref </th>
      <th> Customer</th>
      <th>  Amount</th>
      <th> Order  Date </th>
      <th> Status  </th>

      <th> Actions</th>

     </tr>
  </thead>
  <tbody>

    <form method="GET"  action="<?php echo e(url('backend/orders')); ?>">
      <input type="hidden" name="search"  value="1">
      <td>
        <input type="text" name="order_reference">

      </td>
      <td> 
       <input type="text" name="customer">
       </td>
       <td></td>
       <td></td>
       <td> 
<select name="order_status" class="form-control" >
    <option  value="-1">Select</option>
  <option  value="">NEW</option>
  <option  value="DELIVERED">DELIVERED</option>
  <option  value="DISPATCHED">DISPATCHED</option>
  <option  value="READY">READY</option>
  <option  value="REFUNDED">REFUNDED</option>
</select>
       </td>
       <td>
         <input  type="submit"  class="btn-warning" value="Filter">

       </td>


    </form>


  	<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  	<tr>
  		<td><?php echo e($order->order_reference); ?></td>
  		<td>  
  			<?php if(App\User::where('id',$order->user_id)->exists()): ?>
  			       <?php echo e($order->user->full_name); ?> (<?php echo e($order->user->email); ?>)
  			<?php endif; ?>
  		  </td>
  		  <td><?php echo e(number_format($order->total_value)); ?></td>

  		  <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?> (<?php echo e($order->created_at->DiffForHumans()); ?>)</td>
  		  <td>

          <?php if($order->order_status !== NULL): ?>

         <?php echo e($order->order_status); ?>

          <?php else: ?>
            NEW

          <?php endif; ?>
       </td>
       <td> 
        <a  href="<?php echo e(url('backend/customer/order/'.$order->id)); ?>" class="btn  btn-primary"> Manage </a> 


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
                        </div>
                    </div>
              

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>