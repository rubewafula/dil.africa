<?php $__env->startSection('content'); ?>

           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Order 
                        <?php echo e($order->order_reference); ?> from <?php echo e($order->user->name); ?>

                         <span  class="pull-right"> Status:
                            <?php if($order->order_status !== NULL): ?>
                            <?php echo e($order->order_status); ?>


                            <?php else: ?>
                            NEW
                            <?php endif; ?>

                           </span></h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                	<div  class="top-sectionn">
                		<div  class="row">
                			
                			<div  class="col-md-3">
                				 <div class="panel info-box panel-white" style="height: 100px">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> <?php echo e($order->created_at->format('d/m/Y h:i A')); ?></p>
                                        <span class="info-box-title">Order  date </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                			</div>

                			<div  class="col-md-3">
                				 <div class="panel info-box panel-white"  style="height: 100px">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> KES <?php echo e(number_format($order->total_value)); ?></p>
                                        <span class="info-box-title">Total </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                			</div>

                			<div  class="col-md-3">
                				 <div class="panel info-box panel-white"  style="height: 100px">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> <?php echo e($order->messages->count()); ?></p>
                                        <span class="info-box-title">Messages </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                			</div>

                			<div  class="col-md-3">
                				 <div class="panel info-box panel-white"  style="height: 100px">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> <?php echo e($order->order_details->count()); ?></p>
                                        <span class="info-box-title">Products </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                			</div>

                		</div>

                	</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                             <div class="panel-body">
                             	 <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">

                                               <li role="presentation" class="active"><a href="#operations" role="tab" data-toggle="tab"> <span class="glyphicon glyphicon-files" aria-hidden="true"></span>   Operations</a></li>

                                                <li role="presentation"   ><a href="#products" role="tab"   data-toggle="tab">Product  Information</a></li>
                                                  <li role="presentation"   ><a href="#supplier" role="tab"   data-toggle="tab">Supplier  Fullfillment</a></li>
                                              
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">

                                                <div role="tabpanel" class="tab-pane active" id="operations">
                                
                                                    <?php if($order->order_status == "NEW" || $order->order_status == null): ?>
                                                    <div  class="row">
                                                        <div  class="col-md-1">
                                                            <a  href="<?php echo e(url('backend/accept_order/'.$order->id)); ?>" class="btn btn-success"> Accept Order</a>
                                                        </div>
                                                        <div  class="col-md-2">
                                                            <a  style="margin-left: 20px;" href="<?php echo e(url('backend/cancel_order/'.$order->id)); ?>" class="btn btn-danger"> Cancel  Order</a>
                                                        </div>

                                                    </div>
                                                    <?php endif; ?>

                                                    	
                                                    	  </div>


                                                

                          <div role="tabpanel" class="tab-pane " id="products">
                          	<table  class="table">
                                                    		<thead>
                                                    			<tr>
                                                    				<th></th>
                                                    				<th> Supplier</th>
                                                    				<th>Product</th>
                                                    				<th> Price</th>
                                                    				<th> Qty</th>
                                                    				<th> Total</th>

                                                    			</tr>
                                                    		</thead>
                                                    		<tbody>
                                            <?php $__currentLoopData = $order->order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                            	<td>  
                                            		<?php $image= App\Product_image::where(['product_id'=>$detail->product_id,'default'=>1])->first(); ?>
 													<?php if(!empty($image)): ?>
 					<img src="<?php echo e(url('assets/images/products/'.$detail->image_url)); ?>" width="50px" width="50px" alt="<?php echo e($detail->product->name); ?>"
 													/>

 													<?php else: ?>
 													No image 
 													<?php endif; ?>


                                            	</td>
                                            	<td> <a href="<?php echo e(url('backend/sellers/manage/'.$detail->product->seller_id)); ?>"> <?php echo e($detail->product->seller->name); ?></a></td>
                                            	<td><?php echo e($detail->product->name); ?></td>
                                            	<td><?php echo e($detail->price); ?></td>
                                            	<td><?php echo e($detail->quantity); ?></td>
                                            	<td><?php echo e($detail->price *  $detail->quantity); ?></td>

                                            </tr>


                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    		</tbody>

                                                    	</table>

                                                    	<div class="row"> 
                                                    		<div class="col-md-6"> 

                                                    		</div>
                                                    		<div class="col-md-6"> 
                                                    			<div class="voucher">
                                                    			<table class="table">
                                                    				<tr> 

                                                    	    <th> Discount Name</th>
                                                          	<th>  Value </th>
                                                    				</tr>
                                          <?php $__currentLoopData = $order->discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr> 
                                                <td><?php echo e($discount->name); ?></td>
                                                <td><?php echo e($discount->value); ?></td>

                                                </tr>


                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    			</table> 


                                                    			</div>

                                                    		</div>
                                                    	</div>

                                                    	 	<div class="row" style="margin-top:10px"> 
                                                    		<div class="col-md-6"> 

                                                    		</div>
                                                    		<div class="col-md-6"> 
                                                    			<div class="voucher">
                                                    			<table class="table">
                                                    				<tr> 

                                                    	    <th> Discount </th>
                                                         <th>  <?php echo e($order->discounts->sum('value')); ?> </th>
                                                     </tr> 
                                                     <tr>

                                                         <th>   Shipping  Charges</th>

                                                         <td> <?php echo e(number_format($order->shipping_charges)); ?> </td>
                                                     </tr>
                                                     <tr>
                                                         <th> Total </th>
                                                         <th> <?php echo e(number_format($order->total_value)); ?></th>
                                                    				</tr>
                                         


                                                    			</table> 


                                                    			</div>

                                                    		</div>
                                                    	</div>
                                                 </div>
      <div role="tabpanel" class="tab-pane " id="supplier">
            <table  class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th> Supplier</th>
                                                                    <th>Product</th>
                                                                    <th> Price</th>
                                                                    <th> Qty</th>
                                                                    <th> Status</th>
                                                                    <td> Status</td>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php $__currentLoopData = $order->order_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>  
                                                    <?php $image= App\Product_image::where(['product_id'=>$detail->product_id,'default'=>1])->first(); ?>
                                                    <?php if(!empty($image)): ?>
                                                    <img src="<?php echo e(url('assets/images/products/'.$detail->image_url)); ?>" alt="<?php echo e($detail->product->name); ?>"
                                                    />

                                                    <?php else: ?>
                                                    No image 
                                                    <?php endif; ?>


                                                </td>
                                                <td> <a href="<?php echo e(url('backend/sellers/manage/'.$detail->product->seller_id)); ?>"> <?php echo e($detail->product->seller->name); ?></a></td>
                                                <td><?php echo e($detail->product->name); ?></td>
                                                <td><?php echo e($detail->price); ?></td>
                                                <td><?php echo e($detail->quantity); ?></td>
                                                
                                                <td> 

                                             <?php $seller_order= App\Seller_order::where('order_detail_id',$detail->id)->first();  ?>
                                             
                                             <?php if(!empty($seller_order)): ?>

                                             <td> 
                                                   <?php if($seller_order->shipping_status_id > 0): ?>
                                                   
                                                   <?php echo e($seller_order->shipping_status->name); ?>


                                                   <?php else: ?>

                                                   NEW

                                                   <?php endif; ?>

                                                 

        <?php if($seller_order->shipping_status_id == 1 || $seller_order->shipping_status_id == 2): ?>


<button type="button" class="btn btn-info" data-toggle="modal" data-target="#receive<?php echo e($seller_order->id); ?>">Receive </button>

<div id="receive<?php echo e($seller_order->id); ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Receive Products  to  Warehouse</h4>
      </div>
      <div class="modal-body">
        <p> 
<form  method="POST" action="<?php echo e(url('backend/receive_products')); ?>">

    <input  type="hidden" name="seller_order_id" value="<?php echo e($seller_order->id); ?>">
    <input  type="hidden" name="product_id" value="<?php echo e($detail->product_id); ?>">

    <?php echo e(csrf_field()); ?>

    <div  class="row">
        <div  class="col-md-6">
            <div  class="form-group">
                <label> Select  Warehouse</label>
                <select  name="warehouse_id"  class="form-control">
                    <?php $warehouses= App\Warehouse::get(); ?>

                    <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <option value="<?php echo e($warehouse->id); ?>">  <?php echo e($warehouse->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>
        </div>
    </div>

    <div  class="row">
        <div  class="col-md-6">
            <div  class="form-group">
                <label>Quantity</label>
                <input type="text" name="quantity" class="form-control">
            </div>
        </div>
    </div>
    <div  class="row">
        <div  class="col-md-6">
            <div  class="form-group">
                <input type="submit"  class="btn btn-warning"  value="Receive">
    </div>
</div>
</div>

</form>

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




                                                 <?php endif; ?> 


                                             <?php endif; ?>        

                                        

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
                        </div>
                    </div>
                   </div>
               </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>