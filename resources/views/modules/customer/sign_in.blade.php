@extends('customer::layouts.master')

@section('content')

<style>
    label{
        
        font-weight: normal;
    }
</style>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Login</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="sign-in-page">
            <div class="row">
                <!-- Sign-in -->			
                <div class="col-md-6 col-sm-6 sign-in">
                    <h4 class="">Sign in</h4>
                    <p class="">Hello, Welcome to your account.</p>
                    <div class="social-sign-in outer-top-xs">
                        <a href="#" class="facebook-sign-in"><i class="fa fa-facebook"></i> Sign In with Facebook</a>
                        <a href="#" class="twitter-sign-in"><i class="fa fa-twitter"></i> Sign In with Twitter</a>
                    </div>
                    <form class="register-form outer-top-xs" method="POST" role="form" action="{{url('/shop/login')}}">
                        <div class="form-group">
                            <label class="info-title" for="email">Email Address <span>*</span></label>
                            <input type="email" class="form-control unicase-form-control text-input" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="password">Password <span>*</span></label>
                            <input type="password" class="form-control unicase-form-control text-input" id="password" name="password">
                        </div>
                        <div class="radio outer-xs">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="remember_me">Remember me!
                            </label>
                            <a href="#" class="forgot-password pull-right">Forgot your Password?</a>
                        </div>
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                    </form>					
                </div>
                <!-- Sign-in -->

                <!-- create a new account -->
                <div class="col-md-6 col-sm-6 create-new-account">
                    <h4 class="checkout-subtitle">Not Registered Yet?</h4>
                    <p class="text title-tag-line">Create your new account</p>
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
                <!-- create a new account -->			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop