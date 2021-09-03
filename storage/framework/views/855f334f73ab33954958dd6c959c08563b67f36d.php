<?php $__env->startSection('content'); ?>

           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Products  </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> Total products :  </div>

                            <div class="panel panel-white">
                              <div class="panel-body">
                              	<div  class="row">
                              		<div class="col-md-12">
                              			


                          <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Product  Code </th>
      <th> Product </th>
      <th> Seller</th>
      <th> Status</th>
      <th> Qty  sold </th>
      <th> Qty  remaining </th>

      <th> Actions</th>

     </tr>
  </thead>
  <tbody>

    <form method="GET"  action="<?php echo e(url('backend/products')); ?>">
      <input type="hidden" name="search"  value="1">
      <td>
        <input type="text" name="product_code">

      </td>
      <td> 
       <input type="text" name="product">
       </td>
       <td></td>
        <td> 
<select name="publish_status" class="form-control" >
    <option  value="-1">Select</option>
  <option  value="1">PUBLISHED</option>
  <option  value="2">SUSPENDED</option>
  <option  value="3">UNPUBLISHED</option>
  
</select>
       </td>
      <td></td>

       <td></td>
      
       <td>
         <input  type="submit"  class="btn-warning" value="Filter">

       </td>


    </form>


  	<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

  	<tr>
  		<td><?php echo e($product->product_code); ?></td>
  		<td>  
  			<?php echo e($product->name); ?>

  		  </td>
  		  <td>
          <?php if(App\Seller::where('id',$product->seller_id)->exists()): ?>
          <?php echo e($product->seller->name); ?>

          <?php endif; ?>
        </td>

  		  <td>

           <?php echo e($product->status); ?>

        </td>
  		  <td>

          <?php echo e(count($product->order_details)); ?>

       </td>
       <td>
         
         <?php echo e($product->prices->sum('quantity')); ?>

       </td>
       <td> 
        <a  href="<?php echo e(url('backend/product/'.$product->slug)); ?>" class="btn  btn-primary"> Manage </a> 

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