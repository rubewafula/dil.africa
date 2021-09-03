<div class="row" style="padding: 10px 0px 0px 15px;">   
    Search Results for <span class="blue-fg">{{ substr($title, 13)}}</span>
</div>

@foreach($products as $product)
@if(count(Modules\Customer\Utilities\Utilities::getActivePrice($product->id)) == 0)
@continue
@endif
@php($product_image = Modules\Customer\Utilities\Utilities::getDefaultImage($product->id))
<div class="category-product-inner wow fadeInUp">
    <div class="products">				
        <div class="product-list product">
            <div class="row product-list-row">
                <div class="col col-sm-4 col-lg-4">
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
                        </div>
                    </div><!-- /.product-image -->
                </div><!-- /.col -->
                <div class="col col-sm-8 col-lg-8">
                    <div class="product-info">
                                <h3 class="name"><a href="{{url('shop/product/detail/'.$product->slug)}}">
                            {{ ucwords($product->name) }}
                            </a></h3>
                        <div class="rating rateit-small"></div>
                        @php($product_price = Modules\Customer\Utilities\Utilities::getActivePrice($product->id))

                       @if(count($product_price) == 1 || !Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))

                        <div class="product-price"> 
                            
                            @if($product_price[0] != null)
                            @php($offer_price = $product->offer_price)
                            @php($standard_price = $product_price[0]->standard_price)
                            @php($sale_price = 0)
                            <span class="price">
                            @if($offer_price != null && $offer_price != "")
                            Ksh {{ number_format($offer_price + $product->getShippingCost()) }}
                            @php($sale_price = $offer_price)
                            </span>
                            <span class="price-before-discount">
                                KSh {{ number_format($standard_price + $product->getShippingCost()) }}
                                @php($sale_price = $standard_price)
                            </span> 
                            @else 
                            <span class="price">
                            Ksh {{ number_format($standard_price + $product->getShippingCost()) }}
                            @php($sale_price = $standard_price)
                            @endif      
                            </span> 
                            @endif  
                            
                        </div><!-- /.product-price -->

                        @elseif(count($product_price) > 1 && Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))

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

                        <div class="description m-t-10">
                            @php($product_features = \Modules\Customer\Utilities\Utilities::product_features($product->id))
                            
                            @if(count($product_features) > 0)
                            <h3>Key Features</h3>
                            @foreach($product_features as $feature)
                            <li> 
                             @if($feature->feature_type_id  == 3)
                               {{$feature->value}}
                             @else
                              <strong> {{($feature->feature_type != null)?$feature->feature_type->name: 'General' }}: </strong> {{$feature->value}} 
                             @endif
                             @endforeach
                             @endif
                        </div>
                        @if(count($product_price) == 1 || !\Modules\Customer\Utilities\Utilities::hasDifferentPrices($product->id))
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

                    </div><!-- /.product-info -->	
                </div><!-- /.col -->
            </div><!-- /.product-list-row -->
            <div class="tag new"><span>new</span></div>        
        </div><!-- /.product-list -->
    </div><!-- /.products -->
</div><!-- /.category-product-inner -->
@endforeach