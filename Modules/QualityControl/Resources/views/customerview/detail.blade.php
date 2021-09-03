<script>

$(document).ready(function(){

   var shown_div = 0;

    $(document).on('change', '#item_size', function() {  

        var product_price_id = $(this).val();
        var product_slug = $("#product_slug").val();

        if(product_price_id == ""){return;}

        var BASE_URL = "{{url('/qc/')}}";

        window.location.replace(BASE_URL+"/customer-view/"+product_slug+"/"+product_price_id);

    })
});

</script>

@php($product_price = $product->getActivePrice())

@if(count($product_price) == 1)

<div class="detail-block">
    <div class="row  wow fadeInUp">

        <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder" id="gallery-holder">
            <div class="product-item-holder size-big single-product-gallery small-gallery">

                @php( $images = $product->getProductImages() )
                @php( $count = 0 )

                <div id="owl-single-product">

                    @foreach($images as $image)                    
                    <div class="single-product-gallery-item" id="slide{{$count}}">
                        <a data-lightbox="image-1" data-title="Gallery" href="{{url('assets/images/products/'.$image->image_url)}}">
                            <img class="img-responsive" alt="" src="{{url('assets/images/blank.gif')}}" data-echo="{{url('assets/images/products/'.$image->image_url)}}" />
                        </a>
                    </div><!-- /.single-product-gallery-item -->
                    @php( $count++)
                    @endforeach

                </div><!-- /.single-product-slider -->

                <div class="single-product-gallery-thumbs gallery-thumbs">

                    @php( $count = 0 )
                    <div id="owl-single-product-thumbnails">
                        @foreach($images as $image)
                        <div class="item">
                            <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="{{$count}}" href="#slide{{$count}}">
                                <img class="img-responsive" width="85" alt="" src="{{url('assets/images/blank.gif')}}" data-echo="{{url('assets/images/products/'.$image->image_url)}}" />
                            </a>
                        </div>
                        @php( $count++)
                        @endforeach

                    </div><!-- /#owl-single-product-thumbnails -->

                </div><!-- /.gallery-thumbs -->

            </div><!-- /.single-product-gallery -->
        </div><!-- /.gallery-holder --> 
             			
        <div class='col-sm-6 col-md-7 product-info-block'>
            <div class="product-info">

                <h1 class="name">{{$product->name}}</h1>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Product Code:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    {{ ($product->product_code != null)?strtoupper($product->product_code):"Unavailable" }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="rating-reviews m-t-20">
                    <div class="row">
                        <div class="col-sm-3">
<!--                        <div class="rating rateit-small"></div>-->
                            @php($reviews = $product->getProductReviews())
                            @php($count = count($reviews))
                            Average Rating
                            @if($count > 0)
                            @php($average_rating = round($reviews->sum('rating')/$count))
                            @for($i = 0; $i < $average_rating; $i++)
                            <img src="{{url('assets/images/star-on.png')}}"/>
                            @endfor
                            @endif
                        </div>
                        <div class="col-sm-8">
                            <div class="reviews">                                                            
                                <!--<a href="#" class="lnk">-->
                                ({{$count }} @if($count > 1) Reviews @else Review @endif <span style="color:#FFA200"> - scroll down to view the specific reviews</span>)
                                <!--</a>-->
                            </div>
                        </div>
                    </div><!-- /.row -->		
                </div><!-- /.rating-reviews -->

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Seller:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    {{ ($product->seller != null)?ucwords(strtolower($product->seller->name)):"Not Specified" }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Availability :</span>
                            </div>	
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value">

                                    @if($product->isAvailable())
                                    In Stock
                                    @else
                                    Out of Stock
                                    @endif
                                </span>
                            </div>	
                        </div>
                    </div><!-- /.row -->	
                </div><!-- /.stock-container -->

                <div class="price-container info-container m-t-20">
                    <div class="row" id="price_stuff">
                        
                        <div class="col-sm-6">

                            @if($product_price->first() != null)
                            @php($offer_price = $product_price->first()->offer_price)
                            @php($standard_price = $product_price->first()->standard_price)
                            @php($sale_price = 0)
                            <div class="price-box">
                                
                                <span class="price">
                                @if($offer_price != null && $offer_price != "")
                                Ksh {{ number_format($offer_price) }}
                                @php($sale_price = $offer_price)
                                </span>
                                <span class="price-strike">
                                    KSh {{ number_format($standard_price) }}
                                    @php($sale_price = $standard_price)
                                </span> 
                                @else 
                                <span class="price">
                                Ksh {{ number_format($standard_price) }}
                                @php($sale_price = $standard_price)
                                @endif      
                                </span>
                                <input type="hidden" value="{{$product->id}}" id="product_ref" />
                            </div>
                            @endif 
                        </div>

                        <div class="col-sm-6">
                            <div class="favorite-button m-t-10">
                                <a class="btn btn-primary" href="{{url('shop/add_to_wishlist/'.$product->id.'/'. $product_price->first()->id)}}" title="Add to Wishlist">
                                    <i class="icon fa fa-heart"></i>
                                </a>
                            </div>
                        </div>

                    </div><!-- /.row -->
                    @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))
                    <div class="eligible-shipping">
                        {{ $shipping_message }}
                    </div>
                </div><!-- /.price-container -->
                 
                    <form method="POST" action="{{url('shop/add_to_cart')}}">
                        <div class="quantity-container info-container">
                            <div class="row">

                                <div class="col-sm-2">
                                    <span class="label">Qty :</span>
                                </div>

                                <div class="col-sm-2">
                                    <div class="cart-quantity">
                                        <div class="quant-input">
                                            <div class="arrows">
                                                <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                            </div>
                                            <input type="text" name="quantity" value="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7">
                                    
                                    <input type="hidden" value="{{$product_price->first()->id}}" name="product_ref" />
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                    </button>
                                    
                                </div>

                            </div><!-- /.row -->
                        </div><!-- /.quantity-container -->
                    </form>

                <div class="description-container m-t-20">
                    <h3>Key  Features</h3>
                    <ul type="disc">
                                               
                        @if(count($product->product_features) > 0)
                        @foreach($product->product_features as $feature)
                        <li> 

                         @if($feature->feature_type_id == 0)
                           {{$feature->value}}
                         @else
                          <strong> {{$feature->feature_type!= null?ucwords($feature->feature_type->name):'General' }}: </strong> {{$feature->value}} 
                         @endif
                         @endforeach
                         @endif
                    </ul>
                </div><!-- /.description-container -->

            </div><!-- /.product-info -->
        </div><!-- /.col-sm-7 -->
    </div><!-- /.row -->
</div>

@elseif(count($product_price) > 1)
@php( $prices = clone $product_price )
<div class="detail-block" id="multiple_prices">
    <div class="row  wow fadeInUp">

        <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder" id="gallery-holder">
            <div class="product-item-holder size-big single-product-gallery small-gallery">

                @php( $images = $product->getProductImages() )
                @php( $count = 0 )

                <div id="owl-single-product">

                    @foreach($images as $image)                    
                    <div class="single-product-gallery-item" id="slide{{$count}}">
                        <a data-lightbox="image-1" data-title="Gallery" href="{{url('assets/images/products/'.$image->image_url)}}">
                            <img class="img-responsive" alt="" src="{{url('assets/images/blank.gif')}}" data-echo="{{url('assets/images/products/'.$image->image_url)}}" />
                        </a>
                    </div><!-- /.single-product-gallery-item -->
                    @php( $count++)
                    @endforeach

                </div><!-- /.single-product-slider -->


                <div class="single-product-gallery-thumbs gallery-thumbs">

                    @php( $count = 0 )
                    <div id="owl-single-product-thumbnails">
                        @foreach($images as $image)
                        <div class="item">
                            <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="{{$count}}" href="#slide{{$count}}">
                                <img class="img-responsive" width="85" alt="" src="{{url('assets/images/blank.gif')}}" data-echo="{{url('assets/images/products/'.$image->image_url)}}" />
                            </a>
                        </div>
                        @php( $count++)
                        @endforeach

                    </div><!-- /#owl-single-product-thumbnails -->

                </div><!-- /.gallery-thumbs -->

            </div><!-- /.single-product-gallery -->
        </div><!-- /.gallery-holder -->                 
        <div class='col-sm-6 col-md-7 product-info-block'>
            <div class="product-info">
                <h1 class="name">{{$product->name}}</h1>

                <div class="rating-reviews m-t-20">
                    <div class="row">
                        <div class="col-sm-3">
<!--                            <div class="rating rateit-small"></div>-->
                                @php($reviews = $product->getProductReviews())
                                @php($count = count($reviews))
                                Average Rating
                                @if($count > 0)
                                @php($average_rating = round($reviews->sum('rating')/$count))
                                @for($i = 0; $i < $average_rating; $i++)
                                <img src="{{url('assets/images/star-on.png')}}"/>
                                @endfor
                                @endif
                        </div>
                        <div class="col-sm-8">
                            <div class="reviews">                                                            
                                <!--<a href="#" class="lnk">-->
                                ({{$count }} @if($count > 1) Reviews @else Review @endif <span style="color:#FFA200"> - scroll down to view the specific reviews</span>)
                                <!--</a>-->
                            </div>
                        </div>
                    </div><!-- /.row -->        
                </div><!-- /.rating-reviews -->

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Seller:</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value" style="color: #ccc;">
                                    {{ ($product->seller != null)?ucwords(strtolower($product->seller->name)):"Not Specified" }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stock-container info-container m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="stock-box">
                                <span class="label">Availability :</span>
                            </div>  
                        </div>
                        <div class="col-sm-9">
                            <div class="stock-box" id="stock-box-value">
                                <span class="value">

                                    @if($product->isAvailable())
                                    In Stock
                                    @else
                                    Out of Stock
                                    @endif
                                </span>
                            </div>  
                        </div>
                    </div><!-- /.row -->    
                </div><!-- /.stock-container -->

                <div class="price-container info-container m-t-20">
                    <div class="row" id="price_stuff">
                        <input type="hidden" id="product_slug" name="product_slug" value="{{$product->slug}}" />
                        @php($max_price = $product->getMaximumPrice())
                        @php($min_price = $product->getMinimumPrice())

                        <div class="col-sm-6">
                            <div class="price-box">
                                
                                <span class="price">

                                    @if($max_price != $min_price)
                                    KSh {{ number_format($min_price) }} - KSh {{ number_format($max_price) }}
                                    @else
                                    KSh {{ number_format($min_price) }}
                                    @endif
                                    @php($sale_price = $max_price)
                                </span>

                            </div>

                        </div>

                    </div><!-- /.row -->
                    @php( $shipping_message = \Modules\Customer\Utilities\Utilities::getSpecialShippingMessage($sale_price))
                    <div class="eligible-shipping">
                        {{ $shipping_message }}
                    </div>
                    </div><!-- /.price-container -->

                    <div class="quantity-container info-container">
                        <div class="row">

                            <div class="col-sm-2">
                                <span class="label">Size / Color:</span>
                            </div>
                            <div class="col-sm-7">
                                
                                <style>
                                    
                                    select {
                                        display: block;
                                        width: 100%;
                                        height: 34px;
                                        padding: 6px 12px;
                                        font-size: 14px;
                                        line-height: 1.42857143;
                                        color: #555;
                                        background-color: #fff;
                                        background-image: none;
                                        border: 1px solid #ccc;
                                        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                                    }

                                </style>
                                <div class="col-sm-10" style="padding: 0px;">
                                    <select id="item_size" name="item_size">
                                        <option value="">Select Size / Color</option>
                                        @foreach($product_price as $price)
                                        @php($combination = "")
                                        @if($price->size != null && $price->color == null)
                                            $combination = $price->size; 
                                            <option value="{{$price->id}}">{{$price->size}}</option>
                                        @elseif($price->size == null && $price->color != null)
                                            $combination = $price->color; 
                                            <option value="{{$price->id}}">{{$price->color}}</option>
                                        @elseif($price->size != null && $price->color != null)
                                            $combination = $price->size."/".$price->color; 
                                            <option value="{{$price->id}}">{{$price->size}} / {{$price->color}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <div class="col-sm-2" style="padding: 0px 5px;margin-top: 2px;">
                                    <button class="btn-sm" style="background: #FFA200;border: 1px solid #FFA200;border-radius:0px;color: #fff;">Filter</button>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div id="cart-form"></div>

                <div class="description-container m-t-20">
                    <h3>Key Features</h3>
                    <ul type="disc">

                        @if(count($product->product_features) > 0)
                        @foreach($product->product_features as $feature)
                        <li> 
                        @if($feature->feature_type_id  == 0)
                           {{$feature->value}}
                        @else
                          <strong> {{$feature->feature_type!= null?ucwords($feature->feature_type->name):'General' }}: </strong> {{$feature->value}} 
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div><!-- /.description-container -->

            </div><!-- /.product-info -->
        </div><!-- /.col-sm-7 -->
    </div><!-- /.row -->
</div>

@endif