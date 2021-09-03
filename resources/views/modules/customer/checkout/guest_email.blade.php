@extends('customer::layouts.checkout_master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class='active'><a href="{{url('shop/checkout')}}">Checkout</a></li>
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
                                        <span>2</span>Your Details
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <form class="address-form" role="form" method="POST" action="{{url('shop/checkout/register-guest')}}">
                                            <div class="col-md-6 col-sm-12 already-registered-login">                                           
                                                <input type="hidden" name="user_id" value="{{isset($user)?$user->id:""}}" />
                                                <div class="form-group">
                                                    <label class="info-title" for="name">First Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input"
                                                           id="first_name" name="first_name" value="{{isset($user)?$user->first_name:""}}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email Address <span>*</span></label>
                                                    <input type="email" class="form-control unicase-form-control text-input"
                                                           id="email" name="email" value="{{isset($user)?$user->email:""}}" required />
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                
                                                <div class="form-group">
                                                    <label class="info-title" for="name">Last Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input"
                                                           id="last_name" name="last_name" value="{{isset($user)?$user->last_name:""}}" required />
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="name">Phone <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input"
                                                           id="phone" name="phone" value="{{isset($user)?$user->phone:""}}" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">

                                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button"
                                                        style="margin-top: 25px;">Continue</button>
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

                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height: 284px;">
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