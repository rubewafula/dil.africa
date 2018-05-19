<div class="more-info-tab clearfix ">
    <h3 class="new-product-title pull-left">Recomended For You</h3>
    <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
        <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">Most Popular</a></li>
        <li><a data-transition-type="backSlide" href="#smartphone" data-toggle="tab">Best Of Phones</a></li>
        <li><a data-transition-type="backSlide" href="#laptop" data-toggle="tab">Top in Fashion</a></li>
        <li><a data-transition-type="backSlide" href="#topinfashion" data-toggle="tab">Top in Books</a></li>
    </ul><!-- /.nav-tabs -->
</div>

<div class="tab-content outer-top-xs">
    <div class="tab-pane in active" id="all">			
        <?php echo $__env->make('customer::home.recommended.popular', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="smartphone">
        <?php echo $__env->make('customer::home.recommended.phones', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="laptop">
        <?php echo $__env->make('customer::home.recommended.fashion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="topinfashion">
        <?php echo $__env->make('customer::home.recommended.books', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div><!-- /.tab-pane -->

</div><!-- /.tab-content -->