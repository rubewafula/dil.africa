<?php $__env->startSection('content'); ?>
<script src="<?php echo e(url('assets/js/jquery-1.11.1.min.js')); ?>"></script>
<script type="text/javascript">
    
    $(document).ready(function(){

      $("#publish_button").removeAttr('disabled');

     $("#brands").keyup(function(){

        var  brand = $(this).val();

        $.ajax({
        url:"<?php echo e(url('qc/load_brands')); ?>",
        type:"GET",
        data:{brand:brand},
        success:function(output){
 
        console.log(output);

        },
        error:function (){
          return "ERROR";
        }
      });
      //alert("brand");

     });

    });
</script>
           <div class="page-breadcrumb" >
                    <?php echo e(Breadcrumbs::render()); ?>


                </div>
                <div class="page-title">
                    <div class="container" style="padding-top: 10px;">
                      <div class="col-md-5">
                        <h3 style="padding-bottom: 5px;">  
                          Update:  <?php echo e($product->name); ?>, Product  Code: <?php echo e($product->product_code); ?>

                        </h3>
                      </div>

                      <div class="col-md-3">
                        
                        <span style="font-size: 16px;">
                           STATUS: <span class="blue-color"><?php echo e($product->status); ?></span>
                          </span>
                      </div>
                      <div class="col-md-2">
                        
                        <span class="pull-right">
                           <form  method="POST"  action="<?php echo e(url('qc/publish_product')); ?>">
                              <?php echo e(csrf_field()); ?>

                              <input type="hidden"  name="product_id" value="<?php echo e($product->id); ?>">

                              <div  class="form-group" style="margin-bottom: 10px;">
                                
                              <?php if($product->publish_status ==  1): ?>

                              <a  href="<?php echo e(url('qc/unpublish/'.$product->id)); ?>"  class="btn  btn-danger"> Unpublish</a>

                              <?php else: ?>

                              <!-- <button class="btn btn-warning btn-lg" id="publish_button"> Publish </button> -->

                              <input type="submit" class="btn btn-warning orange-button" value="Publish"/>

                              <?php endif; ?>
                            </div>
                          </form>
                          </span>
                      </div>
                      <div class="col-md-2">

                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject<?php echo e($product->id); ?>">Reject</button>

                          <div id="reject<?php echo e($product->id); ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Quality Review Failed </h4>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="<?php echo e(url('qc/quality_failed')); ?>">
                                  <?php echo e(csrf_field()); ?>

                                  <input type="hidden" name="seller_order_id"  value="<?php echo e($product->id); ?>">
                                  <input type="hidden" name="order_status"  value="QUALITY_FAILED">

                                  <div  class="form-group">
                                    <label> Comments </label>
                                    <textarea name="quality_comments"  class="form-control" 
                                    ></textarea>

                                  </div>

                                  <div  class="form-group pull-right">
                                    <input type="submit" class="btn  btn-danger"  value="Save">

                                  </div>

                                </form>
                              </div>
                              <div class="modal-footer">
                        <!--         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         -->      </div>
                            </div>

                          </div>
                      </div>
                    </div>
                </div>
                <div class="container" >
                  <div class="panel panel-white">

                	<div  class="row">
                     
                    <div class="col-md-12">
                      <div class="panel-heading clearfix">
                        <div class="row"> 

                          <div class="col-md-6">
                              <h3 class="panel-title"> Products
                              </h3>
                          </div>
                          <div class="col-md-6">
                             
                          </div>

                        </div>

                    </div>

                      </div>

                     <?php echo $__env->make('qc::products.product_form',compact('product'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  </div> 
                </div>

            </div>

          </div>
      </div>

  <?php $__env->stopSection(); ?>              
<?php echo $__env->make('qc::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>