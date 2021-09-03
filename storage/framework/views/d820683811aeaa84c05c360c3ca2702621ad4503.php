<?php $__env->startSection('content'); ?>

<div  class="container">
           <div class="page-breadcrumb " >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Incoming  Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                            			<div class="col-md-12">
                            				
                          <table class="table table-bordered" style="margin-left: 15px;width: 99%;">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Supplier</th>
      <th> Order Ref </th>
      <th> Product</th>
      <th> Product Variation </th>
      <th> Quantity</th>
      <th> Order Date </th>
      <th> Status</th>
      <th> Action</th>
     </tr>
  </thead>
  <tbody>

  	<?php $__currentLoopData = $seller_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  	<tr>
  		<td> <a  href="<?php echo e(url('logistics/supplier/'.$order->seller_id)); ?>" target="_BLANK"> <?php echo e($order->seller->name); ?></a> </td>
  		<td><?php echo e($order->order_reference); ?></td>
  	     <td><?php echo e($order->order_detail->product->name); ?> </td>
  	     <td>   
  	     	 <p>  
  	     	 	Color: <?php echo e($order->order_detail->product_price->color); ?>  <br/>
  	     	 	Size:  <?php echo e($order->order_detail->product->size); ?> <br/>
  	     	 </p>

  	     </td>
        <td><?php echo e($order->order_detail->quantity); ?></td>
        <td><?php echo e($order->order_detail->created_at->format('d/m/Y H:i')); ?></td>

        <td>    <?php echo e($order->order_status); ?>

  </td>
<td> 

 <a style="margin-bottom: 5px;" href="<?php echo e(url('logistics/receive_order/'.$order->id)); ?>" onclick=" return  confirm('You  are  about to  receive Order.Confirm')"  class="btn btn-success btn-sm" >  Receive  Order</a> &nbsp;&nbsp;&nbsp;&nbsp;

 <!--  <a  href="<?php echo e(url('logistics/reject_order/'.$order->id)); ?>"  class="btn  btn-danger  btn-sm"> Reject  Order </a> -->
 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject<?php echo e($order->id); ?>">Reject  Order</button>

 <div id="reject<?php echo e($order->id); ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject  Order</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo e(url('logistics/reject_at_warehouse')); ?>">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" name="seller_order_id"  value="<?php echo e($order->id); ?>">

          <div  class="form-group">
            <label> Reason </label>
            <textarea name="warehouse_rejection_reason"  class="form-control" 
            ></textarea>

          </div>

          <div  class="form-group">
            <input type="submit" class="btn  btn-info"  value="Proceed">

          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

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