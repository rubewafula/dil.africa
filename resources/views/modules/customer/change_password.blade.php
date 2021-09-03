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
                    <li><a href="{{url('/shop')}}">Home</a></li>
                    <li class='active'>Change Password</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">

    <div class="col-md-12 col-sm-12 create-new-account">

        <h4>Change your Password</h4>
    </div>
    <!-- create a new account -->
    <div class="col-md-8 col-sm-8 col-md-offset-1 create-new-account">

        <form class="address-form" role="form" method="POST" action="{{url('shop/change-password')}}">
            <div class="col-md-7 col-sm-12 already-registered-login">
                <div class="form-group">
                    <label class="info-title" for="current_password">Current Password <span>*</span></label>
                    <input type="password" class="form-control unicase-form-control text-input" id="current_password" name="current_password" placeholder=""/>
                </div>                                                                                
            </div>
            <div class="col-md-7 col-sm-12 already-registered-login">
                
                <div class="form-group">
                    <label class="info-title" for="new_password">New Password <span>*</span></label>
                    <input type="password" class="form-control unicase-form-control text-input" id="new_password" name="new_password" placeholder=""/>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 already-registered-login">
                <div class="form-group">
                    <label class="info-title" for="confirm_password">Confirm Password <span>*</span></label>
                    <input type="password" class="form-control unicase-form-control text-input" id="confirm_password" name="confirm_password" placeholder=""/>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 already-registered-login">
                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Change</button>
            </div>
        </form>

    </div>	
    <!-- create a new account -->

                </div><!-- /.row -->
            </div><!-- /.sigin-in-->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
    @stop