<script>

$(document).ready(function(){


    $('.product .product-image img').css({

        
        left: ($(window).width() - $('.product .product-image img').outerWidth())/2,
        top: ($(window).height() - $('.product .product-image img').outerHeight())/2
    });


    // To initially run the function:
    $(window).resize();
    
    $("#pickup_station_div").hide();
    
    @php(Session::put('user_address_id', ""))
    @php(Session::put('delivery_type', 'home_office_delivery'))
    @php($userId = Session::get('userId'))
    @if($userId != null)
    @php($user_address = \Modules\Customer\Entities\User_address::where('user_id',$userId)
                    ->where('default', 1)->first())
    @if($user_address != null)
    @php(Session::put('user_address_id', $user_address->id))
    @endif
    @endif
    
    $("#selection_message").html("'Home / Office Delivery' is selected by default.\n\
             You can change this if you wish to pick up your goods from one of \n\
                our pickup stations.");
        
    var BASE_URL = "{{url('/shop/')}}";
    
    $(".country-select").change(function(){
        
        var country_id = $(this).val();
        var filedata = new FormData();
        
        filedata.append('country', country_id);
        $.ajax({
            url: BASE_URL + "/cities",
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
            url: BASE_URL + "/zones",
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
            url: BASE_URL + "/areas",
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
      <!--   <div class="top-header col-sm-12 hidden-xs">
                The Most Competitive Prices on Quality Products, Same Day Delivery, A Simplified Return Process to give you The Ultimate Customer Experience!
        </div> -->
           <div class="col-sm-12 hidden-xs" style="padding-left: 7px;padding-right: 7px;">
          <a href="https://dil.africa/shop/campaign/11"> 
            <img src="{{url('black_friday.png')}}" alt=" Shujaa Deals"></a>
             <!--    The Most Competitive Prices on Quality Products, Same Day Delivery, A Simplified Return Process to give you The Ultimate Customer Experience! -->
        </div>
        <div class="container">
            
            <div class="header-top-inner hidden-sm  hidden-xs">
                <div class="cnt-account">
                    <ul class="list-unstyled" style="text-transform:uppercase; font-size:11px">
                        <li><a href="{{url('/seller/register')}}"><i class="icon fa fa-user"></i>Sell</a></li>
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
                <div class="col-xs-9 col-sm-9 col-md-3">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <a href="{{url('/')}}">

                            <img class="hidden-xs hidden-sm" src="{{url('assets/images/logo.png')}}" alt="">

                            <img class="hidden-md hidden-lg" style="width: 117px;margin-top: 8px" src="{{url('assets/images/logo.png')}}" alt="">

                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= -->				
                    </div><!-- /.logo-holder -->

                    <div class="col-xs-3 container hidden-md hidden-lg" style="margin-top: 15px;">
            
                        <div class="header-top-inner hidden-md hidden-lg">
                            <div class="cnt-account">
                                <ul class="list-unstyled" style="text-transform:uppercase; font-size:11px">
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

                    <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ============================================================= SEARCH AREA ============================================================= -->
                    <div class="search-area">
                        <form method="POST" action="{{url('shop/search')}}">
                            <div class="control-group">
                                <input class="search-button-custom hidden-xs hidden-sm" type="submit" value="SEARCH"/>  

                                <input class="search-field" name="pattern" style="font-size: 12px;" placeholder="Search for products,brands..." />
                                <input class="search-button-custom hidden-md hidden-lg" style="padding: 5px;" type="submit" value="SEARCH"/>   
                            </div>
                        </form>
                    </div><!-- /.search-area -->
                    <!-- ============================================================= SEARCH AREA : END ============================================================= -->				</div><!-- /.top-search-holder -->

                <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row hidden-sm hidden-xs">
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
                                        @if(is_numeric($total_price))
                                        <span class="value">{{ number_format($total_price) }}</span>
                                        @endif
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
            <div class="yamm navbar navbar-default hidden-xs hidden-sm" role="navigation">
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
                                    <a href="{{url('/')}}">Home</a>
                                </li>
                                @php( $categories = \Modules\Customer\Utilities\Utilities::getMainCategoriesLimited() )
                                @foreach($categories as $category)
                                @if($category->getNoOfProducts() < 3)
                                @continue;
                                @endif
                                <li class="dropdown yamm mega-menu">
                                    <a href="{{url('/')}}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ strtoupper($category->name)}}</a>
                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">

                                                    @php($subCategories = $category->getSubCategories())

                                                    @foreach($subCategories as $subCategory)
                                                    @if($subCategory->getNoOfProducts() < 3)
                                                    @continue;
                                                    @endif
                                                    <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                        <h2 class="title">
                                                            <a href="{{url('/shop/category/'.$subCategory->slug)}}" style="padding:10px 0px 0px 0px;font-weight: normal;">
                                                                {{strtoupper($subCategory->name)}}
                                                            </a>
                                                        </h2>                                                                                 
                                                        <ul class="links">

                                                            @php($miniCategories = $subCategory->getSubCategories())
                                                            
                                                            @foreach($miniCategories as $miniCategory)
                                                            @if($miniCategory->getNoOfProducts() < 3)
                                                            @continue;
                                                            @endif
                                                            <li style="padding-left: 7px;"><a href="{{url('shop/category/'.$miniCategory->slug)}}">{{ucwords($miniCategory->name)}}</a></li>
                                                            @endforeach

                                                        </ul>
                                                    </div><!-- /.col -->
                                                    @endforeach
			
                                                </div>
                                            </div> <!-- /.yamm-content -->	
                                        </li>
                                    </ul>

                                </li>
                                @endforeach

                            </ul><!-- /.navbar-nav -->
                            <div class="clearfix"></div>				
                        </div><!-- /.nav-outer -->
                    </div><!-- /.navbar-collapse -->

                </div><!-- /.nav-bg-class -->
            </div><!-- /.navbar-default -->

            <style type="text/css">
                
                .navbar-default .navbar-toggle .icon-bar {
                    background-color: #444;
                }

                .head{

                    text-transform: uppercase;
                    font-size: 21px;
                    margin-top: -5px;
                    color: #565656;
                }

                .cnt-home .header-style-1 .header-nav .navbar .xs .navbar-nav > li.active {
                    background: #fff;
                }

                .header-style-1 .header-nav .navbar-default .xs  .navbar-nav > li > a {
                    color: #565656;
                    padding: 7px;
                    border-bottom: 1px solid #eee;
                }

                .header-style-1 .header-nav .navbar-default .xs .navbar-nav > li.active > a {
                    color: #fff;
                }
            </style>

            <div class="yamm navbar navbar-default col-xs-10 col-sm-10 hidden-md hidden-lg" style="background: #fff;" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse-xs" data-toggle="collapse" class="navbar-toggle collapsed" style="margin: -7px 0px 7px 0px;padding:10px;" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="head">Categories</div>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse xs collapse" id="mc-horizontal-menu-collapse-xs">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li class="dropdown yamm-fw">
                                    <a href="{{url('/')}}">Home</a>
                                </li>
                                @php( $categories = \Modules\Customer\Utilities\Utilities::getMainCategoriesLimited() )
                                @foreach($categories as $category)
                                @if($category->getNoOfProducts() < 3)
                                @continue;
                                @endif
                                <li class="dropdown yamm mega-menu">
                                    <a href="{{url('shop/')}}" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">{{ strtoupper($category->name)}}</a>
                                    <ul class="dropdown-menu container">
                                        <li>
                                            <div class="yamm-content ">
                                                <div class="row">

                                                    @php($subCategories = $category->getSubCategories())

                                                    @foreach($subCategories as $subCategory)
                                                    @if($subCategory->getNoOfProducts() < 3)
                                                    @continue;
                                                    @endif
                                                    <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                        <h2 class="title">
                                                            <a href="{{url('/shop/category/'.$subCategory->slug)}}" style="padding:10px 0px 0px 0px;font-weight: normal;">
                                                                {{strtoupper($subCategory->name)}}
                                                            </a>
                                                        </h2>                                                                                 
                                                        <ul class="links">
                                                            
                                                            @php($miniCategories = $subCategory->getSubCategories())
                                                            
                                                            @foreach($miniCategories as $miniCategory)
                                                            @if($miniCategory->getNoOfProducts() < 3)
                                                            @continue;
                                                            @endif
                                                            <li style="padding-left: 7px;"><a href="{{url('shop/category/'.$miniCategory->slug)}}">{{ucwords($miniCategory->name)}}</a></li>
                                                            @endforeach

                                                        </ul>
                                                    </div><!-- /.col -->
                                                    @endforeach
            
                                                </div>
                                            </div> <!-- /.yamm-content -->  
                                        </li>
                                    </ul>

                                </li>
                                @endforeach

                            </ul><!-- /.navbar-nav -->
                            <div class="clearfix"></div>                
                        </div><!-- /.nav-outer -->
                    </div><!-- /.navbar-collapse -->


                </div><!-- /.nav-bg-class -->
            </div><!-- /.navbar-default -->

            <div class="col-xs-2 col-sm-2 animate-dropdown top-cart-row hidden-md hidden-lg" style="padding: 0px;">
                        
                <div class="dropdown dropdown-cart">
                    <a href="{{url('shop/cart')}}" class="dropdown-toggle lnk-cart" style="margin-top: -5px;">
                        <div class="items-cart-inner" style="margin: 0px auto;">
                            <div class="basket" style="padding: 5px;">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                            </div>

                            @php($quantity = \Modules\Customer\Utilities\Utilities::getCustomerTotalCartItems())
                            
                            @php($cart = Session::get('cart'))
                            @if($cart != null)
                            @if(count($cart) > 0)
                            <div class="basket-item-count" style="left: 26px;top: 5px;"><span class="count">{{$quantity}}</span></div>
                            @else 
                            <div class="basket-item-count" style="left: 26px;top: 5px;"><span class="count">0</span></div>                           
                            @endif
                            @else 
                            <div class="basket-item-count" style="left: 26px;top: 5px;"><span class="count">0</span></div>                           
                            @endif

                        </div>
                    </a>
                </div>
            </div>

        </div><!-- /.container-class -->

    </div><!-- /.header-nav -->
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>

<style type="text/css">
    
    .free-shipping{

        padding: 10px 5px;
        margin: 5px 0px;
        background: #2FA5EF;
        font-size: 23px;
        color: #FFF;
        text-align: center;
    }
</style>

<div class="container">

    <div class="col-sm-12 free-shipping">
        <img src="{{url('assets/images/truck_small.png')}}" style="width: 70px;">
        Free Shipping <span style="color: #B37100;font-weight: bold;">Countrywide</span> for all products worth above <span style="color: #B37100;font-weight: bold;">KSh. 2,000/=</span>
        <img src="{{url('assets/images/womsn.png')}}" style="width: 70px;">
    </div>
</div>