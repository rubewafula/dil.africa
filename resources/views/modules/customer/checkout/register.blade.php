@extends('customer::layouts.master')

@section('content')

<script>

$(document).ready(function(){
    
    var BASE_URL = "http://localhost:82/dil/public/shop/";
    
    $("#country").change(function(){
        
        var country_id = $("#country").val();
        var filedata = new FormData();
        
        filedata.append('country', country_id);
        $.ajax({
            url: BASE_URL + "cities",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {

                    $("#city").html(output.html);                              
                }
            }
        });
        
    });
    
    
    $("#city").change(function(){
        
        var city_id = $("#city").val();
        var filedata = new FormData();
        
        filedata.append('city', city_id);
        $.ajax({
            url: BASE_URL + "zones",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {

                    $("#zone").html(output.html);                              
                }
            }
        });
        
    });
    
    
    $("#zone").change(function(){
        
        var zone_id = $("#zone").val();
        var filedata = new FormData();
        
        filedata.append('zone', zone_id);
        $.ajax({
            url: BASE_URL + "areas",
            data: filedata,
            cache: false,
            processData: false, // Don't process the files
            contentType: false,
            type: 'post',
            success: function (output) {

                if (output.status == '200') {

                    $("#area").html(output.html);                              
                }
            }
        });
        
    });
});

</script>

<style>
    .info-title {
        font-family: 'Open Sans', sans-serif, sans-serif;
        font-weight: normal;
        margin-bottom: 5px;
        font-size: 13px;
      }
</style>

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
                                        <span>1</span>Register
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->                               

                                <div class="panel-body" id="register-form">
                                    <div class="row">		

                                        <form class="address-form" role="form" method="POST" action="{{url('shop/register-customer')}}">
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="first_name">First Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="first_name" name="first_name" placeholder=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="last_name">Last Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="last_name" name="last_name" placeholder=""/>
                                                </div>
                                                <div class="form-group">                                                   
                                                    @php($countries = \Modules\Customer\Entities\Country::pluck('name', 'id'))
                                                    {!! Form::select('country', $countries, null, ['class' => 'form-control unicase-form-control text-input', 
                                                        'id'=>'country', 'placeholder'=>'Select Country', 'style'=>'margin-top:37px', 'required' => 'required']) !!}                                                      
                                                </div>                                                                                            
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Phone Number <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="phone" name="phone" placeholder=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email Address <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="email" name="email" placeholder=""/>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="info-title" for="city">City / Town <span></span></label>
                                                    <select class="form-control unicase-form-control text-input" id="city" name="city" placeholder="Select City/Town">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="zone">Zone <span></span></label>
                                                    <select class="form-control unicase-form-control text-input" id="zone" name="zone" placeholder="Select Zone">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="area">Area <span></span></label>
                                                    <select class="form-control unicase-form-control text-input" id="area" name="area" placeholder="Select Area">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="password">Password <span></span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title" for="password">Confirm Password <span></span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="conf_password" name="conf_password" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 already-registered-login">
                                                <button type="submit" style="margin-top: 25px;" class="btn-upper btn btn-primary checkout-page-button">Register</button>
                                            </div>
                                        </form>                                        
                                    </div>
                                </div>

                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default" style="height:585px;">
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