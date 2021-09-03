  

  <?php $__env->startSection('content'); ?>
        <div class="page-breadcrumb" >
           <?php echo e(Breadcrumbs::render()); ?>


        </div>

        <div class="page-title">
            <div class="container" class="blue-text" style="padding: 10px;font-size: 18px;">
                Customer Orders in the Trip <?php echo e($trip->id); ?>

            </div>
        </div>
        <div class="container">
          <div class="row">

            <div class="col-md-12">
                <div class="card">
      
                    <div class="card-body">

                        <a href="<?php echo e(url('/logistics/trips')); ?>" title="Back">
                          <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Trip Name</th><td> <?php echo e($trip->name); ?> </td></tr>
                                    <tr><th> Vehicle </th><td> <?php echo e($trip->vehicle->registration_no); ?> </td></tr>
                                    <tr><th> Status </th><td> <?php echo e(($trip->active == 1)?"Active":"Inactive"); ?> </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                         <h4 class="panel-title"></h4> 
                    </div>
                    <div class="panel-body">

                        
                       <div class="table-responsive">

                         <div  class="row">
                            <div  class="col-md-4 col-sm-12">
                              <form method="GET" action="<?php echo e(url('/logistics/trips/'.$trip->id.'/orders')); ?>" accept-charset="UTF-8" class="form-inline " role="search">
                                  
                                      <div class="input-group">
                                      <div class="form-group mx-sm-12 mb-12">
                                        <input type="text" class="form-control"  name="search" value="<?php echo e(request('search')); ?>" placeholder="Search">
                                      </div>
                                        <span class="input-group-append">

                                          <button class="btn btn-secondary" type="submit" style="margin-bottom: 5px;">
                                              <i class="fa fa-search"></i>
                                          </button>
                                      </span>
                                  </div>
                              </form>
                    </div>

                    <?php if($trip_orders->first()->order->order_status != 'DISPATCHED'): ?>
                    <div  class="col-md-8 col-sm-12">
                      <span  class="pull-right"> 
                        <a href="<?php echo e(url('/logistics/trips/orders/dispatch_orders/'.$trip->id)); ?>" title="Dispatch Orders in this Trip">
                          <button class="btn btn-success btn-sm" style="background: #0F7DC2;margin-right: 10px;" onclick="return confirm(&quot;Are you sure you want to dispatch orders in this trip?&quot;)"><i class="fa fa-plus" aria-hidden="true"></i> Dispatch Orders in this Trip</button>
                        </a>
                        <a href="<?php echo e(url('/logistics/trips/'.$trip->id.'/orders/create')); ?>" class="btn btn-success btn-sm" title="Add New ">
                      <i class="fa fa-plus" aria-hidden="true"></i> Add New Order to this Trip
                        </a> 
                      </span>                                
                    </div>
                    <?php endif; ?>

                        </div>
                        <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                <tr>
                                   <tr>
                            <th>Order Ref</th>  
                            <th>Customer</th> 
                            <th>Mode of Delivery</th>
                            <th>Delivery Address</th>
                            <th>Date</th>
                            <th>Status</th>  
                            <th>Comments</th> 
                            <th>Action</th>
                                </tr>
                              </tr>
                            </thead>
                            <tbody>
                          <?php $__currentLoopData = $trip_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->order->order_reference); ?></td>
                            <td><?php echo e($item->order->user->first_name); ?>, <?php echo e($item->order->user->last_name); ?>, <?php echo e($item->order->user->email_address); ?>, <?php echo e($item->order->user->phone); ?></td>
                            <td><?php echo e($item->order->shipping_type->name); ?></td>
                            <td><?php echo $item->order->getDeliveryAddress(); ?> </td>
                            <td><?php echo e($item->created_at); ?></td>
                            <td><?php echo e($item->status); ?></td>
                            <td><?php echo e($item->comments); ?></td>
                            <td>
                                
                                <a href="<?php echo e(url('/logistics/trips/orders/details/' . $item->id)); ?>" title="Manage Trip Order Details"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;margin: 10px 0px 0px 0px;width: 84px;">Manage</button></a>

                                <form method="POST" action="<?php echo e(url('/logistics/trips/orders/remove-from-trip/'. $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                    <?php echo e(csrf_field()); ?>

                                    <button type="submit" style="margin-top: 10px;" class="btn btn-danger btn-sm" title="Remove Order from Trip" onclick="return confirm(&quot;Are you sure you want to remove this order from the trip?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              
                            
                            </tbody>
                           </table>  

                        </div>
                    </div>
                </div>
               
               
               
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <div class="page-footer">
        <div class="container">
            <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA</p>
        </div>
    </div>
         

   <?php $__env->stopSection(); ?>
<?php echo $__env->make('logistics::layouts.logistics_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>