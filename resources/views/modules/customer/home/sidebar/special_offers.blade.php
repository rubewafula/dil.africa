<div class="sidebar-widget-body outer-top-xs">
    <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">
        @php($special_offer = new \Modules\Customer\Entities\Special_offer())
        @php($offers = $special_offer->getSpecialOffers())
        
        @foreach($offers as $offer)
        <div class="item">
            <div class="products special-product">
                <div class="product">
                    <div class="product-micro">
                        <div class="row product-micro-row">
                            <div class="col col-xs-5">
                                <div class="product-image">
                                    <div class="image">
                                        <a href="#">
                                            <img src="assets/images/products/{{$offer->product->getDefaultImage()->image_url}}" alt="">
                                        </a>					
                                    </div><!-- /.image -->

                                </div><!-- /.product-image -->
                            </div><!-- /.col -->
                            <div class="col col-xs-7">
                                <div class="product-info">
                                    <h3 class="name"><a href="#">{{$offer->product->name}}</a></h3>
                                    <div class="rating rateit-small"></div>
                                    <div class="product-price">	
                                        <span class="price">
                                            Ksh {{$offer->offer_price}}				
                                        </span>

                                    </div><!-- /.product-price -->
                                    

                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.product-micro-row -->
                    </div><!-- /.product-micro -->

                </div>
                
            </div>
        </div>
        @endforeach
        
    </div>
</div><!-- /.sidebar-widget-body -->