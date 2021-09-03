@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>Track your Order</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 2em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">Track your Order</div>

                    <div>
                        Thank you for doing your shopping at <strong>DIL.AFRICA</strong><br/>
                        At DIL.AFRICA we endeavor to deliver your order as fast as possible and to give you a great shopping experience. 
                        To track your order, specify your order reference below and then click "Track"

                        <div style="background: #ccc;font-weight: bold;margin-top: 10px;padding: 5px;border: 1px solid #ddd;">
                            ORDER STATUS - Enter your Order Reference             
                        </div>
                        <div style="border: 1px solid #ddd;padding: 10px;">
                            
                            <form method="POST" action="{{url('shop/track-order')}}">
                            <label for="order_reference">Order Reference</label>
                            {{Form::text('order_reference', null, ['class'=>'form-control'])}}

                            <input type="submit" name="track-order" class="btn orange-bg" style="margin-top: 10px;" value="Track"/>
                        </div>

                        To see the order status information, please see below after you click on <strong>"Track"</strong>.<br/>

                        @if(isset($order))

                        <style>
                            td {padding-left: 10px;}
                        </style>

                        <table width="100%" cellpadding="4" cellspacing="0" style="border: 1px solid #ccc;">
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Order Reference:</td>
                                <td style="border-bottom:1px solid #ccc;">{{$order->order_reference}}</td>
                            </tr>
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Your Name:</td>
                                @php($customer = App\User::find($order->user_id))
                                <td style="border-bottom:1px solid #ccc;">{{ucfirst($customer->first_name)}} {{ucfirst($customer->last_name) }}</td>
                            </tr>
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Your Email Address:</td>
                                <td style="border-bottom:1px solid #ccc;">{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Your Phone Number:</td>
                                <td style="border-bottom:1px solid #ccc;"> {{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Mode of Delivery:</td>
                                <td style="border-bottom:1px solid #ccc;">{{ $delivery_mode }} </td>
                            </tr>
                            <tr>
                                <td style="background:#eee;color:#0f7dc2;border:1px solid #ccc;">Dropping / Delivery Location:</td>
                                <td style="border-bottom:1px solid #ccc;"> {{ $address }}</td>
                            </tr>
                            <tr style="background: #ddd;font-weight: bold;">
                                <td style="color:#0f7dc2;border:1px solid #ccc;">Order Status:</td>
                                <td style="border-bottom:1px solid #ccc;"> {{ str_replace("_", " ", $order->order_status) }} @if($order->expected_delivery_time != null)<span class="blue-text" style="font-weight: normal;"> This order is expected to be delivered at around <strong>{{$order->expected_delivery_time}}</strong></span> @endif </td>
                            </tr>
                        </table>
                        @endif

                        To have someone else receive the order on your 
                        behalf, please ensure that you avail a valid identification 
                        document (National ID Card or a valid Passport) to the recipient. We 
                        may also call you to confirm before issuing your order<br/>
                        We do our best to keep the order status information as accurate as possible. However, 
                        you may still get in touch with us to get more details on the status of 
                        your order at any given time. Thank you.
                    </div>
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop