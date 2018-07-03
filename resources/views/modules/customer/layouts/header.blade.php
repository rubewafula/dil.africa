<script>

$(document).ready(function(){
    
    $("#pickup_station_div").hide();
    $("#home_delivery_div").hide();
        
    var BASE_URL = "{{url('/shop/')}}";
    
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
                        <li><a href="{{url('/shop/my-account')}}"><i class="icon fa fa-user"></i>My Account</a></li>
                        <li><a href="{{url('shop/wishlist')}}"><i class="icon fa fa-heart"></i>My Wishlist</a></li>
                        <li><a href="{{url('/shop/cart')}}"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
                        <li><a href="{{url('/shop/checkout')}}"><i class="icon fa fa-check"></i>Checkout</a></li>
                        <li><a  href="{{url('shop/history')}}">My History</a></li>
                        @if(Auth::user() == null)
                        <li><a href="{{url('/shop/sign-in')}}"><i class="icon fa fa-lock"></i>Login</a></li>
                        @endif
                        @if(Auth::check())
                        <li class="dropdown  navbar-right special-menu">
                            <a href="{{url('/shop/logout')}}">
                                <span style="color: #fff;background: #F89530;padding: 3px 5px;border-radius: 3px;">Logout</span>
                            </a>
                        </li>
                        @if(Auth::user()->active == 0)
                        <li class="dropdown  navbar-right special-menu">
                            <a href="">
                                <span style="color: #fff;background: #CC0000;padding: 3px 5px;border-radius: 3px;">Verify Account</span>
                            </a>
                        </li>
                        @endif
                        @endif
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
                        <a href="{{url('/')}}">

                            <img src="{{url('assets/images/logo.png')}}" alt="">

                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->				</div><!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form method="POST" action="{{url('shop/search')}}">
                            <div class="control-group">

                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown">

                                        <a class="dropdown-toggle"  data-toggle="dropdown" href="{{url('shop/category')}}">Categories <b class="caret"></b></a>

                                        @php( $allcategories = \Modules\Customer\Entities\Category::where('status', 1)->where('level', 1)->get() )                                       
                                        <ul class="dropdown-menu" role="menu" >
                                            @foreach($allcategories as $category)
                                            <li class="menu-header">{{$category->name}}</li>
                                            @php($sub_categories = $category->getSubCategories())
                                            @foreach($sub_categories as $sub_cat)
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="{{url('/shop/category/'.$sub_cat->id)}}">- {{$sub_cat->name}}</a>
                                            </li>
                                            @endforeach
                                            @endforeach
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
                        <a href="{{url('shop/cart')}}" class="dropdown-toggle lnk-cart" style="width: 100%;">
                            <div class="items-cart-inner" style="margin: 0px auto;">
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>

                                @php($total_price = \Modules\Customer\Utilities\Utilities::getCustomerTotalCartPrice())
                                @php($quantity = \Modules\Customer\Utilities\Utilities::getCustomerTotalCartItems())
                                
                                @php($cart = Session::get('cart'))
                                @if($cart != null)
                                @if(count($cart) > 0)
                                <div class="basket-item-count"><span class="count">{{$quantity}}</span></div>
                                <div class="total-price-basket">
                                    <span class="lbl">Total in cart -</span>
                                    <span class="total-price">
                                        <span class="sign">KSh. </span>
                                        <span class="value">{{$total_price}}</span>
                                    </span>
                                </div>
                                @else 
                                <div class="basket-item-count"><span class="count">0</span></div>
                                <div class="total-price-basket">
                                    <span class="lbl">cart -</span>
                                    <span class="total-price">
                                        <span class="sign">KSh </span><span class="value">0.00</span>
                                    </span>
                                </div>                            
                                @endif
                                @else 
                                <div style="padding-top: 10px;padding-left: 50px;font-size: 14px;">
                                    Your Cart is Empty
                                </div>                            
                                @endif

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
                                    <a href="{{url('/shop')}}">Home</a>
                                </li>
                                @php( $categories = \Modules\Customer\Entities\Category::where('status', 1)->where('level', 1)->limit(7)->get() )
                                @foreach($categories as $category)
                                <li class="dropdown yamm mega-menu">
                                    <a href="{{url('shop/')}}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ strtoupper($category->name)}}</a>
                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">

                                                    @php($subCategories = \Modules\Customer\Entities
                                                    \Category::where('depends_on', $category->id)
                                                    ->where('status', 1)->get())

                                                    @foreach($subCategories as $subCategory)
                                                    <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                        <h2 class="title">
                                                            <a href="{{url('/shop/category/'.$subCategory->id)}}" style="padding:0px;">
                                                                {{$subCategory->name}}
                                                            </a>
                                                        </h2>                                                                                 
                                                        <ul class="links">
                                                            
                                                            @php($miniCategories = \Modules\Customer\Entities
                                                                \Category::where('depends_on', $subCategory->id)
                                                                ->where('status', 1)->get())
                                                            
                                                            @foreach($miniCategories as $miniCategory)
                                                            <li><a href="{{url('shop/category/'.$miniCategory->id)}}">{{$miniCategory->name}}</a></li>
                                                            @endforeach

                                                        </ul>
                                                    </div><!-- /.col -->
                                                    @endforeach

                                                    <div class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                                        <img class="img-responsive" src="{{url('assets/images/banners/categories/'.$category->cover_photo)}}" alt="">

                                                    </div>				
                                                </div>
                                            </div> <!-- /.yamm-content -->	
                                        </li>
                                    </ul>

                                </li>
                                @endforeach
                                
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