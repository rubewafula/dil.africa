<div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

    @php($new_arrival = new \Modules\Customer\Entities\New_arrival())
    @php($arrivals = $new_arrival->getNewArrivals())

    @foreach($arrivals as $arrival)
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="{{url('shop/product/detail/'.$arrival->id)}}"><img  src="assets/images/products/{{$arrival->product->getDefaultImage()->image_url}}" alt=""></a>
                    </div><!-- /.image -->			

                    <div class="tag new"><span>new</span></div>                        		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                    <h3 class="name"><a href="{{url('shop/product/detail/'.$arrival->id)}}">{{$arrival->product->name}}</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>

                    <div class="product-price">	
                        <span class="price">
                            Ksh {{$arrival->product->getActivePrice()->offer_price}}				
                        </span>
                        <span class="price-before-discount">
                            Ksh {{$arrival->product->getActivePrice()->standard_price}}
                        </span>

                    </div><!-- /.product-price -->

                </div><!-- /.product-info -->
                <div class="cart clearfix animate-effect">
                    <div class="action">
                        <ul class="list-unstyled">
                            <li class="add-cart-button btn-group">
                                <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                    <i class="fa fa-shopping-cart"></i>													
                                </button>
                                <button class="btn btn-primary cart-btn" type="button">Add to cart</button>

                            </li>

                            <li class="lnk wishlist">
                                <a class="add-to-cart" href="{{url('shop/product/detail/'.$arrival->id)}}" title="Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </li>

                            <li class="lnk">
                                <a class="add-to-cart" href="{{url('shop/product/detail/'.$arrival->id)}}" title="Compare">
                                    <i class="fa fa-signal" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.action -->
                </div><!-- /.cart -->
            </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    @endforeach

</div><!-- /.home-owl-carousel -->