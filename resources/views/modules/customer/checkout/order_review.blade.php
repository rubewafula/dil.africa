    @extends('customer::layouts.checkout_master')

    @section('content')

    <div class="breadcrumb" style="margin: 5px 0px;">
        <div class="container">
            <div class="col-md-8">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li class='active'><a href="{{url('shop/checkout')}}">Checkout</a></li>
                        <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
                        <li class='active'><a href="{{url('shop/checkout/payment')}}">Payment</a></li>
                    </ul>
                </div><!-- /.breadcrumb-inner -->
            </div>
            <div class="col-md-4" style="text-align: right;padding-right: 0px;">

                @if($payment_option == "IPAY")

                <?php

                $user = Auth::user();

                if($user == null){

                    $userId = Session::get('userId');

                    if($userId != null){ $user = \Modules\Customer\Entities\User::find($userId); }

                    if($user == null){

                        Session::flash('alert-class', 'alert-danger');
                        Session::flash('flash_message', 'Please login in order to checkout successfully');

                        echo "<script>location.href='".url('/checkout/payment')."</script>";
                    }
                    
                }

                $mpesa = 0;
                $live = 1;
                $oid = $order_id;
                $inv = $order_id;
                $ttl = $order_value + $shipping_cost;

                if($user->phone == null){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('flash_message', 'Please update your mobile number first in order to proceed.');

                    echo "<script>location.href='".url('/checkout/delivery')."</script>";
                }

                $tel = \Modules\Customer\Utilities\Utilities::prepareMSISDN($user->phone);
                $eml = $user->email;
                $vid = "dayibson";
                $curr = "KES";
                $p1 = $order_id;
                $p2 = "";
                $p3 = "";
                $p4 = "";
                $cbk = "https://dil.africa/shop/ipay/callback";
                $cst = 1;
                $crl = 0;

                $fields = array("live"=> $live,
                        "mpesa"=> $mpesa,
                        "oid"=> $oid,
                        "inv"=> $inv,
                        "ttl"=> $ttl,
                        "tel"=> $tel,
                        "eml"=> $eml,
                        "vid"=> $vid,
                        "curr"=> $curr,
                        "p1"=> $p1,
                        "p2"=> $p2,
                        "p3"=> $p3,
                        "p4"=> $p4,
                        "cbk"=> $cbk,
                        "cst"=> $cst,
                        "crl"=> $crl
                    );

                $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
                $hashkey ="Day10NvtM47DX";

                $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

                ?>

                <form method="post" action="https://payments.ipayafrica.com/v3/ke">

                    <?php 
                     foreach ($fields as $key => $value) {
                         echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
                     }
                    ?>
                    <input name="hsh" type="hidden" value="<?php echo $generated_hash ?>" >

                    <button type="submit" class="btn-upper btn btn-success" style="background:#FFA200;border: none;">Click to Complete your Order</button>
                    </form>
                @else
                <form method="POST" action="{{url('shop/checkout/complete-transaction')}}">
                    <input type="hidden" name="payment_option" value="{{$payment_option}}"/>
                    <input type="hidden" name="user_address_id" value="{{$user_address_id}}"/>
                    <input type="hidden" name="order_value" value="{{$order_value}}"/>
                    <input type="hidden" name="products_value" value="{{$products_value}}"/>
                    <input type="hidden" name="shipping_cost" value="{{$shipping_cost}}"/>
                    <input type="hidden" name="dil_shipping" value="{{$dil_shipping}}"/>
                    <input type="hidden" name="delivery_type" value="{{$delivery_type}}"/>
                    <input type="hidden" name="userId" value="{{$userId}}"/>
                    <button type="submit" class="btn-upper btn btn-success" style="background:#FFA200;border: none;">Click to Complete your Order</button>
                </form>
                @endif
            </div>
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="checkout-box ">

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="panel-group checkout-steps">

                            <div class="panel panel-default checkout-step-01" style="padding: 10px;">

                                <!-- panel-heading -->
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                            <span>1</span>Order Details
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapseOne" class="panel-collapse collapse in">

                                    <!-- panel-body  -->
                                    <div class="panel-body">
                                        <div class="row  wow fadeInUp">

                                            <div class='col-sm-12 col-md-12 product-info-block'>
                                                <div class="row">
                                                    @php($cart_items = Session::get('cart_items'))
                                                </div>
                                                <ul>
                                                    <li>
                                                        @if($cart_items != null)
                                                        @foreach($cart_items as $item)
                                                        <div class="cart-item product-summary">
                                                            <div class="row">
                                                                <div class="col-xs-1">
                                                                    <div class="image">
                                                                     
                                                                        <img src="{{url('assets/images/products/'.$item->getProductImage())}}" width="40px" alt="">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-5">

                                                                    <div class="product-info text-left" style="margin-bottom: 5px;color: #ccc;font-size: 10px;">
                                                                        {{$item->getSeller()}}
                                                                    </div>
                                                                    <h4 class="name" style="font-size: 13px;color: #0F7DC2;">
                                                                        {{$item->getProductName()}}
                                                                    </h4>                                                               
                                                                </div>
                                                                <div class="col-xs-2">
                                                                    <div class="price" style="font-size: 13px;"> {{$item->getQuantity()}}</div>
                                                                </div>
                                                                <div class="col-xs-2">
                                                                    <div class="price"  style="font-size: 13px;"> KSh. {{number_format($item->getUnitPrice())}}</div>
                                                                </div>
                                                                <div class="col-xs-2">
                                                                    <div class="price" style="text-align: right;font-size: 13px;"> KSh. {{number_format($item->getSubtotal())}}</div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.cart-item -->
                                                        @endforeach
                                                        @endif

                                                        <div class="clearfix"></div>
                                                        <hr>

                                                        <div class="clearfix cart-total">
                                                            <div class="row">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    <span class='price' style="font-weight: bold;color: #ffa200;font-size: 14px;">KSh. {{number_format(Session::get('order_value'))}}</span>                                           
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="font-weight: bold;font-size: 14px;">Total : </span>
                                                                </div>                                           

                                                            </div>
                                                            <div class="row" style="margin-top: 7px;">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    <span class='price' style="color: #ccc;">KSh {{number_format(Session::get('tax'))}}</span>                                           
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="color: #ccc;padding-left: 3px;">VAT : </span>
                                                                </div>                                           

                                                            </div>
                                                            @php($voucher_deducted = 0)
                                                            @php($voucher = Session::get('voucher_type'))
                                                            @if($voucher != null)
                                                            <div class="row" style="margin-top: 7px;color: #0f7dc2;">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    @if($voucher == 'AMOUNT')
                                                                    @php($voucher_deducted = Session::get('voucher_amount'))
                                                                    <span class='price'> ( KSh {{ $voucher_deducted }} )</span>
                                                                    @elseif($voucher == 'PERCENT_DISCOUNT')
                                                                    @php($percent = Session::get('voucher_percent'))
                                                                    @php($amount_to_deduct = Session::get('order_value') * ($percent/100))
                                                                    @php($voucher_deducted = $amount_to_deduct)
                                                                    <span class='price'> ( KSh {{number_format(round($amount_to_deduct,2))}} )</span>
                                                                    @else
                                                                    <span class='price'> -- </span>
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="padding-left: 3px;">Voucher : </span>
                                                                </div>                                           
                                                                
                                                            </div>
                                                            @endif
                                                            <div class="row" style="margin-top: 7px;">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    <span class='price' style="color: #ccc;">

                                                                        @if($voucher != null)
                                                                        @if($voucher == 'FREE_SHIPPING')

                                                                        Free Shipping (Voucher)
                                                                        @else
                                                                        @if(Session::get('shipping_cost') > 0)
                                                                        KSh {{number_format(Session::get('shipping_cost'))}}
                                                                        @else
                                                                        <span style="color: #FFA200;">Free of Charge</span>
                                                                        @endif
                                                                        @endif
                                                                        @else
                                                                        @if(Session::get('shipping_cost') > 0)
                                                                        KSh {{number_format(Session::get('shipping_cost'))}}
                                                                        @else
                                                                        Free of Charge
                                                                        @endif
                                                                        @endif
                                                                        
                                                                    </span>                                           
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="color: #ccc;padding-left: 3px;">Shipping : </span>
                                                                </div>                                           

                                                            </div>
                                                            @php($transaction_cost = Session::get('transaction_cost'))
                                                            @if($transaction_cost > 0)
                                                            <div class="row" style="margin-top: 7px;">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    <span class='price' style="color: #ccc;">KSh {{number_format($transaction_cost)}}</span>                                           
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="color: #ccc;padding-left: 3px;">Transaction Charges : </span>
                                                                </div>                                           

                                                            </div>
                                                            @endif
                                                            <div class="row" style="margin-top: 5px;">
                                                                <div class="col-md-2 pull-right" style="text-align: right;">
                                                                    <span class='price' style="font-weight: bold;color: #0F7DC2;font-size: 14px;">KSh. {{number_format(Session::get('order_value') + $shipping_cost + $transaction_cost - $voucher_deducted)}}</span>                                           
                                                                </div>
                                                                <div class="col-md-2 pull-right">
                                                                    <span class="text" style="font-weight: bold;font-size: 14px;color: #0F7DC2;">Grand Total : </span>
                                                                </div>                                           

                                                            </div>
                                                            <div  class="row"  style="margin-top:5 px">
                                                              <div  class="col-md-2 pull-right">

                                                                @if($payment_option == "IPAY")

                                                                <?php

                                                                $user = Auth::user();

                                                                if($user == null){

                                                                    $userId = Session::get('userId');

                                                                    if($userId != null){ $user = User::find($userId); }

                                                                    if($user == null){

                                                                        Session::flash('alert-class', 'alert-danger');
                                                                        Session::flash('flash_message', 'Please login in order to checkout successfully');

                                                                        echo "<script>location.href='".url('/checkout/payment')."</script>";
                                                                    }
                                                                    
                                                                }

                                                                $mpesa = 0;
                                                                $live = 1;
                                                                $oid = $order_id;
                                                                $inv = $order_id;
                                                                $ttl = $order_value + $shipping_cost;

                                                                if($user->phone == null){

                                                                    Session::flash('alert-class', 'alert-danger');
                                                                    Session::flash('flash_message', 'Please update your mobile number first in order to proceed.');

                                                                    echo "<script>location.href='".url('/checkout/delivery')."</script>";
                                                                }

                                                                $tel = \Modules\Customer\Utilities\Utilities::prepareMSISDN($user->phone);
                                                                $eml = $user->email;
                                                                $vid = "dayibson";
                                                                $curr = "KES";
                                                                $p1 = $order_id;
                                                                $p2 = "";
                                                                $p3 = "";
                                                                $p4 = "";
                                                                $cbk = "https://dil.africa/shop/ipay/callback";
                                                                $cst = 1;
                                                                $crl = 0;

                                                                $fields = array("live"=> $live,
                                                                        "mpesa"=> $mpesa,
                                                                        "oid"=> $oid,
                                                                        "inv"=> $inv,
                                                                        "ttl"=> $ttl,
                                                                        "tel"=> $tel,
                                                                        "eml"=> $eml,
                                                                        "vid"=> $vid,
                                                                        "curr"=> $curr,
                                                                        "p1"=> $p1,
                                                                        "p2"=> $p2,
                                                                        "p3"=> $p3,
                                                                        "p4"=> $p4,
                                                                        "cbk"=> $cbk,
                                                                        "cst"=> $cst,
                                                                        "crl"=> $crl
                                                                    );

                                                                $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
                                                                $hashkey ="Day10NvtM47DX";

                                                                $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

                                                                ?>

                                                                <form method="post" action="https://payments.ipayafrica.com/v3/ke">

                                                                    <?php 
                                                                     foreach ($fields as $key => $value) {
                                                                         echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
                                                                     }
                                                                    ?>
                                                                    <input name="hsh" type="hidden" value="<?php echo $generated_hash ?>" >

                                                                    <button type="submit" class="btn-upper btn btn-success" style="background: #FFA200;border: none;margin: 10px 0px 0px -78px;">Click to Complete your Order</button>
                                                                    </form>
                                                                @else
                                                                <form method="POST" action="{{url('shop/checkout/complete-transaction')}}">
                                                                    <input type="hidden" name="payment_option" value="{{$payment_option}}"/>
                                                                    <input type="hidden" name="user_address_id" value="{{$user_address_id}}"/>
                                                                    <input type="hidden" name="order_value" value="{{$order_value}}"/>
                                                                    <input type="hidden" name="products_value" value="{{$products_value}}"/>
                                                                    <input type="hidden" name="shipping_cost" value="{{$shipping_cost}}"/>
                                                                    <input type="hidden" name="dil_shipping" value="{{$dil_shipping}}"/>
                                                                    <input type="hidden" name="delivery_type" value="{{$delivery_type}}"/>
                                                                    <input type="hidden" name="userId" value="{{$userId}}"/>
                                                                    <button type="submit" class="btn-upper btn btn-success" style="background: #FFA200;border: none;margin: 10px 0px 0px -78px;">Click to Complete your Order</button>
                                                                </form>
                                                                @endif    
                                                            </div>

                                                        </div>
                                                        <div class="clearfix"></div>

                                                    </div><!-- /.cart-total-->                                                                                      
                                                </li>
                                            </ul><!-- /.dropdown-menu-->
                                        </div><!-- /.col-sm-7 -->
                                    </div><!-- /.row -->
                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-02" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>2</span>Personal Details
                                    </a>
                                </h4>
                            </div>

                            @php($delivery_type = Session::get('delivery_type'))

                            <!-- panel-heading -->
                            @if($delivery_type == 'pickup') 
                            @php($user_address = \Modules\Customer\Entities\User_pickup_location::findorfail($user_address_id))
                            @else
                            @php($user_address = \Modules\Customer\Entities\User_address::findorfail($user_address_id))
                            @endif
                            @if($user_address != null)
                            @php($user = \Modules\Customer\Entities\User::findorfail($user_address->user_id))
                            @else
                            @php($user = \Modules\Customer\Entities\User::findorfail($userId))
                            @endif
                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-3 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Name: <span style="font-weight: normal;"> {{$user->first_name}} {{$user->last_name}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">Phone Number: <span style="font-weight: normal;"> {{$user->phone}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">Email Address: <span style="font-weight: normal;"> {{$user->email}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-4 already-registered-login">
                                            <div class="form-group">
                                                <a href="{{url('shop/checkout/guest/update/'.$user->id)}}">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->

                        @if($delivery_type == 'home_office_delivery')
                        <div class="panel panel-default checkout-step-03" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Preferred Delivery Address
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Phone Number: <span style="font-weight: normal;"> {{$user_address->telephone}}</span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Area: <span style="font-weight: normal;"> {{ $user_address->google_area }}</span></label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">City/Town: <span style="font-weight: normal;"> {{($user_address->city != null)?$user_address->city->name:""}}</span></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="info-title">Country: <span style="font-weight: normal;"> {{ $user_address->country->name }}</span></label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Delivery Address </label><br/>
                                                <span style="font-weight: normal;"> 
                                                    {{ $user_address->delivery_address }}
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <a href="{{url('shop/checkout/delivery/update/'.$user_address->id)}}">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;padding: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>

                                        </div>

                                    </div>

                                </div>			
                            </div>                           
                            <!-- panel-body  -->
                        </div><!-- row -->
                        @elseif($delivery_type == 'pickup') 
                        @php($user_pickuplocation = \Modules\Customer\Entities\User_pickup_location::findorfail($user_address_id))
                        <div class="panel panel-default checkout-step-03" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Preferred Pickup Location
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-4 col-sm-12 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Pickup Location: <span style="font-weight: normal;"> {{$user_pickuplocation->warehouse->name}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 already-registered-login">
                                            <div class="form-group">
                                                <label class="info-title">City: <span style="font-weight: normal;"> {{$user_pickuplocation->warehouse->city->name}}</span></label>
                                            </div>
                                        </div>                     

                                    </div>

                                </div>			
                            </div>                           
                            <!-- panel-body  -->
                        </div><!-- row --> 
                        @endif
                        <div class="panel panel-default checkout-step-04" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>4</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <div class="col-md-3 col-sm-8 already-registered-login">                                           

                                            <div class="form-group">
                                                <label class="info-title">Payment Method: <span style="font-weight: normal;"> {{$payment_option}}</span></label>
                                            </div>

                                        </div>
                                        <div class="col-md-1 col-sm-4 already-registered-login">
                                            <div class="form-group">
                                                <a href="{{url('shop/checkout/payment')}}">
                                                    <button class='fa fa-pencil-square-o' style='color:#FFA200;background:#fff;border:none;margin-top: 0px;'>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                </div>

            </div><!-- /.row -->
            <div  class="row">
                <div  class="col-md-2 pull-right">
                    @if($payment_option == "IPAY")

                    <?php

                    $user = Auth::user();

                    if($user == null){

                        $userId = Session::get('userId');

                        if($userId != null){ $user = User::find($userId); }

                        if($user == null){

                            Session::flash('alert-class', 'alert-danger');
                            Session::flash('flash_message', 'Please login in order to checkout successfully');

                            echo "<script>location.href='".url('/checkout/payment')."</script>";
                        }
                        
                    }

                    $mpesa = 0;
                    $live = 1;
                    $oid = $order_id;
                    $inv = $order_id;
                    $ttl = $order_value + $shipping_cost;

                    if($user->phone == null){

                        Session::flash('alert-class', 'alert-danger');
                        Session::flash('flash_message', 'Please update your mobile number first in order to proceed.');

                        echo "<script>location.href='".url('/checkout/delivery')."</script>";
                    }

                    $tel = \Modules\Customer\Utilities\Utilities::prepareMSISDN($user->phone);
                    $eml = $user->email;
                    $vid = "dayibson";
                    $curr = "KES";
                    $p1 = $order_id;
                    $p2 = "";
                    $p3 = "";
                    $p4 = "";
                    $cbk = "https://dil.africa/shop/ipay/callback";
                    $cst = 1;
                    $crl = 0;

                    $fields = array("live"=> $live,
                            "mpesa"=> $mpesa,
                            "oid"=> $oid,
                            "inv"=> $inv,
                            "ttl"=> $ttl,
                            "tel"=> $tel,
                            "eml"=> $eml,
                            "vid"=> $vid,
                            "curr"=> $curr,
                            "p1"=> $p1,
                            "p2"=> $p2,
                            "p3"=> $p3,
                            "p4"=> $p4,
                            "cbk"=> $cbk,
                            "cst"=> $cst,
                            "crl"=> $crl
                        );

                    $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
                    $hashkey ="Day10NvtM47DX";

                    $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

                    ?>

                    <form method="post" action="https://payments.ipayafrica.com/v3/ke">

                        <?php 
                         foreach ($fields as $key => $value) {
                             echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
                         }
                        ?>
                        <input name="hsh" type="hidden" value="<?php echo $generated_hash ?>" >

                        <button type="submit" class="btn-upper btn btn-success checkout-page-button" style="background: #FFA200;border: none;margin-left: -78px;">Click to Complete your Order</button>
                        </form>
                    @else
                    <form method="POST" action="{{url('shop/checkout/complete-transaction')}}">
                        <input type="hidden" name="payment_option" value="{{$payment_option}}"/>
                        <input type="hidden" name="user_address_id" value="{{$user_address_id}}"/>
                        <input type="hidden" name="order_value" value="{{$order_value}}"/>
                        <input type="hidden" name="products_value" value="{{$products_value}}"/>
                        <input type="hidden" name="shipping_cost" value="{{$shipping_cost}}"/>
                        <input type="hidden" name="dil_shipping" value="{{$dil_shipping}}"/>
                        <input type="hidden" name="delivery_type" value="{{$delivery_type}}"/>
                        <input type="hidden" name="userId" value="{{$userId}}"/>
                        <button type="submit" class="btn-upper btn btn-success checkout-page-button" style="background: #FFA200;border: none;margin-left: -78px;">Click to Complete your Order</button>
                    </form>
                    @endif
                </div>
            </div>
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop