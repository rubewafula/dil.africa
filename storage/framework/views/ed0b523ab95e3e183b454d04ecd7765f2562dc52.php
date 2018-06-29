<div class="sidebar-widget-body outer-top-xs">
    <div class="owl-carousel best-seller custom-carousel owl-theme outer-top-xs">

        <?php ($best_seller_brand = new \Modules\Customer\Entities\Best_seller_brand()); ?>
        <?php ($brands = $best_seller_brand->getBestSellerBrands()); ?>
        <?php ($size = count($brands)); ?>
        <?php ($count = 0); ?>

        <?php while($count < $size): ?>
        <div class="item">
            <div class="products best-product">
                <div class="product">
                    <div class="product-micro">
                        <div class="col col-xs-6">
                            <?php ($brand = $brands[$count]); ?>
                            <div class="product-image">
                                <div class="image">
                                    <a href="#">
                                        <img src="assets/images/brands/<?php echo e($brand->brand->logo); ?>" alt="">
                                    </a>					
                                </div><!-- /.image -->
                            </div><!-- /.product-image -->
                        </div><!-- /.col -->
                        <?php ($count++); ?>
                        <?php if($count == $size): ?>
                    </div><!-- /.product-micro --></div>
            </div></div>
        <?php break; ?>
        <?php endif; ?>
        <div class="col col-xs-6">
            <?php ($brand = $brands[$count]); ?>
            <div class="product-image">
                <div class="image">
                    <a href="#">
                        <img src="assets/images/brands/<?php echo e($brand->brand->logo); ?>" alt="">
                    </a>					
                </div><!-- /.image -->
            </div><!-- /.product-image -->
        </div><!-- /.col -->	<!-- /.product-micro-row -->
        <?php ($count++); ?>
        <?php if($count == $size): ?>
    </div><!-- /.product-micro --></div></div></div>
<?php break; ?>
<?php endif; ?>
</div><!-- /.product-micro -->

</div>
<div class="product">
    <div class="product-micro">
        <div class="col col-xs-6">
            <?php ($brand = $brands[$count]); ?>
            <div class="product-image">
                <div class="image">
                    <a href="#">
                        <img src="assets/images/brands/<?php echo e($brand->brand->logo); ?>" alt="">
                    </a>					
                </div><!-- /.image -->
            </div><!-- /.product-image -->
        </div><!-- /.col -->
        <?php ($count++); ?>
        <?php if($count == $size): ?>
    </div><!-- /.product-micro --></div></div></div>
<?php break; ?>
<?php endif; ?>
<div class="col col-xs-6">
    <?php ($brand = $brands[$count]); ?>
    <div class="product-image">
        <div class="image">
            <a href="#">
                <img src="assets/images/brands/<?php echo e($brand->brand->logo); ?>" alt="">
            </a>					
        </div><!-- /.image -->
    </div><!-- /.product-image -->
</div><!-- /.col -->	<!-- /.product-micro-row -->
<?php ($count++); ?>
</div><!-- /.product-micro -->
</div>
</div>
</div>
<?php endwhile; ?>

</div>
</div><!-- /.sidebar-widget-body -->