  

  <?php $__env->startSection('content'); ?>
                  <div class="page-breadcrumb" >
                     <?php echo e(Breadcrumbs::render()); ?>


                  </div>

                  <div class="page-title">
                      <div class="container" class="blue-text" style="padding: 10px;font-size: 18px;">
                          Riders
                      </div>
                  </div>
                  <div class="container">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="panel panel-white">
                                  <div class="panel-heading clearfix">
                                       <h4 class="panel-title"></h4> 
                                  </div>
                                  <div class="panel-body">

                                      
                                     <div class="table-responsive">

                                       <div  class="row">
                                          <div  class="col-md-8 col-sm-12">
                          <form method="GET" action="<?php echo e(url('/logistics/riders')); ?>" accept-charset="UTF-8" class="form-inline " role="search">
                              <form class="form-inline">
                                  <div class="input-group">
                                  <div class="form-group mx-sm-12 mb-12">
                                    <input type="text" class="form-control"  name="search" value="<?php echo e(request('search')); ?>" placeholder="Search">
                                  </div>
                                                                  <span class="input-group-append">

                                    <button class="btn btn-secondary" type="submit">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                </form>
                           
                              </div>

                              <div  class="col-md-4 col-sm-12">
                              <span  class="pull-right"> 
                                <a href="<?php echo e(url('/logistics/riders/create')); ?>" class="btn btn-success btn-sm" title="Add New ">
                              <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a> </span>                                

                                    </div>

                                      </div>
                                      <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                          <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                              <tr>
                                                 <tr>
                                          <th>Name</th>  
                                          <th>Phone Number</th> 
                                          <th>Email Address</th>
                                          <th>Gender</th> 
                                          <th>ID Number</th> 
                                          <th>Vehicle Reg. No.</th> 
                                          <th>Status</th>
                                          <th>Actions</th>
                                      </tr>
                                              </tr>
                                          </thead>
                                          <tbody>
                                        <?php $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                          <td><?php echo e($item->name); ?></td>
                                          <td><?php echo e($item->phone); ?></td>
                                          <td><?php echo e($item->email); ?></td>
                                          <td><?php echo e($item->gender); ?></td>
                                          <td><?php echo e($item->id_number); ?></td>
                                          <td><?php echo e(($item->vehicle != null)?$item->vehicle->registration_no:""); ?></td>
                                          <td><?php echo e(($item->active == 1)?"Active":"Inactive"); ?></td>
                                          <td>
                                              
                                              <a href="<?php echo e(url('/logistics/riders/' . $item->id . '/edit')); ?>" title="Edit Rider"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                              <form method="POST" action="<?php echo e(url('/logistics/riders/'. $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                                  <?php echo e(method_field('DELETE')); ?>

                                                  <?php echo e(csrf_field()); ?>

                                                  <button type="submit" class="btn btn-danger btn-sm" title="Delete Rider" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                              </form>
                                          </td>
                                      </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                          
                                          </tbody>
                                         </table>  
                      <div class="pagination-wrapper"> <?php echo $riders->appends(['search' => Request::get('search')])->render(); ?> </div>

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