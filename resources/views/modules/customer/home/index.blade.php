@extends('customer::layouts.master')

@section('content')

<div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
        <div class="row">

            @include('customer::home.sidebar.index')

            <!-- ============================================== CONTENT ============================================== -->
            <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
                <!-- ========================================== SECTION – HERO ========================================= -->

                @include('customer::home.main_banner')

                <!-- ========================================= SECTION – HERO : END ========================================= -->	

                <!-- ============================================== INFO BOXES ============================================== -->
                <div class="info-boxes wow fadeInUp hidden-xs">
                    <div class="info-boxes-inner">
                        <div class="row">
                            <div class="col-md-6 col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">money back</h4>
                                        </div>
                                    </div>	
                                    <h6 class="text">7 Days Money Back Guarantee</h6>
                                </div>
                            </div><!-- .col -->

                            <div class="hidden-md col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">free shipping</h4>
                                        </div>
                                    </div>
                                    <h6 class="text">Free shipping on orders subject to certain terms</h6>	
                                </div>
                            </div><!-- .col -->

                            <div class="col-md-6 col-sm-4 col-lg-4">
                                <div class="info-box">
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <h4 class="info-box-heading green">Happy Clients</h4>
                                        </div>
                                    </div>
                                    <h6 class="text">99.9% Satisfaction Rate </h6>	
                                </div>
                            </div><!-- .col -->
                        </div><!-- /.row -->
                    </div><!-- /.info-boxes-inner -->

                </div><!-- /.info-boxes -->
                <!-- ============================================== INFO BOXES : END ============================================== -->
                <!-- ============================================== SCROLL TABS ============================================== -->
                <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp hidden-xs hidden-sm">

                    @include('customer::home.recommended.index')
                </div><!-- /.scroll-tabs -->

                <div class="scroll-tabs hidden-md hidden-lg">

                    @include('customer::home.recommended.index')
                </div><!-- /.scroll-tabs -->

                <!-- ============================================== SCROLL TABS : END ============================================== -->
                <!-- ============================================== WIDE PRODUCTS ============================================== -->
                <!-- /.wide-banners -->

                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
                <!-- ============================================== FEATURED PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp hidden-xs hidden-sm">
                    <h3 class="section-title" style="background: #FFA200;">Featured products</h3>
                    @include('customer::home.featured')

                </section><!-- /.section -->

                <div class="section featured-product scroll-tabs hidden-md hidden-lg">
                    <h3 class="section-title" style="background: #FFA200;">Featured products</h3>
                    @include('customer::home.featured')
                </div>
                <!-- ============================================== FEATURED PRODUCTS : END ============================================== -->
                <!-- ============================================== WIDE PRODUCTS ============================================== -->
                <div class="wide-banners wow fadeInUp outer-bottom-xs hidden-xs">
                    @include('customer::home.middle_banner_1')
                </div><!-- /.wide-banners -->
                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
                <!-- ============================================== BEST SELLER ============================================== -->

                <div class="best-deal wow fadeInUp outer-bottom-xs hidden-xs hidden-sm">
                    <h3 class="section-title">Top Brands</h3>
                    @include('customer::home.top_brands')
                </div><!-- /.sidebar-widget -->
                <!-- ============================================== BEST SELLER : END ============================================== -->	

                <div class="sidebar-widget hot-deals outer-bottom-xs hidden-md hidden-lg ">
                    <h3 class="section-title">hot deals</h3>
                    @include('customer::home.sidebar.hot_deals')
                </div>
                <!-- ============================================== FEATURED PRODUCTS ============================================== -->
                <section class="section wow fadeInUp new-arriavls hidden-xs hidden-sm">
                    <h3 class="section-title" style="background: #FFA200;">New Arrivals</h3>
                    @include('customer::home.new_arrivals')
                </section><!-- /.section -->

                <div class="section new-arriavls hidden-md hidden-lg">
                    <h3 class="section-title" style="background: #FFA200;">New Arrivals</h3>
                    @include('customer::home.new_arrivals')
                </div>
                <!-- ============================================== FEATURED PRODUCTS : END ============================================== -->

                <div class="sidebar-widget outer-bottom-small hidden-md hidden-lg">
                    <h3 class="section-title">Special Offer</h3>
                    @include('customer::home.sidebar.special_offers')
                </div><!-- /.sidebar-widget -->

                 <section class="section wow fadeInUp new-arriavls hidden-xs hidden-sm">
                    <h3 class="section-title" style="text-transform: capitalize;">Trending in Electronics</h3>
                    @include('customer::home.electronics')
                </section> 

                <div class="section new-arriavls hidden-md hidden-lg">
                    <h3 class="section-title" style="text-transform: capitalize;">Trending in Electronics</h3>
                    @include('customer::home.electronics')
                </div>
            </div><!-- /.homebanner-holder -->
            <!-- ============================================== CONTENT : END ============================================== -->
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL -->
        
    <div class="row hidden-xs" style="margin: 0px;">
        <div class="col-xs-12 col-sm-12 col-md-12" style="height:90px;background-image: url(assets/images/flash_sale.jpg);margin-right: 15px;">
            
            <div class="col-sm-4" style="font-weight: bold;
    font-size: 55px;
    color: #FFF;
    padding: 8px;">
                FLASH SALE!!
            </div>
            <div class="col-sm-1" style="padding:7px;">
                <img src="{{url('assets/images/clock.png')}}"/>
            </div>
            <div class="col-sm-4" style="font-weight: bold;
    font-size: 24px;
    padding: 30px;">
                Limited Stock, Limited Time
            </div>
            <div class="col-sm-1" style="padding:3px;">
                <img src="{{url('assets/images/happy-black-woman.png')}}"/>
            </div>
            <div class="col-sm-1" style="padding:3px;">
                <a href="{{url('/shop/flash-sale')}}">
                    <button class="btn btn-sm" style="background: #565656;margin: 23px 35px;font-size: 20px;font-weight: bold;color: #fff;border-radius: 0px;">SHOP NOW > </button>
                </a>
            </div>
        </div>
        
    </div>
    <div class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-3 sidebar hidden-xs">
            <div class="sidebar-widget  wow fadeInUp outer-top-vs " style="padding-bottom: 36px;">
                <h3 class="section-title">Fashion & Clothing</h3>
                @include('customer::home.sidebar.fashion')
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
            <h3 class="section-title hidden-md hidden-lg" style="text-transform: capitalize;background: #FFA200;padding: 18px 20px;color: #FFF;font-size: 16px;">Trending in Fashion</h3>
            <section class="section wow fadeInUp new-arriavls hidden-xs hidden-sm" style="margin-top: 20px;">
                @include('customer::home.fashion')
            </section>
            <div class="section new-arriavls hidden-md hidden-lg" style="margin-top: 20px;">
                @include('customer::home.fashion')
            </div>
        </div>
    </div>
    <div class="row hidden-xs" style="margin: 0px;">
        <div class="col-xs-12 col-sm-12 col-md-12" style="height:90px;background-image: url(assets/images/blue-shades.jpg);margin-right: 15px;">
            
            <div class="col-sm-4" style="font-weight: bold;
    font-size: 24px;
    color: #FFF;
    padding: 28px 10px;">
                Give yourself an amazing Look!!
            </div>
            <div class="col-sm-1" style="padding:7px;">
                <img src="{{url('assets/images/carousel/hair.png')}}"/>
            </div>
            <div class="col-sm-4" style="font-weight: bold;
    font-size: 26px;
    padding: 30px;color: #FA0">
                DIL.AFRICA, <span style="color: #FFF;font-size:23px;">Personal Care</span>
            </div>
            <div class="col-sm-2" style="padding:10px 0px;">
                <img src="{{url('assets/images/carousel/she_lipgloss.png')}}" width="50px" />
                <img src="{{url('assets/images/carousel/shaver_2.png')}}" width="50px" />
            </div>
            <div class="col-sm-1" style="padding:3px;">
                <a href="{{url('/shop/category/fragrances')}}" style="color:#FFF;">
                <button class="btn btn-sm" style="background: #565656;margin: 23px -45px;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    border-radius: 0px;">SHOP NOW> </button>
            </a>
            </div>
        </div>
        
    </div>

    <div class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-3 sidebar hidden-xs">
            <div class="sidebar-widget  wow fadeInUp outer-top-vs " style="padding-bottom: 36px;">
                <h3 class="section-title">Personal Care</h3>
                @include('customer::home.sidebar.hair_beauty')
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
            <h3 class="section-title hidden-md hidden-lg" style="text-transform: capitalize;background: #232f3e;padding: 18px 20px;color: #FFF;font-size: 16px;">Trending in Hair & Beauty</h3>
            <section class="section wow fadeInUp new-arriavls hidden-xs hidden-sm" style="margin-top: 20px;">
                @include('customer::home.hair_beauty')
            </section>
            <div class="section new-arriavls hidden-md hidden-lg" style="margin-top: 20px;">
                @include('customer::home.hair_beauty')
            </div>
        </div>
    </div>

    <div class="best-deal outer-bottom-xs hidden-md hidden-lg">
        <h3 class="section-title" style="background: #FFA200;">Top Brands</h3>
        @include('customer::home.top_brands')
    </div><!-- /.sidebar-widget -->

    <div class="top-bar animate-dropdown hidden-md hidden-lg">
        <div class="header-top-inner">
            <div class="cnt-account">
                <ul class="list-unstyled" style="text-transform:uppercase; font-size:11px">
                    <li><a href="{{url('/seller/register')}}"><i class="icon fa fa-user"></i>Sell</a></li>
                    <li><a href="{{url('/shop/my-account')}}"><i class="icon fa fa-user"></i>My Account</a></li>
                    <li><a href="{{url('shop/wishlist')}}"><i class="icon fa fa-heart"></i>My Wishlist</a></li>
                    <li><a href="{{url('/shop/cart')}}"><i class="icon fa fa-shopping-cart"></i>My Cart</a></li>
                    <li><a href="{{url('/shop/checkout')}}"><i class="icon fa fa-check"></i>Checkout</a></li>
                    <li><a  href="{{url('shop/history')}}">My History</a></li>               
                </ul>
            </div><!-- /.cnt-account -->

            <!-- /.cnt-cart -->
            <div class="clearfix"></div>
        </div><!-- /.header-top-inner -->
    </div>

    <div class="row hidden-xs" style="margin: 0px;line-height: 2em;">
            
            <div class="col-xs-12 col-sm-12 col-md-12 heading-title" style="margin-bottom: 10px;border-top: 2px solid #565656;padding: 20px !important;">Ultimate Online Shopping Experience with DIL.AFRICA</div>

                     <div class="col-xs-12 col-sm-12 col-md-12" style="background: #fff;padding: 10px;">
                        DIL.AFRICA is a fast growing e-commerce platform that offers our customers an unmatched shopping experience through provision of high quality goods, a wide variety of products, a simplified return process and an umatched quick delivery timelines. Our mission is to provide the world’s best customer experience through continuos innovation and linkages.  We have  leveraged  on  technology  to  ensure  that  our  customers  get  high quality goods. We do this by subjecting the products to quality assurance measures. This coupled by our extensive logistics network throughout the country ensures that customers are always satisfied and goods are delivered to them when they need them without unnecessary delay.  
We do country wide delivery of products. In Nairobi, we do deliveries within 6hrs while outside Nairobi we deliver within 24 hours. 
We deal in a wide variety of products ranging from televisions, laptops and computers, phones and tablets, men’s and women’s fashion, hair care products, makeup and cosmetic products, perfumes, as well as books.
DIL.AFRICA seeks to solve some of the problems customers face when buying online such as;
<ul style="margin-left: 10px;">
    <li>- Long delivery times</li>
    <li>- Not receiving exactly what you ordered</li>
    <li>- Poor quality of goods</li>
</ul>
             
             At DIL.AFRICA, you will find a wide variety of brands. In electronics all the major brands including Sony, LG, Samsung, Huawei, Dell, HP, IBM, Lenovo, Techno, Tesla among others. Fashion lovers are well catered for by major brands including Nike,  Gianna, Adidas, Zecchino among many others. Hair & Beauty is also well covered by all the major brands. We endeavor to always walk faster and discover much more for our customers!
                    </div>

    </div>

</div>
@stop