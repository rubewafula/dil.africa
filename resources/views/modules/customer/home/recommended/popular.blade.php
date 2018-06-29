<div class="product-slider">
    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">

        @php($popular_products = new \Modules\Customer\Entities\Popular())
        @php($products = $popular_products->getPopular())
        
        @foreach($products as $product)
        @if($product->product == null)
        @continue
        @endif
        <div class="item item-carousel">
            <div class="products">

                <div class="product">		
                    <div class="product-image">
                        <div class="image">
                            <a href="{{url('shop/product/detail/'.$product->product_id)}}">
                                <img src="{{url('assets/images/products/'.$product->product->getDefaultImage()->image_url)}}" alt="">
                            </a>
                        </div><!-- /.image -->			

                        <div class="tag new">
                            <span>new</span>
                        </div>                        		   
                    </div><!-- /.product-image -->


                    <div class="product-info text-left">
                        <h3 class="name">
                            <a href="{{url('shop/product/detail/'.$product->product_id)}}">{{$product->product->name}}</a>
                        </h3>
                        <div class="rating rateit-small"></div>
                        <div class="description"></div>

                        <div class="product-price">	
                            <span class="price">
                                Ksh {{$product->product->getActivePrice()->offer_price}}				
                            </span>
                            <span class="price-before-discount">Ksh {{$product->product->getActivePrice()->standard_price}}</span>
                            
                        </div><!-- /.product-price -->

                    </div><!-- /.product-info -->
                    
                    <div class="cart clearfix animate-effect">
                        <div class="action">
                            
                            <ul class="list-unstyled">
                                <li class="add-cart-button btn-group">
                                    <form method="POST" action="{{url('shop/add_to_cart')}}">
                                        <input type="hidden" value="{{$product->product->getActivePrice()->id}}" name="product_ref" />
                                        <input type="hidden" value="1" name="quantity" />
                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" type="submit" product_ref="{{$product->product->getActivePrice()->id}}" title="Add Cart">
                                            <i class="fa fa-shopping-cart"></i>													
                                        </button>
                                        <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                    </form>

                                </li>

                                <li class="lnk wishlist">
                                    <a class="add-to-cart" href="{{url('shop/add_to_wishlist/'.$product->product->id.'/'.$product->product->getActivePrice()->id)}}" title="Wishlist">
                                        <i class="icon fa fa-heart"></i>
                                    </a>
                                </li>

<!--                                <li class="lnk">
                                    <a data-toggle="tooltip" class="add-to-cart" href="{{url('shop/product/detail/'.$product->id)}}" title="Compare">
                                        <i class="fa fa-signal" aria-hidden="true"></i>
                                    </a>
                                </li>-->
                            </ul>
                        </div><!-- /.action -->
                    </div><!-- /.cart -->
                </div><!-- /.product -->

            </div><!-- /.products -->
        </div><!-- /.item -->
        @endforeach

        
    </div><!-- /.home-owl-carousel -->
</div><!-- /.product-slider -->