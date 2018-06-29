<div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

    @php($new_arrival = new \Modules\Customer\Entities\New_arrival())
    @php($arrivals = $new_arrival->getNewArrivals())

    @foreach($arrivals as $arrival)
    @if($arrival->product == null)
    @continue
    @endif
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="{{url('shop/product/detail/'.$arrival->product_id)}}">
                            <img  src="assets/images/products/{{$arrival->product->getDefaultImage()->image_url}}" alt="">
                        </a>
                    </div><!-- /.image -->			

                    <div class="tag new"><span>new</span></div>                        		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                    <h3 class="name"><a href="{{url('shop/product/detail/'.$arrival->product_id)}}">{{$arrival->product->name}}</a></h3>
                    <div class="rating rateit-small"></div>
                    <div class="description"></div>

                    @php($productPrice = $arrival->product->getActivePrice())
                    <div class="product-price">	
                        <span class="price">
                            Ksh {{$productPrice->offer_price}}				
                        </span>
                        <span class="price-before-discount">
                            Ksh {{$productPrice->standard_price}}
                        </span>
                        <input type="hidden" value="{{$arrival->id}}" id="product_arrivals_ref" />
                    </div><!-- /.product-price -->

                </div><!-- /.product-info -->
                <div class="cart clearfix animate-effect">
                    <div class="action">
                        <ul class="list-unstyled">
                            <li class="add-cart-button btn-group">
                                <form method="POST" action="{{url('shop/add_to_cart')}}">
                                    <input type="hidden" value="{{$productPrice->id}}" name="product_ref" />
                                    <input type="hidden" value="1" name="quantity" />
                                    <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="{{$productPrice->id}}" title="Add Cart">
                                        <i class="fa fa-shopping-cart"></i>													
                                    </button>
                                    <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                </form>
                            </li>

                            <li class="lnk wishlist">
                                <a class="add-to-cart" href="{{url('shop/add_to_wishlist/'.$arrival->product->id.'/'.$productPrice->id)}}" title="Wishlist">
                                    <i class="icon fa fa-heart"></i>
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