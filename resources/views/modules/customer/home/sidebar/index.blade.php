<!-- ============================================== SIDEBAR ============================================== -->	
<div class="col-xs-12 col-sm-12 col-md-3 sidebar">

    <!-- ================================== TOP NAVIGATION ================================== -->
    <div class="side-menu animate-dropdown outer-bottom-xs hidden-xs">
        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>        
        @include('customer::home.sidebar.categories')

    </div><!-- /.side-menu -->
    <!-- ================================== TOP NAVIGATION : END ================================== -->

    <div class="hidden-xs" style="margin-bottom:20px">
        @include('customer::home.sidebar.banner_1')
    </div> 

    <!-- ============================================== HOT DEALS ============================================== -->
    <div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs hidden-xs hidden-sm">
        <h3 class="section-title">hot deals</h3>
        @include('customer::home.sidebar.hot_deals')
    </div>
    <!-- ============================================== HOT DEALS: END ============================================== -->

    <!-- ============================================== SPECIAL OFFER ============================================== -->

    <div class="sidebar-widget outer-bottom-small wow fadeInUp hidden-xs hidden-sm">
        <h3 class="section-title">Special Offer</h3>
        @include('customer::home.sidebar.special_offers')
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== SPECIAL OFFER : END ============================================== -->

    <!-- <div class="sidebar-widget product-tag outer-bottom-xs wow fadeInUp">
        <h3 class="sectsion-title">Product tags</h3>
        @include('customer::home.sidebar.product_tags')
    </div> -->

    <!-- ============================================== NEWSLETTER ============================================== -->
    <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small hidden-xs">
        <h3 class="section-title">Newsletters</h3>
        @include('customer::layouts.newsletter')
    </div><!-- /.sidebar-widget -->
    <!-- ============================================== NEWSLETTER: END ============================================== -->

    <!-- ============================================== Testimonials============================================== -->
    <div class="sidebar-widget  wow fadeInUp outer-top-vs hidden-xs" style="padding-bottom: 36px;">
        <h3 class="section-title">Electronics</h3>
        @include('customer::home.sidebar.electronics')
    </div>

    <!-- ============================================== Testimonials: END ============================================== -->
</div><!-- /.sidemenu-holder -->
<!-- ============================================== SIDEBAR : END ============================================== -->