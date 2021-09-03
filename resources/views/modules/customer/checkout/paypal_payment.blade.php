@extends('customer::layouts.checkout_master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class='active'><a href="{{url('shop/checkout')}}">Checkout</a></li>
                <li class='active'><a href="{{url('shop/checkout/delivery')}}">Address</a></li>
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
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>Paypal Payment Instructions
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row" style="line-height: 2em;">
                                        <span style="color:#CC0000;">
                                            Please note that Paypal Payments Attract a Transaction Charge of 3.5% of the Total Order Value
                                        </span>
                                        <form class="address-form" role="form" method="POST" action="{{url('shop/pay_by_paypal')}}">
                                            <input type="hidden" name="user_address_id" value="{{$user_address_id}}"/>
                                            <input type="hidden" name="userId" value="{{$userId}}"/>
                                            <input type="hidden" name="order_id" value="{{$order_id}}"/>
                                            <input type="hidden" name="total_amount" value="{{$total_paypalcost}}"/>
                                            <div class="col-md-12 col-sm-12 already-registered-login" style="margin-bottom: 10px;">                                           

                                                <div class="row">
                                                    
                                                    <div class="col-md-4">
                                                        Order Cost:
                                                    </div>
                                                    <div class="col-md-3">
                                                        KES {{ number_format($order_value) }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        Shipping Cost:
                                                    </div>
                                                    <div class="col-md-3">
                                                        KES {{ number_format($shipping_cost) }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        Paypal Transaction Cost:
                                                    </div><div class="col-md-3">
                                                        KES {{ number_format($transaction_cost) }}
                                                    </div>
                                                </div>
                                                
                                                <div class="row" style="font-weight: bold;padding-top: 5px;border-top: 1px solid #eee;">
                                                    <div class="col-md-4">
                                                        Total Amount:
                                                    </div>
                                                    <div class="col-md-3">
                                                        KES {{ number_format($total_paypalcost) }}
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Confirm & Pay</button>
                                        </form>
                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                    <!-- checkout-step-01  -->
                </div>

                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="padding-bottom: 90px;">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                </div>
                                <div class="">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        <li><a href="{{url('shop/checkout')}}">Checkout Method</a></li>
                                        <li><a href="{{url('shop/checkout/delivery')}}">Delivery Address Information</a></li>
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