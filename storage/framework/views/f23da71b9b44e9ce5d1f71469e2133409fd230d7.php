<?php $__env->startSection('content'); ?>

           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Manage : <?php echo e($seller->name); ?> </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-white">
                            	   <div class="panel-body">


                                        <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                                                           
                                                <li role="presentation" class=" active"><a href="#seller" role="tab" data-toggle="tab" > Seller details</a></li>
                                                 <li role="presentation"><a href="#users" role="tab" data-toggle="tab">Users  </a></li>
                                                <li role="presentation"><a href="#products" role="tab" data-toggle="tab">Products </a></li>

                                                <li role="presentation"><a href="#orders" role="tab" data-toggle="tab">Orders</a></li>

                                            </ul>
                                        </div>

                                           <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="seller">

                                                	  <!--   <form method="POST" action="<?php echo e(url('/backend/sellers/' . $seller->id)); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"> -->

                                                        <?php echo Form::model($seller, [
                            'method' => 'PATCH',
                            'url' => ['/backend/sellers', $seller->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]); ?>



                            <?php echo e(method_field('PATCH')); ?>

                            <?php echo e(csrf_field()); ?>


                            <?php echo $__env->make('backend::sellers.form', ['submitButtonText' => 'Update'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </form>

                                                </div>

                                                <div role="tabpanel" class="tab-pane" id="users"> 
                                                    <div  class="col-md-4 col-sm-12">
                                                     <span  class="pull-left"> <a href="<?php echo e(url('backend/sellers/manage/'.$seller->id.'/new_user')); ?>" class="btn btn-success btn-sm" title="Add New " target="_BLANK">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>                                

                                                                                </div>

                                                  <?php $users=  App\User::where('seller_id',$seller->id)->get(); ?>

                                                   <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                          <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">

                                            <tr>
                                               <tr>
                                        <th>#</th><th>First Name</th><th>Last Name</th><th>Email</th>
                                                      <th>Status</th>

                                        <th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                      
                                       <tbody>
                                        <?php if($users->count() >0 ): ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(isset($loop->iteration) ? $loop->iteration : $item->id); ?></td>
                                        <td><?php echo e($item->first_name); ?></td>
                                        <td><?php echo e($item->last_name); ?></td>
                                        <td><?php echo e($item->email); ?></td>
                                        <td><?php echo e($item->status); ?></td>


                                        <td>
                                            
                                            <a href="<?php echo e(url('/backend/users/' . $item->id . '/edit')); ?>" target="_BLANK" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="<?php echo e(url('/backend/users' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                                <?php echo e(method_field('DELETE')); ?>

                                                <?php echo e(csrf_field()); ?>

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php else: ?>
                                <tr>
                                  <td colspan="4">  You have  not  added  any  users</td>
                                </tr>

                                <?php endif; ?>
                                          
                                        
                                        </tbody>
                                       </table>  


                                                 </div>

                                                 <div role="tabpanel" class="tab-pane" id="products"> 
                                                 	<div  class="row">  

                                                 		<div  class="col-md-12"> 

                                                 			  <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Name </th>
      <th> Category</th>
      <th> Status</th>
      <th> Brand</th>
      <th> Actions</th>

     </tr>
  </thead>
  <tbody>
<?php $__currentLoopData = $seller->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($product->name); ?></td>
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
      
      &nbsp;&nbsp;&nbsp;&nbsp;
<a  href="<?php echo e(url('seller/product/'.$product->slug)); ?>" class="btn-warning btn-sm">  
   Manage <span class="glyphicon glyphicon-signal" aria-hidden="true"></span></a>
      &nbsp;&nbsp;&nbsp;&nbsp;

      <a  href="<?php echo e(url('seller/delete_product/'.$product->id)); ?>" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>



     </td>

</tr>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </tbody>
</table>
                                                 		</div>

                                                 	</div>
                                                

                                                 </div>

                                                     <div role="tabpanel" class="tab-pane" id="orders"> 
                                                        <h3>  Supplier  Orders</h3>
                                                          <div  class="row">
                                                              <div  class="col-md-12">
                                                                  
    <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Order  reference </th>
      <th> Date</th>
      <th> Amount</th>
      <th> Status</th>
     </tr>
  </thead>

  <?php if($seller->orders->count() > 0): ?>

  <?php $__currentLoopData = $seller->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($order->order_reference); ?></td>
    <td><?php echo e($order->order_date); ?></td>
    <td> <?php echo e($order->order_detail->price); ?></td>
    <td>
      <?php echo e($order->order_status); ?>



    </td>

</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>

<tr>
    <td colspan="4"> No  Orders</td>
</tr>
<?php endif; ?>
  <tbody>
  </tbody>
</table>

                                                              </div>

                                                          </div>   
                                                 


                                                 </div>

                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>