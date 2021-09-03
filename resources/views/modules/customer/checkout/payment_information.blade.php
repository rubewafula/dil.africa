@extends('customer::layouts.checkout_master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class='active'><a href="{{url('shop/checkout')}}">Checkout</a></li>
                @php($loggedUser = Auth::user())
                @if($loggedUser != null)
                @if($loggedUser->is_agent == 1)
                <li class='active'><a href="{{url('shop/checkout/agent/delivery')}}">Delivery Address Information</a></li>
                @else
                <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
                @endif
                @else
                <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
                @endif
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>3</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div class="blue-text" style="margin-top: 20px;">
                                Prepay your order to enjoy even faster delivery timeline of 3 Hours within Nairobi
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <form class="address-form" role="form" method="POST" action="{{url('shop/checkout/payment-method')}}">
                                        <input type="hidden" name="user_address_id" value="{{isset($user_address_id)?$user_address_id:""}}"/>
                                        <input type="hidden" name="userId" value="{{isset($userId)?$userId:""}}"/>
                                        <input type="hidden" name="delivery_type" value="{{Session::get('delivery_type')}}"/>
                                        <div class="row" style="margin-bottom: 15px;border-bottom: 1px solid #eee;padding-bottom: 10px;">		
                                            
                                            @if(isset($user_address))
                                            @php( $delivery_type = Session::get('delivery_type') )
                                            @php($city = "")
                                            @if($delivery_type == 'pickup')
                                            @php( $city = $user_address->warehouse->city->name )
                                            @elseif($delivery_type == 'home_office_delivery')
                                            @php($city = $user_address->city->name)
                                            @endif
                                            @php($eligible_cash = \Modules\Customer\Utilities\Utilities::isEligibleForCashPayment($city))
                                            @if($eligible_cash == 1)
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">                                           
                                                <input type="radio" id="mpesa_on_delivery" name="payment_option" value="MPESA ON DELIVERY">
                                                <label for="mpesa_on_delivery">
                                                    <img src="{{url('assets/images/cash.png')}}" width="180px" alt="Cash"/>
                                                </label>
                                            </div>
                                            @endif
                                            @endif
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">
                                                <input type="radio" id="mpesa_prepaid" name="payment_option" value="MPESA (PREPAID)">
                                                <label for="mpesa_prepaid">
                                                    <img src="{{url('assets/images/mpesa.png')}}" width="180px" alt="M-PESA Prepayment"/>
                                                </label>
                                            </div>
                                            
                                            <div class="col-md-4 col-sm-12 already-registered-login" style="padding: 10px 0px;">
                                                <input type="radio" id="ipay_radio" name="payment_option" value="IPAY">
                                                <label for="ipay_radio">
                                                    <img src="{{url('assets/images/ipay.png')}}" width="217px" 2lt="IPAY"/>
                                                </label>
                                            </div>
                                        </div>
                                        @if($eligible_cash == "not-nairobi")

                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;">
                                            Please note that payment on delivery is unavailable for this order since it is to be shipped outside Nairobi. Please prepay via M-PESA and our customer care agent will be in touch with you immediately.
                                        </div>
                                        @elseif($eligible_cash == "bulky")
                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;">
                                            Please note that payment on delivery is unavailable for this order since there is a bulky item that is included in the order. Please prepay via M-PESA and our customer care agent will be in touch with you immediately.
                                        </div>
                                        @elseif($eligible_cash == "huge-total")
                                        <div style="color:#FFA200;font-size: 14px;line-height: 1.8em;">
                                            Please note that payment on delivery is unavailable for this order as it exceeds the maximum allowable for payment on delivery <span style="font-weight: bold;color: #0F7DC2;">(KES 50,000)</span>. Please prepay via M-PESA  and our customer care agent will be in touch with you immediately.
                                        </div>
                                        @endif
                                        <button type="submit" style="margin-top: 10px;" class="btn-upper btn btn-primary checkout-page-button">Continue</button>
                                    </form>
                                </div>
                                <!-- panel-body  -->

                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height: 313px;">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                </div>
                                <div class="">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        <li><a href="{{url('shop/checkout')}}">Checkout Method</a></li>
                                        @php($loggedUser = Auth::user())
                                        @if($loggedUser != null)
                                        @if($loggedUser->is_agent == 1)
                                        <li class='active'><a href="{{url('shop/checkout/agent/delivery')}}">Delivery Address Information</a></li>
                                        @else
                                        <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
                                        @endif
                                        @else
                                        <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
                                        @endif
                                        <li><a href="{{url('shop/checkout/payment')}}">Payment Information</a></li>
                                        <li><a href="{{url('shop/checkout/order-review')}}">Order Review</a></li>
                                    </ul>		
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- checkout-progress-sidebar -->				
                </div>
            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop