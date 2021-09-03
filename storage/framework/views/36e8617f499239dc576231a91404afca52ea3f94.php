<?php $__env->startSection('content'); ?>
                <div class="page-breadcrumb" >
                   <?php echo e(Breadcrumbs::render()); ?>


                </div>


                <div class="page-title">
                    <div class="container">
                        <h3>Brands</h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
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
                        <form method="GET" action="<?php echo e(url('/backend/brands')); ?>" accept-charset="UTF-8" class="form-inline " role="search">
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
                                                     <span  class="pull-right"> <a href="<?php echo e(url('backend/brands/create')); ?>" class="btn btn-success btn-sm" title="Add New ">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>                                

                                                                                </div>

                                    </div>
                                    <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                            <tr>
                                               <tr>
                                        <th>#</th><th>Cover Photo</th><th>Name</th><th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                        <tfoot style="background: #000;color:#fff;opacity: 0.7">
                                            <tr>
                                                      <th>#</th><th>Cover Photo</th><th>Name</th><th>Actions</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(isset($loop->iteration) ? $loop->iteration : $item->id); ?></td>
                                         <td>

                                            <img src="<?php echo e(asset($item->cover_photo)); ?>" width="80px" />
                                            </td>

                                        <td><?php echo e($item->name); ?></td>
                                        <td>
                                            <a class="btn btn-success" data-toggle="modal" data-target="#modal_<?php echo e($item->id); ?>">
                                                 Categories </a>
                                         <div class="modal fade" id="modal_<?php echo e($item->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"> Add Category to the Selected Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div  class="row">
          <form  class="form-horizontal" method="POST" action="<?php echo e(url('backend/add_category_brand')); ?>">
            <?php echo e(csrf_field()); ?>

            <input  type="hidden" name="brand_id" value="<?php echo e($item->id); ?>">
            <?php $categories = App\Category::where('level', 3)->pluck('name', 'id')->prepend('Select Category', ''); ?>

            <?php echo e(Form::select('category_id', $categories, null, ['class'=>'form-control'])); ?>


            <input type="submit" value="Add" style="margin-top: 10px;" class="btn btn-warning" >

          </form>
        </div>

        <div  class="row">
          
          <div  class="table">
            <table class="table">
              <thead>
                <tr>
                  <th>
                    Brand Categories
                  </th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>
                <?php ( $brand_categories = App\Category_brand::where('brand_id', $item->id)->get()); ?>
                <?php $__currentLoopData = $brand_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td> <?php echo e($category->category->name); ?> </td>
                  <td> 
                    <a href="<?php echo e(url('backend/remove_brand_category/'.$category->id)); ?>" onclick="return  confirm('Are  you sure?')" class="btn btn-danger"> Delete</a></td>
                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>

            </table>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
                                            <a href="<?php echo e(url('/backend/brands/' . $item->id . '/edit')); ?>" title="Edit Brand"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="<?php echo e(url('/backend/brands' . '/' . $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                                <?php echo e(method_field('DELETE')); ?>

                                                <?php echo e(csrf_field()); ?>

                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Brand" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          
                                        
                                        </tbody>
                                       </table>  
                                                                   <div class="pagination-wrapper"> <?php echo $brands->appends(['search' => Request::get('search')])->render(); ?> </div>

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