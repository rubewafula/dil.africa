<?php $__env->startSection('content'); ?>

<div  class="container">
           <div class="page-breadcrumb " >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Rejected Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                      <div class="col-md-12">
                            				
                          <table class="table table-bordered" style="width: 99%;margin-left: 15px;">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Supplier</th>
      <th> Order Ref </th>
      <th> Product</th>
      <th> Product Variation </th>
      <th> Quantity</th>
      <th> Order  Date </th>
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
  	     	 	Size:   <?php echo e($order->order_detail->product->size); ?> <br/>
  	     	 </p>

  	     </td>
        <td><?php echo e($order->order_detail->quantity); ?></td>
        <td><?php echo e($order->order_detail->created_at->format('d/m/Y H:i')); ?></td>

        <td>    <?php echo e($order->order_status); ?>

</td>
       <td> 

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