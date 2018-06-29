@extends('customer::layouts.master')

@section('content')

<script type="text/javascript">
    
    $(document).ready(function(){

        var BASE_URL = "{{url('/shop/')}}";

        $("#update-button").click( function() {

            var arr = new Array();

            $(".product_id_class").each(function() {              
                
                var product_id = $(this).val();
                arr.push(product_id+":"+$("#quantity_field-"+product_id).val());
            });

            var filedata = new FormData();
        
            filedata.append('data', arr);
            $.ajax({
                url: BASE_URL + "/cart/update",
                data: filedata,
                cache: false,
                processData: false, // Don't process the files
                contentType: false,
                type: 'post',
                success: function (output) {

                    if (output.status == '200') {
                        
                       window.location.replace(BASE_URL+"/cart");                              
                    }else {

                        alert("An error occured and your cart was not updated. Please try again");
                    }
                }
            });

        })
        
    });
</script>

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            @include('customer::product.sidebar.index')
            <div class='col-md-9'>
                <div class="detail-block">
                    <div class="row  wow fadeInUp">

                        <div class='col-sm-12 col-md-12 product-info-block'>
                            
                            <ul>
                                <li>
                                    <div class="row" style="margin-bottom: 20px;padding:0px 0px 15px 15px;border-bottom: 2px solid #ddd;font-weight: bold;">
                                        <div class="cart-item product-summary">
                                            <div class="col-xs-6">
                                                Product Description
                                            </div>
                                            <div class="col-xs-2" style="padding-left: 0px;">
                                                Quantity
                                            </div>
                                            <div class="col-xs-2" style="padding-left: 10px;">
                                                Unit Price
                                            </div>
                                            <div class="col-xs-2" style="text-align: right;padding-left: 10px;">
                                                Total Price
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    @if(count($cart_items) > 0)
                                    @php($count = 0)
                                    @foreach($cart_items as $item)                                  
                                    <div class="cart-item product-summary">
                                        <input type="hidden" class="product_id_class" value="{{$item->getProductPriceId()}}"/>
                                        <div class="row">
                                            <div class="col-xs-1">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="{{url('assets/images/products/'.$item->getProductImage())}}" width="50px" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xs-5">

                                                <div class="product-info text-left" style="margin-bottom: 10px;color: #ccc;">
                                                    {{$item->getSeller()}}
                                                </div>
                                                @php($product_id = \Modules\Customer\Entities\Product_price::find($item->getProductPriceId())->product_id)
                                                <h4 class="name" style="font-weight: bold;font-size: 15px;">
                                                    <a href="{{url('/shop/product/detail/'.$product_id)}}">{{$item->getProductName()}}</a>
                                                </h4>
                                                <div class="product-info text-left" style="margin-bottom: 10px;color: #ccc;">
                                                    <a href="{{url('shop/cart/remove/'.$count)}}" style="color: #FFA200;">
                                                        <i class="fa fa-trash"></i> Remove</a>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="price">
                                                    <input type="number" value="{{$item->getQuantity()}}" step="1" style="width: 60px;" id="quantity_field-{{$item->getProductPriceId()}}" class="quantity_field">
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="price"> KSh. {{number_format($item->getUnitPrice())}}</div>
                                            </div>
                                            <div class="col-xs-2">
                                                <div class="price" style="text-align: right;"> KSh. {{number_format($item->getSubtotal())}}</div>
                                            </div>
                                        </div>
                                    </div><!-- /.cart-item -->
                                    @php($count++)
                                    @endforeach
                                    
                                    <div class="clearfix"></div>
                                    <hr>

                                    <div class="clearfix cart-total" style="background: #f8f8f8;padding: 10px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button class="btn btn-upper btn-primary btn-block" style="width: 200px;" id="update-button">Update Shopping Cart</button>
                                            </div>
                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                <span class='price' style="font-weight: bold;color: #ffa200;font-size: 18px;">KSh. {{number_format($total)}}</span>                                           
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="text" style="font-weight: bold;font-size: 18px;">Total : </span>
                                            </div>                                           
                                            
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-2 pull-right" style="text-align: right;">
                                                <span class='price' style="color: #ccc;">KSh {{number_format($tax)}}</span>                                           
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <span class="text" style="color: #ccc;padding-left: 3px;">VAT : </span>
                                            </div>                                           
                                            
                                        </div>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-4 pull-right" style="text-align: right;">
                                                <span class='price' style="color: #ccc;">
                                                    Shipping fees not included yet
                                                </span>                                           
                                            </div>                                                                               
                                        </div>
                                        <div class="clearfix"></div>
                                        
                                    </div><!-- /.cart-total-->
                                    
                                    <div class="col-md-4 col-sm-4 pull-right" style="padding-right: 0px;">
                                        <a href="{{url('/shop/checkout')}}" class="btn btn-upper btn-primary btn-block m-t-20"  style="background: #FFA200;">Proceed to Checkout</a>
                                    </div>
                                    <form method="POST" action="{{url('/shop/apply-voucher')}}">
                                        <div class="col-md-2 col-sm-2 pull-right" style="padding-right: 0px;">
                                            <button class="btn btn-upper btn-primary btn-block m-t-20" style="width: 70px;">Apply</button>
                                        </div>
                                        <div class="col-md-2 col-sm-2 pull-right" style="padding-right: 0px;">                         
                                                <input type="text" class="m-t-20" style="width:120px;height: 35px;" name="voucher_no" placeholder=" Enter Voucher No." title="Enter your voucher / coupon code if you have one.."/>                                      
                                        </div>
                                    </form>
                                    
                                    <div class="col-md-3 col-sm-3" style="padding-right: 0px;">
                                        <a href="{{url('/shop')}}" class="btn btn-upper btn-primary btn-block m-t-20" style="margin-left:-15px;">Continue Shopping</a>
                                    </div>
                                    @else 
                                    <div class="col-md-8 col-sm-8" style="font-size: 16px;color: #FFA200;">
                                        You have no items in your shopping cart!
                                    </div>
                                    <div class="col-md-3 col-sm-3 pull-right" style="padding-right: 0px;">
                                        <a href="{{url('/shop')}}" class="btn btn-upper btn-primary btn-block">Continue Shopping</a>
                                    </div>
                                    @endif
                                </li>
                            </ul><!-- /.dropdown-menu-->
                        </div><!-- /.col-sm-7 -->
                    </div><!-- /.row -->
                </div>

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">

                        @include('customer::home.recommended.index')
                    </div><!-- /.scroll-tabs -->
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop