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
                <div class="col-md-12">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>M-PESA Payment Instructions
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <form class="address-form" role="form">
                                            <input type="hidden" name="user_address_id" value="{{$user_address_id}}"/>
                                            <input type="hidden" name="userId" value="{{$userId}}"/>
                                            <div class="col-md-12 col-sm-12 already-registered-login">                                           

                                                <ol style="line-height: 1.8em;">
                                                    <li>Go to your M-PESA Menu on your mobile phone</li>
                                                    <li>Select "Lipa Na M-PESA"</li>
                                                    <li>Select "Pay Bill"</li>
                                                    <li>Select "Enter Business no."</li>
                                                    <li>Enter "829726" as the Business no.</li>
                                                    <li>Select "Account No."</li>
                                                    <li>Enter the order reference no as the Account No. In this case "<span style="color: red">{{$order->order_reference}}</span>"</li>
                                                    <li>Enter the displayed amount. In this case "<span style="color: red">{{$order->total_value + $order->shipping_cost}}</span>"</li>
                                                    <li>Enter your secret M-PESA PIN and complete the transaction normally</li>
                                                    <li>On successful completion of your transaction on your mobile phone, please note your MPESA transaction reference as this may be required for confirmation during collection / delivery.</li>
                                                </ol>
                                                
                                            </div>
                                        </form>
                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->
                    </div>
                    <!-- checkout-step-01  -->

                </div><!-- /.checkout-steps -->

<!--                <div class="col-md-4">
                     checkout-progress-sidebar 
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height: 387px;">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Enter the M-PESA Transaction Code</h4>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="name">M-PESA Transaction Number <span> (e.g. MEU9OFRXT1)</span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" id="name" name="name" placeholder=""/>
                                </div>
                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Confirm</button>
                            </div>
                        </div>
                    </div> 
                     checkout-progress-sidebar 				
                </div>-->

            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop