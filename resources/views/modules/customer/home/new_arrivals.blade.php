 @php($new_arrival = new \Modules\Customer\Entities\New_arrival())
 @php($arrivals = $new_arrival->getNewArrivals())
 <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs hidden-xs hidden-sm">

    @foreach($arrivals as $arrival)
    @if($arrival->product == null)
    @continue
    @endif
    <div class="item item-carousel" style="min-height: 326px;">
        <div class="products">

            <div class="product">		
                <div class="product-image">
                    <div class="image">
                        <a href="{{url('shop/product/detail/'.$arrival->product->slug)}}">
                            <div class="featured-img">
                                <span class="helper"></span>
                                <img  class="img-featured" src="{{url('/assets/images/products/'.$arrival->product->getDefaultImage()->image_url)}}" alt="">
                            </div>
                        </a>
                    </div><!-- /.image -->			

                   <!-- <div class="tag new"><span>new</span></div>  -->                      		   
                </div><!-- /.product-image -->


                <div class="product-info text-left">
                        
                        <h3 class="name"><a href="{{url('shop/product/detail/'.$arrival->product->slug)}}">{{$arrival->product->name}}</a></h3>
                        <div class="rating rateit-small"></div>
                        <div class="description"></div>

                        @php($product_price = $arrival->product->getActivePrice())
       
                        @if(count($product_price) == 1 || !$arrival->product->hasDifferentPrices())

                        <div class="product-price"> 
                            
                            @if($product_price->first() != null)
                            @php($offer_price = $product_price->first()->offer_price)
                            @php($standard_price = $product_price->first()->standard_price)
                            @php($sale_price = 0)
                            <span class="price">
                            @if($offer_price != null && $offer_price != "")
                            Ksh {{ number_format($offer_price + $arrival->product->getShippingCost()) }}
                            @php($sale_price = $offer_price)
                            </span>
                            <span class="price-before-discount">
                                KSh {{ number_format($standard_price + $arrival->product->getShippingCost()) }}
                                @php($sale_price = $standard_price)
                            </span> 
                            @else 
                            <span class="price">
                            Ksh {{ number_format($standard_price + $arrival->product->getShippingCost()) }}
                            @php($sale_price = $standard_price)
                            @endif      
                            </span>  
                            @endif 
                            
                        </div><!-- /.product-price -->
                        
                        @elseif(count($product_price) > 1 && $arrival->product->hasDifferentPrices())

                        @php($max_price = $arrival->product->getMaximumPrice())
                        @php($min_price = $arrival->product->getMinimumPrice())

                        <div class="product-price"> 
                                
                            <span class="price">

                                KSh {{ number_format($min_price + $arrival->product->getShippingCost()) }} - KSh {{ number_format($max_price + $arrival->product->getShippingCost()) }}
                                @php($sale_price = $max_price)
                            </span>

                        </div>

                        @endif

                        @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))
                        <div class="eligible-shipping">
                            {{ $shipping_message }}
                        </div>

                    </div><!-- /.product-info -->

                    @if($product_price->first() != null)
                    @if(count($product_price) == 1 || !$arrival->product->hasDifferentPrices())
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{url('shop/add_to_cart')}}">
                                        <input type="hidden" value="{{$arrival->product->getActivePrice()->first()->id}}" name="product_ref" />
                                        <input type="hidden" value="1" name="quantity" />
                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="{{$arrival->product->getActivePrice()->first()->id}}" title="Buy Now">
                                            <i class="fa fa-shopping-cart"></i>                                                 
                                        </button>
                                        <button class="btn btn-primary cart-btn" type="button">Buy Now</button>
                                    </form>
                                </li>

                                <li class="lnk wishlist">
                                    <a class="add-to-cart" href="{{url('shop/add_to_wishlist/'.$arrival->product->id.'/'.$arrival->product->getActivePrice()->first()->id)}}" title="Add to Wishlist">
                                        <i class="icon fa fa-heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.action -->
                    </div><!-- /.cart -->
                    @endif
                    @endif
                </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    @endforeach

</div><!-- /.home-owl-carousel -->

<div class="row  hidden-md hidden-lg">
    @php($count = 0)
    @foreach($arrivals as $arrival)
    @if($arrival->product == null)
    @continue
    @endif
    @php($count++)
    @if($count == 0 || $count == 2)
    <div class="row">
    @endif
    @if($count == 5)
    @break
    @endif
    <div class="col-sm-6 col-xs-6" style="border-top: 1px solid #eee;border-left: 1px solid #eee;">
    <div class="item item-carousel">
        <div class="products" style="padding: 10px;">

            <div class="product">       
                <div class="product-image">
                    <div class="image">
                        <a href="{{url('shop/product/detail/'.$arrival->product->slug)}}">
                            <div class="featured-img">
                                <!-- <span class="helper"></span> -->
                                <img class="img-featured" src="{{url('/assets/images/products/'.$arrival->product->getDefaultImage()->image_url)}}" alt="" />
                            </div>
                        </a>
                    </div><!-- /.image -->          

                    <!-- <div class="tag hot"><span>hot</span></div> -->           
                </div><!-- /.product-image -->

                <div class="product-info text-left">
                        
                        <h3 class="name"><a href="{{url('shop/product/detail/'.$arrival->product->slug)}}">{{$arrival->product->name}}</a></h3>
                        <div class="rating rateit-small"></div>
                        <div class="description"></div>

                        @php($product_price = $arrival->product->getActivePrice())

                        @if(count($product_price) == 1 || !$arrival->product->hasDifferentPrices())

                        <div class="product-price"> 

                            @if($product_price->first() != null)
                            @php($offer_price = $product_price->first()->offer_price)
                            @php($standard_price = $product_price->first()->standard_price)
                            @php($sale_price = 0)
                            
                            <span class="price">
                            @if($offer_price != null && $offer_price != "")
                            Ksh {{ number_format($offer_price + $arrival->product->getShippingCost()) }}
                            @php($sale_price = $offer_price)
                            </span>
                            <span class="price-before-discount">
                                KSh {{ number_format($standard_price + $arrival->product->getShippingCost()) }}
                                @php($sale_price = $standard_price)
                            </span> 
                            @else 
                            <span class="price">
                            Ksh {{ number_format($standard_price + $arrival->product->getShippingCost()) }}
                            @php($sale_price = $standard_price)
                            @endif      
                            </span>   
                            @endif  
                            
                        </div><!-- /.product-price -->

                        @elseif(count($product_price) > 1 && $arrival->product->hasDifferentPrices())

                        @php($max_price = $arrival->product->getMaximumPrice())
                        @php($min_price = $arrival->product->getMinimumPrice())

                        <div class="product-price"> 
                                
                            <span class="price">

                                KSh {{ number_format($min_price + $arrival->product->getShippingCost()) }} - KSh {{ number_format($max_price + $arrival->product->getShippingCost()) }}
                                @php($sale_price = $max_price)
                            </span>

                        </div>

                        @endif

                        @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))

                        <div class="eligible-shipping">
                            {{ $shipping_message }}
                        </div>

                    </div><!-- /.product-info -->

                </div><!-- /.product -->

        </div><!-- /.products -->
    </div><!-- /.item -->
    </div>
     @if($count == 0 || $count == 2)
    </div>
    @endif
    @endforeach
</div>