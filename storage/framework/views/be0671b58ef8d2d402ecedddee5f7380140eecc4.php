<?php $__env->startSection('content'); ?>
                <div class="page-breadcrumb" >
                   <?php echo e(Breadcrumbs::render()); ?>


                </div>


                <div class="page-title">
                    <div class="container">
                        <h3>Manage  Customers</h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">

                  <div  class="top-area ">
                    <div  class="row">

                   <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                         <?php   $cust_count=  App\User::where(['is_customer'=>1,'active'=>1])->count(); ?>
                                        <p class="counter"><?php echo e(number_format($cust_count)); ?></p>
                                   
                                        <span class="info-box-title">customers</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-users"></i>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

                             <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> 30 Years</p>
                                        <span class="info-box-title">Average age </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

                             <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> 3</p>
                                        <span class="info-box-title">Orders per  customer </span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-year"></i>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

                          <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p class="counter"> 3</p>
                                        <span class="info-box-title">New  Customers </span>
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
                                <div class="panel-heading clearfix">
                                     <h4 class="panel-title"></h4> 
                                </div>
                                <div class="panel-body">

                                    
                                   <div class="table-responsive">

                                     <div  class="row">
                                        <div  class="col-md-8 col-sm-12">
                        <form method="GET" action="<?php echo e(url('/backend/users')); ?>" accept-charset="UTF-8" class="form-inline " role="search">
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
                                                     <span  class="pull-right"> <a href="<?php echo e(url('/backend/users/create')); ?>" class="btn btn-success btn-sm" title="Add New ">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>                                

                                                                                </div>

                                    </div>
                                    <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead >
                                            <tr style="background: #ffa200;color:#fff;opacity: 0.7">
                                               <tr>
                                        <th style="width: 5%">ID</th>
                                        <th>First Name</th>
                                       <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>

                                        <th>Actions</th>
                                    </tr>
                                            </tr>

                                            <form method="GET" action="<?php echo e(url('backend/customers')); ?>" >
                                              <input type="hidden" name="search"  value="1">
                                              <tr>
                                                <td>
                                                  <input type="text" name="id" >
                                                </td>
                                                    <td>
                                                  <input type="text" name="first_name" >
                                                </td>
                                                    <td>
                                         <input type="text" name="last_name">

                                                </td>
                                                   <td>
                                         <input type="text" name="email">

                                                </td>
                                                <td>
                                                  <select  name="active">
                                                    
                                              <option  value="1">Active</option>
                                              <option  value="0">Inactive</option>

                                                  </select>

                                                </td>
                                                <td>
                                                  
                                                  <input type="submit" class="btn-success"  value="Filter">
                                                </td>

                                              </tr>
                                              


                                            </form>
                                        </thead>
                                <!--         <tfoot style="background: #000;color:#fff;opacity: 0.7">
                                            <tr>
                                                      <th>#</th>
                                                      <th>Name</th>

                                                      <th>Email</th>
                                                      <th>Status</th>
                                                      <th>Actions</th>

                                            </tr>
                                        </tfoot> -->
                                        <tbody>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td ><?php echo e($item->id); ?></td>
                                        <td> <?php echo e($item->first_name); ?></td>
                                       <td> <?php echo e($item->last_name); ?></td>
                                        <td><?php echo e($item->email); ?></td>
                                        <td><?php echo e($item->status); ?></td>

                                        <td>
                                         <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                View <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?php echo e(url('backend/customer/'.$item->id)); ?>">Edit</a></li>
                                                <li><a href="#">Delete</a></li>
                                              
                                            </ul>
                                        </div>
                                     
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          
                                        
                                        </tbody>
                                       </table>  
                                                                   <div class="pagination-wrapper"> <?php echo $customers->appends(['search' => Request::get('search')])->render(); ?> </div>

                                    </div>
                                </div>
                            </div>
                           
                           
                           
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <div class="page-footer">
                    <div class="container">
                        <p class="no-s"><?php echo date('Y') ?>&copy; </p>
                    </div>
                </div>
       

 <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>