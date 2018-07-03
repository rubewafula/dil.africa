<script>

$(document).ready(function(){
    
    $("#pickup_station_div").hide();
    $("#home_delivery_div").hide();
        
    var BASE_URL = "<?php echo e(url('/shop/')); ?>";
    
    $(".country-select").change(function(){
        
        var country_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('country', country_id);
        $.ajax({
            url: BASE_URL + "cities",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {
                    
                    $(".city-select").html(output.html);                              
                }
            }
        });
        
    });
    
    
    $(".city-select").change(function(){
        
        var city_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('city', city_id);
        $.ajax({
            url: BASE_URL + "zones",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {
                    
                    $(".zone-select").html(output.html);                              
                }
            }
        });
        
    });
    
    
    $(".zone-select").change(function(){
        
        var zone_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('zone', zone_id);
        $.ajax({
            url: BASE_URL + "areas",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {

                    $(".area-select").html(output.html);                              
                }
            }
        });
        
    });
});

</script>

<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled" style="text-transform:uppercase; font-size:11px">
                        <li><a href="<?php echo e(url('/shop/my-account')); ?>"><i class="icon fa fa-user"></i>My Account</a></li>
                        <li><a href="<?php echo e(url('shop/wishlist')); ?>"><i class="icon fa fa-heart"></i>My Wishlist</a></li>
                        <li><a href="<?php echo e(url('/shop/cart')); ?>"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
                        <li><a href="<?php echo e(url('/shop/checkout')); ?>"><i class="icon fa fa-check"></i>Checkout</a></li>
                        <li><a  href="<?php echo e(url('shop/history')); ?>">My History</a></li>
                        <?php if(Auth::user() == null): ?>
                        <li><a href="<?php echo e(url('/shop/sign-in')); ?>"><i class="icon fa fa-lock"></i>Login</a></li>
                        <?php endif; ?>
                        <?php if(Auth::check()): ?>
                        <li class="dropdown  navbar-right special-menu">
                            <a href="<?php echo e(url('/shop/logout')); ?>">
                                <span style="color: #fff;background: #F89530;padding: 3px 5px;border-radius: 3px;">Logout</span>
                            </a>
                        </li>
                        <?php if(Auth::user()->active == 0): ?>
                        <li class="dropdown  navbar-right special-menu">
                            <a href="">
                                <span style="color: #fff;background: #CC0000;padding: 3px 5px;border-radius: 3px;">Verify Account</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.cnt-account -->

                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div><!-- /.header-top-inner -->
        </div><!-- /.container -->
    </div><!-- /.header-top -->
    <!-- ============================================== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <a href="<?php echo e(url('/')); ?>">

                            <img src="<?php echo e(url('assets/images/logo.png')); ?>" alt="">

                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->				</div><!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form method="POST" action="<?php echo e(url('shop/search')); ?>">
                            <div class="control-group">

                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown">

                                        <a class="dropdown-toggle"  data-toggle="dropdown" href="<?php echo e(url('shop/category')); ?>">Categories <b class="caret"></b></a>

                                        <?php ( $allcategories = \Modules\Customer\Entities\Category::where('status', 1)->where('level', 1)->get() ); ?>                                       
                                        <ul class="dropdown-menu" role="menu" >
                                            <?php $__currentLoopData = $allcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="menu-header"><?php echo e($category->name); ?></li>
                                            <?php ($sub_categories = $category->getSubCategories()); ?>
                                            <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="<?php echo e(url('/shop/category/'.$sub_cat->id)); ?>">- <?php echo e($sub_cat->name); ?></a>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>                                       
                                    </li>
                                </ul>
                                <input class="search-field" name="pattern" style="width: 62%;" placeholder="Search for products in different Brands & Categories..." />
                                <input class="search-button-custom" type="submit" value="SEARCH"/>    
                            </div>
                        </form>
                    </div><!-- /.search-area -->
                    <!-- ============================================================= SEARCH AREA : END ============================================================= -->				</div><!-- /.top-search-holder -->

                <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

                    <div class="dropdown dropdown-cart" style="width: 100%;">
<!--                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">-->
                        <a href="<?php echo e(url('shop/cart')); ?>" class="dropdown-toggle lnk-cart" style="width: 100%;">
                            <div class="items-cart-inner" style="margin: 0px auto;">
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>

                                <?php ($total_price = \Modules\Customer\Utilities\Utilities::getCustomerTotalCartPrice()); ?>
                                <?php ($quantity = \Modules\Customer\Utilities\Utilities::getCustomerTotalCartItems()); ?>
                                
                                <?php ($cart = Session::get('cart')); ?>
                                <?php if($cart != null): ?>
                                <?php if(count($cart) > 0): ?>
                                <div class="basket-item-count"><span class="count"><?php echo e($quantity); ?></span></div>
                                <div class="total-price-basket">
                                    <span class="lbl">Total in cart -</span>
                                    <span class="total-price">
                                        <span class="sign">KSh. </span>
                                        <span class="value"><?php echo e($total_price); ?></span>
                                    </span>
                                </div>
                                <?php else: ?> 
                                <div class="basket-item-count"><span class="count">0</span></div>
                                <div class="total-price-basket">
                                    <span class="lbl">cart -</span>
                                    <span class="total-price">
                                        <span class="sign">KSh </span><span class="value">0.00</span>
                                    </span>
                                </div>                            
                                <?php endif; ?>
                                <?php else: ?> 
                                <div style="padding-top: 10px;padding-left: 50px;font-size: 14px;">
                                    Your Cart is Empty
                                </div>                            
                                <?php endif; ?>

                            </div>
                        </a>
                        
                    </div><!-- /.dropdown-cart -->

                    <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->				</div><!-- /.top-cart-row -->
            </div><!-- /.row -->

        </div><!-- /.container -->

    </div><!-- /.main-header -->

    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li class="active dropdown yamm-fw">
                                    <a href="<?php echo e(url('/shop')); ?>">Home</a>
                                </li>
                                <?php ( $categories = \Modules\Customer\Entities\Category::where('status', 1)->where('level', 1)->limit(7)->get() ); ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="dropdown yamm mega-menu">
                                    <a href="<?php echo e(url('shop/')); ?>" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown"><?php echo e(strtoupper($category->name)); ?></a>
                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">

                                                    <?php ($subCategories = \Modules\Customer\Entities
                                                    \Category::where('depends_on', $category->id)
                                                    ->where('status', 1)->get()); ?>

                                                    <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                        <h2 class="title">
                                                            <a href="<?php echo e(url('/shop/category/'.$subCategory->id)); ?>" style="padding:0px;">
                                                                <?php echo e($subCategory->name); ?>

                                                            </a>
                                                        </h2>                                                                                 
                                                        <ul class="links">
                                                            
                                                            <?php ($miniCategories = \Modules\Customer\Entities
                                                                \Category::where('depends_on', $subCategory->id)
                                                                ->where('status', 1)->get()); ?>
                                                            
                                                            <?php $__currentLoopData = $miniCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miniCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><a href="<?php echo e(url('shop/category/'.$miniCategory->id)); ?>"><?php echo e($miniCategory->name); ?></a></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </ul>
                                                    </div><!-- /.col -->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                                        <img class="img-responsive" src="<?php echo e(url('assets/images/banners/categories/'.$category->cover_photo)); ?>" alt="">

                                                    </div>				
                                                </div>
                                            </div> <!-- /.yamm-content -->	
                                        </li>
                                    </ul>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
<!--                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">Other Pages</a>
                                    <ul class="dropdown-menu pages">
                                        <li>
                                            <div class="yamm-content">
                                                <div class="row">

                                                    <div class="col-xs-12 col-menu">
                                                        <ul class="links">
                                                            <li><a href="home.html">Home</a></li>
                                                            <li><a href="category.html">Product Category</a></li>								
                                                            <li><a href="checkout.html">Checkout</a></li>
                                                            <li><a href="contact.html">Contact</a></li>
                                                            <li><a href="sign-in.html">Sign In</a></li>
                                                            <li><a href="terms-conditions.html">Terms and Condition</a></li>
                                                            <li><a href="404.html">404</a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </li>-->
                                
<!--                                <li class="dropdown  navbar-right special-menu">
                                    <a href="#">
                                        <span style="font-weight: bold;">Todays offer</span>
                                    </a>
                                </li>-->
                                


                            </ul><!-- /.navbar-nav -->
                            <div class="clearfix"></div>				
                        </div><!-- /.nav-outer -->
                    </div><!-- /.navbar-collapse -->


                </div><!-- /.nav-bg-class -->
            </div><!-- /.navbar-default -->
        </div><!-- /.container-class -->

    </div><!-- /.header-nav -->
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>