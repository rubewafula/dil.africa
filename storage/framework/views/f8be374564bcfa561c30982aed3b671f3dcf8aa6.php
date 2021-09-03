  
  <?php $__env->startSection('content'); ?>

             <div class="page-breadcrumb" >
                      <?php echo e(Breadcrumbs::render()); ?>


                  </div>
                  <div class="page-title">
                      <div class="container">
                          <h3>  Products Pending Quality Review</h3>
                      </div>
                  </div>
                  <div class="panel panel-white">

                    <div id="main-wrapper">

                      <div class="row">
                          
                          <div class="col-md-12">

  <table class="table table-bordered">
    <thead class="thead-dark" style="background-color:#f5f5f5;color:#888;">
      <tr>
        <th> Product  Code</th>
        <th> Name </th>
        <th> Category</th>
        <th> Status</th>
        <th> Brand</th>
        <th> Actions</th>

       </tr>
    </thead>
    <tbody>
    	   <form method="GET" action="<?php echo e(url('qc/products')); ?>" >
            <input type="hidden" name="search"  value="1">
            <tr>
              <td>
                <input type="text" name="product_code" >
              </td>
                 
                  <td>
              <input type="text" name="name">

              </td>
              <td></td>
                 <td>
                 	<!-- <select  name="publish_status" class="form-control">
                 		<option value=""> Select</option>
                 		<option value="0">DRAFT</option>
                 		<option value="1">PUBLISHED</option>
                 		<option  value="2">SUSPENDED</option>
                 		<option  value="3">UNPUBLISHED</option>
                    <option  value="4">SUBMITTED FOR QC</option>
                </select> -->
              </td>
              <td>
              	
              </td>
              <td>
                
                <input type="submit" class="btn-success orange-button"  value="Filter">
                </form>
                <a href="<?php echo e(url('qc/products')); ?>">
                  <input type="submit" class="btn-success blue-button"  value="Refresh">
                </a>
              </td>

            </tr>
                                           
  <?php if(count($products) > 0): ?>
  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <tr style="border-top: 1px solid #eee;">
  	<td><?php echo e($product->product_code); ?></td>
      <td style="max-width:300px;"><?php echo e($product->name); ?></td>
      <td>  

      <?php if(App\Category::where('id',$product->category_id)->exists()): ?>

        <?php echo e($product->category->name); ?>


      <?php endif; ?>

       </td>
       <td>
          <?php echo e($product->status); ?> 
       </td>
       <td>
           <?php if(App\Brand::where('id',$product->brand_id)->exists()): ?>

           <?php echo e($product->brand->name); ?>


           <?php endif; ?>
       </td>

      <td>
        <a href="<?php echo e(url('qc/product/'.$product->slug)); ?>" class="btn-warning btn-sm">Raw View</a>
        <a href="<?php echo e(url('qc/customer-view/'.$product->slug)); ?>" target="_blank" class="btn-success btn-sm">Customer View</a>
        <!-- <a style="margin-right: -14px;" href="<?php echo e(url('qc/delete_product/'.$product->id)); ?>" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete this product?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> -->
      </td>

  </tr>


  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <?php else: ?>
  <tr>
    <td  colspan="6"> No products require quality review</td>

  </tr>
  <?php endif; ?>

    </tbody>
  </table>
   </div>
  </div>

  </div>


</div>

<?php $__env->stopSection(); ?>              
<?php echo $__env->make('qc::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>