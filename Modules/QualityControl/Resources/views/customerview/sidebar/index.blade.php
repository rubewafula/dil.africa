<div class='col-md-3 hidden-xs sidebar'>
    <div class="sidebar-module-container">
        <div class="home-banner outer-top-n"> 
            <!-- <a href="#"> -->
                <img src="{{url('assets/images/cash-on-delivery.png')}}" alt="cash-on-delivery">
            <!-- </a> -->
            <!-- <a href="#"> -->
                <img src="{{url('assets/images/genuine-products.png')}}" alt="genuine-products">
            <!-- </a> -->
            <img src="{{url('assets/images/same_day_delivery.png')}}" alt="genuine-products">
            <a href="{{url('shop/faq')}}">
                <img src="{{url('assets/images/FAQs.png')}}" alt="FAQS">
            </a>
        </div>		

        <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small outer-top-vs">
            <h3 class="section-title">Newsletters</h3>           
            @include('customer::layouts.newsletter')
        </div><!-- /.sidebar-widget -->
        <!-- ============================================== NEWSLETTER: END ============================================== -->

        <!-- ============================================== Testimonials============================================== -->
        <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
            @include('customer::layouts.testimonials')
        </div>

        <!-- ============================================== Testimonials: END ============================================== -->

    </div>
</div><!-- /.sidebar -->