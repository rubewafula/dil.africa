<?php $__env->startSection('content'); ?>

<script>
  fbq('track', 'Search');
</script>


<script>

$(document).ready(function(){
    
    $("#options_list").click(function(){
        
        var selected = $("#options_list").val();
        
    });
    
    // $("#search_resultstable").dataTable();

    /*===================================================================================*/
    /* PRICE SLIDER
    /*===================================================================================*/

    
    var start = <?php echo e($minimum_price); ?>;
    var end = <?php echo e($maximum_price); ?>;

    var active_start = <?php echo e(isset($active_minprice)?$active_minprice:0); ?>

    var active_end = <?php echo e(isset($active_maxprice)?$active_maxprice:0); ?>


    if(active_start == 0){

        active_start = start;
    }

    if(active_end == 0){

        active_end = end;
    }

    // Price Slider

    if ($('.price-slider').length > 0) {
        $('.price-slider').slider({
            min: start,
            max: end,
            step: 10,
            value: [active_start, active_end],
            handle: "square"
        });

    }

    $('#show_now').click(function() {

        var range = $('#price-slider-id').val();

        <?php if(isset($category)): ?>
        var slug = "<?php echo e($category->slug); ?>";
        <?php else: ?>
        var slug = "custom-search";
        <?php endif; ?>

        var from = range.split(",")[0];
        var to = range.split(",")[1];

        var BASE_URL = "<?php echo e(url('/shop/')); ?>";

        window.location.replace(BASE_URL+"/category/"+slug+"/"+from+"/"+to);

    });
   
});

</script>

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row'>
            <div class='col-md-3 sidebar hidden-sm hidden-xs'>
                <?php echo $__env->make('customer::category.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            
            <div class='col-md-9'>
                <!-- ========================================== SECTION – HERO ========================================= -->

                <div id="category" class="category-carousel hidden-xs">

                </div>

                <?php if(count($products) > 0): ?>

                <!-- ========================================= SECTION – HERO : END ========================================= -->
                <div class="clearfix filters-container hidden-xs hidden-sm">
                    <div class="row">

                        <div class="col col-sm-6 col-md-2">
                            <div class="filter-tabs">
                                <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                    <li class="active">
                                        <a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th-large"></i>Grid</a>
                                    </li>
                                    <li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i>List</a></li>
                                </ul>
                            </div><!-- /.filter-tabs -->
                        </div><!-- /.col -->
                            <div class="col col-sm-6 col-md-6 no-padding">
                                <div class="lbl-cnt">
                                    <span class="lbl">Sort byy</span>
                                    <div class="fld inline">
                                        <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                            <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                <?php echo e(isset($search_mode)?$search_mode:"Default"); ?> <span class="caret"></span>
                                            </button>

                                            <ul role="menu" class="dropdown-menu" id="options_list">
                                                <?php if(isset($category)): ?>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/lowest/'.$category->slug)); ?>">Price:Lowest first</a></li>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/highest/'.$category->slug)); ?>">Price:Highest first</a></li>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/name/'.$category->slug)); ?>">Product Name:A to Z</a></li>
                                                <?php else: ?>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/lowest/custom-search')); ?>">Price:Lowest first</a></li>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/highest/custom-search')); ?>">Price:Highest first</a></li>
                                                <li role="presentation"><a href="<?php echo e(url('shop/search/name/custom-search')); ?>">Product Name:A to Z</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div><!-- /.fld -->
                                </div><!-- /.lbl-cnt -->
                            </div><!-- /.col -->

                            <div class="col col-sm-6 col-md-4  text-right">
                                
                                <!-- Pagination Here -->

                                                       
                            </div>
                        
                    </div><!-- /.row -->
                </div>

                <?php endif; ?>

                <div class="search-result-container ">
                    <div id="myTabContent" class="tab-content category-list" style="padding: 0px 20px;">
                        <div class="tab-pane active" id="grid-container">
                            <div class="category-product hidden-sm hidden-xs">									

                                <?php echo $__env->make('customer::category.single_grid_product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                
                            </div><!-- /.category-product -->
                            <div class="category-product hidden-md hidden-lg">                                  

                                <?php echo $__env->make('customer::category.single_grid_product_xs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                
                            </div><!-- /.category-product -->

                        </div><!-- /.tab-pane -->

                        <div class="tab-pane hidden-xs hidden-sm"  id="list-container">
                            <div class="category-product">
                                <?php echo $__env->make('customer::category.single_list_product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div><!-- /.category-product -->
                        </div><!-- /.tab-pane #list-container -->
                    </div><!-- /.tab-content -->
                    
                    <!-- Pagination Here -->

                </div><!-- /.search-result-container -->

            </div><!-- /.col -->

            <div class='col-md-3 sidebar hidden-md hidden-lg'>
                <?php echo $__env->make('customer::category.sidebar_xs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->

    </div><!-- /.body-content -->
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.category_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>