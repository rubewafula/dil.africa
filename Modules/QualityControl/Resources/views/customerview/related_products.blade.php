<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

    @foreach($related_products as $product)
    @if($product->product == null)
    @continue
    @endif
    <div class="item item-carousel">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="{{url('shop/product/detail/'.$product->product->slug)}}">
                            <img  class="img-featured" src="{{ url('assets/images/products/'.$product->product->getDefaultImage()->image_url)}}" alt=""></a>
                        </div><!-- /.image -->			

                    <!-- <div class="tag sale"><span>sale</span></div>  -->          		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                        <h3 class="name"><a href="{{url('shop/product/detail/'.$product->product->slug)}}">{{$product->product->name}}</a></h3>
                        <div class="rating rateit-small"></div>
                        <div class="description"></div>

                        @php($product_price = $product->product->getActivePrice())

                        @if(count($product_price) == 1 || !$product->product->hasDifferentPrices())

                        <div class="product-price"> 
                            
                            @if($product_price->first() != null)
                            @php($offer_price = $product_price->first()->offer_price)
                            @php($standard_price = $product_price->first()->standard_price)
                            @php($sale_price = 0)
                            <span class="price">
                            @if($offer_price != null && $offer_price != "")
                            Ksh {{ number_format($offer_price) }}
                            @php($sale_price = $offer_price)
                            </span>
                            <span class="price-before-discount">
                                KSh {{ number_format($standard_price) }}
                                @php($sale_price = $standard_price)
                            </span> 
                            @else 
                            <span class="price">
                            Ksh {{ number_format($standard_price) }}
                            @php($sale_price = $standard_price)
                            @endif      
                            </span>   
                            @endif
                            
                        </div><!-- /.product-price -->

                        @elseif(count($product_price) > 1 && $product->product->hasDifferentPrices())

                        @php($max_price = $product->product->getMaximumPrice())
                        @php($min_price = $product->product->getMinimumPrice())

                        <div class="product-price"> 
                                
                            <span class="price">

                                KSh {{$min_price}} - KSh {{$max_price}}
                                @php($sale_price = $max_price)
                            </span>

                        </div>

                        @endif

                        @if(count($product_price) > 0)
                        @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))
                        <div class="eligible-shipping">
                            {{ $shipping_message }}
                        </div>
                        @endif

                    </div><!-- /.product-info -->

                    @if(count($product_price) == 1)
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{url('shop/add_to_cart')}}">
                                        <input type="hidden" value="{{$product->product->getActivePrice()->first()->id}}" name="product_ref" />
                                        <input type="hidden" value="1" name="quantity" />
                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="{{$product->product->getActivePrice()->first()->id}}" title="Add Cart">
                                            <i class="fa fa-shopping-cart"></i>                                                 
                                        </button>
                                        <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                    </form>
                                </li>

                                <li class="lnk wishlist">
                                    <a class="add-to-cart" href="{{url('shop/add_to_wishlist/'.$product->product->id.'/'.$product->product->getActivePrice()->first()->id)}}" title="Wishlist">
                                        <i class="icon fa fa-heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.action -->
                    </div><!-- /.cart -->
                    @endif
                </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    @endforeach

</div><!-- /.home-owl-carousel -->