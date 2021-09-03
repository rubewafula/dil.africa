@php($total_count = count($products))

@php($col_count = 0)

@if($total_count > 0)
<div class="row" style="padding: 10px 0px 0px 15px;">   
    Search Results for <span class="blue-fg">{{ substr($title, 13)}}</span>
</div>
@else
 <div class="row" style="padding: 10px 0px 0px 15px;font-size: 14px;">   
    
    <div style="    font-size: 14px;
    color: #0F7DC2;
    line-height: 1.8em;
    background: #eee;
    padding: 10px;
    margin-bottom: 10px;"> Sorry, we did not find products for  
        <span class="blue-fg">"{{ substr($title, 13)}}"</span>.
        <span style="font-weight: bold;"> However do not worry. 
        <span style="color: #CC0000;">Leave your details with us here below and we will get a good deal for you and get back to you!</span> </span> </div>

    <div class="col-md-8 col-sm-8 col-md-offset-1 create-new-account">

    <style type="text/css">
        
        .form-group .info-title{ font-weight: normal; }

    </style>

    <form class="address-form" role="form" method="POST" action="{{url('shop/save-search')}}">

        <input type="hidden" value="{{isset($searched_item_id)?$searched_item_id:""}}" name="searched_item_id" />
        <div class="col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="item_looking_for">What are you looking for? <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="item_looking_for" name="item_looking_for" value="{{ substr($title, 13)}}" placeholder=""/>
            </div>                                                                                  
        </div>
        <div class="col-sm-12 already-registered-login">
            
            <div class="form-group">
                <label class="info-title" for="phone">Your Phone Number <span>*</span></label>
                <input type="text" class="form-control unicase-form-control text-input" id="phone" name="phone" placeholder=""/>
            </div> 
        </div>
        <div class="col-sm-12 already-registered-login">
            <div class="form-group">
                <label class="info-title" for="email">Your Email Address </label>
                <input type="text" class="form-control unicase-form-control text-input" id="email" name="email" placeholder=""/>
            </div> 
        </div>
        <div class="col-sm-12 already-registered-login">
            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Save (Get Me a Good Deal)</button>
        </div>
    </form>

</div>
</div>
@endif

@foreach($products as $product)
@php($product_price = Modules\Customer\Utilities\Utilities::getActivePrice($product->id))
@if(count($product_price) > 0)
@if($col_count == 0)
<div class="row">
@endif
@php($product_image = Modules\Customer\Utilities\Utilities::getDefaultImage($product->id))
<div class="col-md-3 wow fadeInUp">
    <div class="products">
        <div class="product" style="margin-bottom: 5px;">		
            <div class="product-image">
                <div class="image">
                    <a href="{{url('shop/product/detail/'.$product->slug)}}">
                        @if($product_image != null)
                        <div class="featured-img">
                            <span class="helper"></span>
                            <img  class="img-featured" src="{{url('assets/images/products/'.$product_image[0]->image_url)}}" width="100px" alt="">
                        </div>
                        @else
                        <div class="featured-img">
                            <span class="helper"></span>
                            <img  class="img-featured" src="{{url('assets/images/products/no_image.jpg')}}" alt="">
                        </div>
                        @endif
                    </a>
                </div><!-- /.image -->			

                <!--
                <div class="tag new">
                    <span>new</span>
                </div> 
                -->                       		   
            </div><!-- /.product-image -->

            <div class="product-info text-left">

                <h3 class="name"><a href="{{url('shop/product/detail/'.$product->slug)}}">{{ ucwords($product->name)}}</a></h3>
                <div class="rating rateit-small"></div>
                <div class="description"></div>

                @if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))

                <div class="product-price"> 
                    
                    @if($product_price[0] != null)
                    @php($offer_price = $product_price[0]->offer_price)
                    @php($standard_price = $product_price[0]->standard_price)
                    @php($sale_price = 0)
                    <span class="price">
                    @if($offer_price != null && $offer_price != "")
                    Ksh {{ number_format($offer_price + $product->getShippingCost()) }}
                    @php($sale_price = $offer_price)
                    </span>
                    <span class="price-before-discount">
                        KSh {{ number_format($standard_price + $product->getShippingCost()) }}
                    </span> 

                              <span class="sale-flag-percent">
             <?php $stp= $standard_price + $product->getShippingCost() ?>
              <?php $ofp= $offer_price + $product->getShippingCost() ?>

              @if($stp > 0  && $ofp > 0)
              <?php 

                  $diff= $stp - $ofp ;

                  $percent=  ($diff/$stp)*100;
                   echo '-'.floor($percent).'%';

               ?>

              
              @endif 
   </span>
                    @else 
                    <span class="price">
                    Ksh {{ number_format($standard_price + $product->getShippingCost()) }}
                    @php($sale_price = $standard_price)
                    @endif      
                    </span>  
                    @endif 
                    
                </div><!-- /.product-price -->

                @elseif(count($product_price) > 1 && \Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))

                @php($max_price = \Modules\Customer\Utilities\Utilities::getMaximumPrice($product->id))
                @php($min_price = \Modules\Customer\Utilities\Utilities::getMinimumPrice($product->id))

                <div class="product-price"> 
                        
                    <span class="price">

                        KSh {{ number_format($min_price + $product->getShippingCost()) }} - KSh {{ number_format($max_price + $product->getShippingCost()) }}
                        @php($sale_price = $max_price)
                    </span>

                </div>

                @endif

                @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))
                <div class="eligible-shipping">
                    {{ $shipping_message }}
                </div>

            </div><!-- /.product-info -->

            @if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))
            <div class="cart clearfix animate-effect">
                <div class="action">
                    <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                            <form method="POST" action="{{url('shop/add_to_cart')}}">
                                <input type="hidden" value="{{$product_price[0]->id}}" name="product_ref" />
                                <input type="hidden" value="1" name="quantity" />
                                <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="{{$product_price[0]->id}}" title="Buy Now">
                                    <i class="fa fa-shopping-cart"></i>                                                 
                                </button>
                                <button class="btn btn-primary cart-btn" type="button">Buy Now</button>
                            </form>
                        </li>

                        <li class="lnk wishlist">
                            <a class="add-to-cart" href="{{url('shop/add_to_wishlist/'.$product->id.'/'.$product_price[0]->id)}}" title="Wishlist">
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
@php($col_count++)
@if($col_count == 4)
</div>
@php($col_count = 0)
@endif
@else
@php($total_count -= 1)
@endif
@endforeach
@if($total_count%4 != 0)
</div>
@endif