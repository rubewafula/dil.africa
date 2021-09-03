    @extends('customer::layouts.checkout_master')

    @section('content')

    <script>

        $(document).ready(function(){

            $('#city').select2();

            $('#city_pickup').select2();
            $('#country_id').select2();
            $('#zone').select2();
            $('#pickup_location').select2();

            var BASE_URL = "{{url('/shop/')}}";

            $('input[name="preferred_shippingmode"]').change(function(){
                var selected = $('input[name="preferred_shippingmode"]:checked').val();       

                if(selected == 2){

                    $("#home_delivery_div").hide();
                    $("#pickup_station_div").show(); 
                    $("#selection_message").html("You have chosen that the items will be picked \n\
                        from one of our pickup stations. If you have not set a preferred\n\
                        pickup station, please proceed to do so. If the customer wishes to \n\
                        have delivery done to a preferred location instead, choose\n\
                        'Delivery Address'");
                }else if(selected == 1){

                    $("#pickup_station_div").hide();
                    $("#home_delivery_div").show(); 
                    $("#selection_message").html("'Delivery Address' selected.\n\
                      If the customer wishes to pick up from one of our pick\n\
                      up stations instead, choose 'Pickup Station'");
                }
                var filedata = new FormData();

                filedata.append('delivery_type', selected);
                $.ajax({
                    url: BASE_URL + "/delivery-type",
                    data: filedata,
                    cache: false,
                processData: false, // Don't process the files
                contentType: false,
                type: 'post',
                success: function (output) {

                    if (output.status == '200') {                   

                    }else {}
                }
            });
            });


            $("#city_pickup").change(function(){

                var city_id = $(this).val();
                var filedata = new FormData();

                filedata.append('city', city_id);
                $.ajax({
                    url: BASE_URL + "/pickup-points",
                    data: filedata,
                    cache: false,
                processData: false, // Don't process the files
                contentType: false,
                type: 'post',
                success: function (output) {

                    if (output.status == '200') {

                        $("#pickup_location").html(output.html);                              
                    }
                }
            });

            });

        });
    </script>

    <style type="text/css">

    input[type=text] {

        border: 1px solid #aaa;
    }

    .select2-container--default .select2-selection--single {
        height: 35px;
    }

</style>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class='active'><a href="{{url('shop/checkout')}}">Checkout</a></li>
                <li class='active'><a href="{{url('shop/checkout/agent/delivery')}}">Address</a></li>
                <li class='active'><a href="{{url('shop/checkout/payment')}}">Payment</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<style>
.info-title {
    font-family: 'Open Sans', sans-serif, sans-serif;
    font-weight: normal;
    margin-bottom: 5px;
    font-size: 13px;
}
</style>

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">

            <div class="panel panel-default" style="padding: 10px;">
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" name="preferred_shippingmode" value="1" checked="true">Delivery Address &nbsp;&nbsp; 
                        <input type="radio" name="preferred_shippingmode" value="2">Pickup Station 
                    </div>
                    <div class="col-md-8">
                        <span id="selection_message" style="line-height: 1.8em;color: #ffa200;"></span>
                    </div>
                </div>
            </div>
            <div class="row" id="home_delivery_div">
                <div class="col-md-12">
                    <div class="panel-group checkout-steps" id="accordion" >
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01" style="padding: 10px 20px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne-">
                                        <span>1</span>Delivery Address Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body" style="background: #f5f5f5;padding: 7px 20px">

                                    <div class="row">

                                        <div class="col-md-8 col-sm-12 col-xs-12" style="background: #fff;padding: 10px;margin-bottom: 10px;">

                                            <form class="address-form" role="form" method="POST" action="{{url('shop/checkout/agent/save-address')}}">
                                                <input type="hidden" name="user_id" value="{{$userId}}"/>
                                                <input type="hidden" name="user_address_id" value="{{isset($user_address)?$user_address->id:""}}"/>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                        <div class="form-group">
                                                            <label class="info-title" for="customer_email">Customer's Email Address <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" 
                                                            id="customer_email" name="customer_email" placeholder=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                        <div class="form-group">
                                                            <label class="info-title" for="first_name">Customer's First Name <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" 
                                                            id="first_name" name="first_name" placeholder="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                        <div class="form-group">
                                                            <label class="info-title" for="last_name">Customer's Last Name <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" 
                                                            id="last_name" name="last_name" placeholder="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                        <div class="form-group">
                                                            <label class="info-title" for="telephone">Customer's/Your Phone Number <span>*</span></label>
                                                            @php($phone = "")
                                                            @if(isset($user_address))
                                                            @if($user_address->telephone != null)
                                                            @php($phone = $user_address->telephone)
                                                            @elseif(isset($user))
                                                            @if($user->phone != null)
                                                            @php($phone = $user->phone)
                                                            @endif
                                                            @endif
                                                            @elseif(isset($user))
                                                            @if($user->phone != null)
                                                            @php($phone = $user->phone)
                                                            @endif
                                                            @endif
                                                            <input type="text" class="form-control unicase-form-control text-input" 
                                                            id="telephone" name="telephone" placeholder="" value="{{$phone}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">
                                                        <div class="form-group">
                                                            <label class="info-title" for="city">City / Town </label>
                                                            @php($cities =  \Modules\Customer\Entities\City::pluck('name', 'id'))

                                                            {!! Form::select('city_id', $cities, isset($user_address)?$user_address->city_id:null, ['class' => 'form-control unicase-form-control text-input city-select', 
                                                            'id'=>'city', 'placeholder'=>'', 'required' => 'required']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 already-registered-login">
                                                        <div class="form-group">
                                                            <label class="info-title" for="area">Area <span></span></label>
                                                            @php($area_id = isset($user_address)?$user_address->google_area:"")
                                                            @php($areas = \Modules\Customer\Entities\Area::pluck('name', 'id'))

                                                            {!! Form::text('google_area', isset($user_address)?$user_address->google_area:null, ['class' => 'form-control unicase-form-control text-input area-select', 
                                                            'id'=>'area', 'placeholder'=>'', 'required' => 'required']) !!}
                                                        </div>
                                                    </div>

                                                    <style type="text/css">

                                                    #delivery_address {

                                                        border-style: inset;
                                                        overflow: auto;
                                                        outline: none;
                                                        border: 1px solid #aaa;
                                                        -webkit-box-shadow: none;
                                                        -moz-box-shadow: none;
                                                        box-shadow: none;
                                                        resize: none;
                                                    }
                                                </style>
                                                <div class="row">

                                                    <div class="col-md-12 col-sm-12 already-registered-login">
                                                        <div class="form-group" style="margin: 0px 15px 0px 15px;">
                                                            <label class="info-title" for="address_info">Delivery Address <span></span></label>
                                                            <textarea id="delivery_address" class="form-control unicase-form-control text-input" rows="4"  
                                                            name="delivery_address" placeholder="Street Name/Building/Apartment No./Floor">{{isset($user_address)?$user_address->delivery_address:""}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12 col-sm-12 already-registered-login" style="margin-left: 15px;">
                                                        @php($address_id = isset($user_address)?$user_address->id:"0")

                                                        @php($cart = Session::get('cart'))

                                                        @if($cart != null)
                                                        @if(count($cart) > 0)
                                                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" style="background: #ffa200;">Proceed to Payment Options</button>
                                                        @else
                                                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" >Save Address Information</button>
                                                        @endif
                                                        @else
                                                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button" >Save Address Information</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- already-registered-login -->	

                                        </div>

                                    </div>

                                    @php($cart_items = Session::get('cart_items'))
                                    @php($no_of_items = count($cart_items))

                                    <div class="col-md-4 animate-dropdown hidden-sm hidden-xs" style="line-height: 1.8em;">

                                        <div style="background: #fff;padding: 10px;">

                                            @if(count($cart_items) > 0)
                                            <div style="border-bottom: 1px solid #ddd;font-weight: bold;font-size: 14px;padding: 2px;">
                                                CUSTOMER'S ORDER ({{$no_of_items}} @if($no_of_items == 1) item @else items @endif)
                                            </div>
                                            @php($subtotal = 0)
                                            @foreach($cart_items as $item)    
                                            @php($product_id = \Modules\Customer\Entities\Product_price::find($item->getProductPriceId())->product_id)
                                            @php($slug = \Modules\Customer\Entities\Product::find($product_id)->slug)
                                            <div class="cart-item product-summary">
                                                <input type="hidden" class="product_id_class" value="{{$item->getProductPriceId()}}"/>
                                                <div class="row" style="padding-top: 10px;">
                                                    <div class="col-xs-3 col-sm-3">
                                                        <div class="image">
                                                            <img src="{{url('assets/images/products/'.$item->getProductImage())}}" width="80px" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-9 col-sm-9" style="padding-top: 5px;">

                                                        <div class="">

                                                            <span style="font-weight: bold;">{{$item->getProductName()}} </span>

                                                            <div class="price">
                                                                Quantity: {{$item->getQuantity()}}
                                                            </div>
                                                            <div class="price" style="color: #ffa200;">
                                                                KSh. {{number_format($item->getUnitPrice())}}
                                                            </div>
                                                            <div class="price" style="color: #0f7dc2;">
                                                                Total Price: <span style="font-weight: bold;">KSh. {{number_format($item->getSubtotal())}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.cart-item -->
                                            @php($subtotal += $item->getSubtotal())
                                            <div style="border-bottom: 1px solid #ddd;margin:5px 0px 15px 0px;"></div>
                                            @endforeach
                                            <div style="padding: 0px 15px;font-size: 14px;line-height: 1.8em;">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 cart-item product-summary">
                                                        Subtotal
                                                    </div>
                                                    @php($sub_t = $item->getSubtotal())
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="price" style="text-align: right;"> KSh. {{number_format($subtotal)}}</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 cart-item product-summary">
                                                        VAT
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="price" style="text-align: right;"> KSh. 0</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 cart-item product-summary" style="font-weight: bold;"> 
                                                        Total
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="price" style="text-align: right;color: #ffa200;font-size: 16px;"> KSh. {{number_format($subtotal)}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>  
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-12" style="padding: 0px;">
                                        <div class="panel panel-default">
                                            <div class="panel-body"  style="border: 1px solid #ddd;">

                                                <div class="row" style="padding-top: 15px;line-height: 1.8em;background: #f5f5f5;margin: 0px;">

                                                    <div class="col-md-8 col-sm-8">  
                                                        Customer's Addresses
                                                    </div>
                                                    <div class="col-md-4 col-sm-4">
                                                        {!! Form::open(['method' => 'GET', 'url' => '/shop/delivery', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin-top:0px;'])  !!}
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="search" placeholder="Search...">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="submit">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>

                                                @if(isset($addresses))
                                                @if(count($addresses)  > 0)
                                                <div class="row" style="background:#ddd;color:#337AB7;padding: 10px 0px;margin: 0px;font-weight: bold;">
                                                    <div class="col-md-2 col-xs-12 col-sm-12">Building</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">Floor</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">Street</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">Area</div>
                                                    <div class="col-md-1 col-xs-12 col-sm-12">City</div>
                                                    <div class="col-md-1 col-xs-12 col-sm-12">Country</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12"></div>                    
                                                </div>

                                                @foreach($addresses as $address)

                                                <div class="row" style="background:#fff;padding: 10px 0px;">
                                                    <div class="col-md-2 col-xs-12 col-sm-12">{{$address->building}}</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">{{$address->floor}}</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">{{$address->street}}</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">{{($address->area != null)?$address->area->name:""}}</div>
                                                    <div class="col-md-1 col-xs-12 col-sm-12">{{($address->city != null)?$address->city->name:""}}</div>
                                                    <div class="col-md-1 col-xs-12 col-sm-12">{{($address->country != null)?$address->country->name:""}}</div>
                                                    <div class="col-md-2 col-xs-12 col-sm-12">

                                                        @if($address->default != 1)
                                                        <form method="POST" action="{{url('shop/address/makedefault')}}">

                                                            <input type="hidden" value="{{$address->id}}" name="address" />
                                                            <button data-toggle="tooltip" class="btn btn-primary" type="submit" title="Make Default Address">
                                                                Make Default                                                
                                                            </button>
                                                        </form>
                                                        @else 
                                                        <span style="color: #F89530;font-weight: bold;">Default Address</span>
                                                        @endif
                                                    </div>                    
                                                </div>

                                                @endforeach
                                                @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.row -->
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                    <!-- checkout-step-01  -->

                </div><!-- /.checkout-steps -->
            </div>

        </div><!-- /.row -->

        <style type="text/css">

        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="row" id="pickup_station_div">
        <div class="col-md-12">
            <div class="panel-group checkout-steps" id="accordion">
                <!-- checkout-step-01  -->
                <div class="panel panel-default checkout-step-01">

                    <!-- panel-heading -->
                    <div class="panel-heading">
                        <h4 class="unicase-checkout-title">
                            <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOneggg">
                                <span>1</span>Pick up Station
                            </a>
                        </h4>
                    </div>
                    <!-- panel-heading -->

                    <div id="collapseOne" class="panel-collapse collapse in">

                        <!-- panel-body  -->
                        <div class="panel-body">
                            <div class="row">	

                                <div class="col-md-8 col-sm-12 col-xs-12" style="background: #fff;padding: 10px;margin-bottom: 10px;">	
                                    <form class="address-form" role="form" method="POST" action="{{url('shop/checkout/agent/save-pickup-station')}}">
                                        <input type="hidden" name="user_pickuplocation_id" value="{{isset($user_pickuplocation)?$user_pickuplocation->id:""}}"/>
                                        <input type="hidden" name="user_id" value="{{$userId}}"/>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                <div class="form-group">
                                                    <label class="info-title" for="customer_email">Customer's Email Address <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" 
                                                     name="customer_email" placeholder=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                <div class="form-group">
                                                    <label class="info-title" for="first_name">Customer's First Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" 
                                                     name="first_name" placeholder="" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 already-registered-login">                                                                                     
                                                <div class="form-group">
                                                    <label class="info-title" for="last_name">Customer's Last Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" 
                                                     name="last_name" placeholder="" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="city">City / Town <span class="astk">*</span></label>

                                                    {!! Form::select('city', $cities, isset($user_pickuplocation)?$user_pickuplocation->warehouse->area->zone->city->id:null, ['class' => 'form-control unicase-form-control text-input city-select', 
                                                    'id'=>'city_pickup', 'placeholder'=>'', 'required' => 'required']) !!}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="street">Pickup Station <span class="astk">*</span></label>
                                                    @php($pickup_location_id = isset($user_pickuplocation)?$user_pickuplocation->id:0)

                                                    @php($pickup_locations = \Modules\Customer\Entities\Warehouse::join('cities', 'warehouses.city_id', '=', 
                                                    'cities.id')->select(DB::raw("CONCAT(CamelCase(warehouses.name),' (', UCASE(cities.name), ')' ) AS name"), 'warehouses.id')->where('is_pickup_location', 1)->pluck('name', 'id'))

                                                    {!! Form::select('pickup_location', $pickup_locations, isset($user_pickuplocation)?$user_pickuplocation->id:null, ['class' => 'form-control unicase-form-control text-input', 
                                                    'id'=>'pickup_location', 'placeholder'=>'', 'required' => 'required']) !!}
                                                </div>                 
                                            </div>
                                        </div> 

                                        <div class="row">

                                            <div class="col-md-4 col-sm-6 already-registered-login payment-thing">
                                             @if(count($cart_items) > 0)

                                             <button type="submit" class="btn-upper btn btn-primary checkout-page-button" style="margin-bottom: 25px;background: #ffa200;">Proceed to Payment Options</button>

                                             @else
                                             <button type="submit" class="btn-upper btn btn-primary checkout-page-button" style="margin-bottom: 25px;">Update Pickup Station Details</button>
                                             @endif

                                         </div>
                                     </div>
                                 </form>
                                 <!-- already-registered-login -->	

                             </div>

                             <div class="col-md-4 animate-dropdown hidden-sm hidden-xs" style="line-height: 1.8em;">

                                <div style="background: #fff;padding: 10px;">

                                    @if(count($cart_items) > 0)
                                    <div style="border-bottom: 1px solid #ddd;font-weight: bold;font-size: 14px;padding: 2px;">
                                        CUSTOMER'S ORDER ({{$no_of_items}} @if($no_of_items == 1) item @else items @endif)
                                    </div>
                                    @php($subtotal = 0)
                                    @foreach($cart_items as $item)    
                                    @php($product_id = \Modules\Customer\Entities\Product_price::find($item->getProductPriceId())->product_id)
                                    @php($slug = \Modules\Customer\Entities\Product::find($product_id)->slug)
                                    <div class="cart-item product-summary">
                                        <input type="hidden" class="product_id_class" value="{{$item->getProductPriceId()}}"/>
                                        <div class="row" style="padding-top: 10px;">
                                            <div class="col-xs-3 col-sm-3">
                                                <div class="image">
                                                    <img src="{{url('assets/images/products/'.$item->getProductImage())}}" width="80px" alt="">
                                                </div>
                                            </div>
                                            <div class="col-xs-9 col-sm-9" style="padding-top: 5px;">

                                                <div class="">

                                                    <span style="font-weight: bold;">{{$item->getProductName()}} </span>

                                                    <div class="price">
                                                        Quantity: {{$item->getQuantity()}}
                                                    </div>
                                                    <div class="price" style="color: #ffa200;">
                                                        KSh. {{number_format($item->getUnitPrice())}}
                                                    </div>
                                                    <div class="price" style="color: #0f7dc2;">
                                                        Total Price: <span style="font-weight: bold;">KSh. {{number_format($item->getSubtotal())}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.cart-item -->
                                    @php($subtotal += $item->getSubtotal())
                                    <div style="border-bottom: 1px solid #ddd;margin:5px 0px 15px 0px;"></div>
                                    @endforeach
                                    <div style="padding: 0px 15px;font-size: 14px;line-height: 1.8em;">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 cart-item product-summary">
                                                Subtotal
                                            </div>
                                            @php($sub_t = $item->getSubtotal())
                                            <div class="col-md-6 col-sm-6">
                                                <div class="price" style="text-align: right;"> KSh. {{number_format($subtotal)}}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 cart-item product-summary">
                                                VAT
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="price" style="text-align: right;"> KSh. 0</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 cart-item product-summary" style="font-weight: bold;"> 
                                                Total
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="price" style="text-align: right;color: #ffa200;font-size: 16px;"> KSh. {{number_format($subtotal)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>  
                            </div>	

                        </div>

                        <div class="row" style="margin: 0px -30px;">

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <div class="row" style="padding-top: 15px;line-height: 1.8em;background: #f5f5f5;margin: 0px;">

                                            <div class="col-md-8 col-sm-8">  
                                                Customer's Pick Up Stations
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                {!! Form::open(['method' => 'GET', 'url' => '/shop/delivery/stations', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin-top:0px;'])  !!}
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="search" placeholder="Search...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                        @if(isset($stations))
                                        <div id="stations_table" class="row hidden-xs" style="background:#ddd;color:#337AB7;padding: 10px 0px;font-weight: bold;">
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Pickup Station</div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Area</div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Zone</div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">City</div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Country</div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding"></div>                    
                                        </div>

                                        @foreach($stations as $station)

                                        <div class="row" style="background:#fff;padding: 10px 0px;border-bottom: 1px solid #ddd;">
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                <span class="hidden-lg hidden-md blue-text"> Pickup Station: </span>{{$station->warehouse->name}}
                                            </div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                <span class="hidden-lg hidden-md blue-text"> Area: </span>{{($station->warehouse->area_id != null)?$station->warehouse->area->name:""}}
                                            </div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                <span class="hidden-lg hidden-md blue-text"> Zone: </span> {{($station->warehouse->area_id != null)?$station->warehouse->area->zone->name:""}}
                                            </div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                <span class="hidden-lg hidden-md blue-text"> City: </span> {{($station->warehouse->area_id != null)?$station->warehouse->area->zone->city->name:""}}
                                            </div>
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                <span class="hidden-lg hidden-md blue-text"> Country: </span> {{($station->warehouse->area_id != null)?$station->warehouse->area->zone->city->country->name:""}}
                                            </div> 
                                            <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                                @if($station->default != 1)
                                                <form method="POST" action="{{url('shop/station/makedefault')}}">

                                                    <input type="hidden" value="{{$station->id}}" name="address" />
                                                    <button data-toggle="tooltip" class="btn btn-primary" type="submit" title="Make Default Pickup Point">
                                                        Make Default                                                
                                                    </button>
                                                </form>
                                                @else 
                                                <span style="color: #F89530;font-weight: bold;">Default Pickup Point</span>
                                                @endif
                                            </div>                
                                        </div>

                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.row -->
                    </div>
                    <!-- panel-body  -->

                </div><!-- row -->
            </div>
            <!-- checkout-step-01  -->

        </div><!-- /.checkout-steps -->
    </div>

</div><!-- /.row -->
</div><!-- /.checkout-box -->

</div><!-- /.container -->
</div><!-- /.body-content -->
@stop