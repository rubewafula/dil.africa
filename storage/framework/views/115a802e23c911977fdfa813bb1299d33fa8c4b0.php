<?php $__env->startSection('content'); ?>
<script src="<?php echo e(url('assets/js/jquery-1.11.1.min.js')); ?>"></script>
<script type="text/javascript">
    
    $(document).ready(function(){

      $("#publish_button").removeAttr('disabled');

     $("#brands").keyup(function(){

        var  brand = $(this).val();

        $.ajax({
        url:"<?php echo e(url('seller/load_brands')); ?>",
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
                      <div class="col-md-6">
                        <h3 style="padding-bottom: 5px;">  
                          Update:  <?php echo e($product->name); ?>, Product  Code: <?php echo e($product->product_code); ?>

                        </h3>
                      </div>

                      <div class="col-md-3">
                        
                        <span style="font-size: 16px;">
                           STATUS: <span class="blue-color"><?php echo e($product->status); ?></span>
                          </span>
                      </div>
                      <div class="col-md-3">
                        
                        <span class="pull-right">
                           <form  method="POST"  action="<?php echo e(url('seller/publish_product')); ?>">
                            <?php echo e(csrf_field()); ?>

                        <input type="hidden"  name="product_id" value="<?php echo e($product->id); ?>">

                        <div  class="form-group" style="margin-bottom: 0px;">
                          
                        <?php if($product->publish_status ==  1): ?>

                        <a  href="<?php echo e(url('seller/unpublish/'.$product->id)); ?>"  class="btn  btn-danger"> Unpublish</a>

                        <?php else: ?>

                        <!-- <button class="btn btn-warning btn-lg" id="publish_button"> Publish </button> -->

                        <input type="submit" class="btn btn-warning orange-button" value="Publish"/>


                        <?php endif; ?>
                      </div>
                    </form>

                          </span>
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

                                   <?php echo $__env->make('seller::products.product_form',compact('product'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div> 
                              </div>

                    </div>

</div>
                </div>

  <?php $__env->stopSection(); ?>              
<?php echo $__env->make('seller::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>