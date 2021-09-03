@extends('seller::layouts.login_layout')

@section('content')
        <div class="body-content">

                <div class="main-header" style="border-bottom: 2px solid #108bea;">

                        <div class="container">
                            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                                <!-- ============================================================= LOGO ============================================================= -->
                                <div class="logo">
                                    <a href="{{url('/shop')}}">

                                        <img src="{{url('assets/images/logo.png')}}" alt="">

                                    </a>
                                </div><!-- /.logo -->
                                <!-- ============================================================= LOGO : END ============================================================= -->             </div><!-- /.logo-holder -->

                            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                                <!-- /.contact-row -->
                                <div class="search-area">
                                    
                                </div>              
                            </div><!-- /.top-search-holder -->

                            <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                                
                            </div><!-- /.row -->

                    </div><!-- /.container -->
                </div>

                <div class="container" id="main-wrapper">
                    <div class="row" style="background: #fff;">
                        <div class="col-md-6 col-md-offset-1 center">
                            <div class="login-box panel panel-white">
                                <div class="panel-body">

                                   <div class="row">  
                                        <div class="col-md-7">
                                           <span style="color: #108bea;font-size: 18px;">Sign  Up</span>
                                           <p style="line-height: 1.6em;">
                                           Provide the following information to register
                                            </p>
                                       </div>
                                       <div class="col-md-5">
                                           Already  registered? <a href="{{url('seller/login')}}" class="btn-primary"> Login </a>
                                       </div>
                                   </div>

                                   <hr/>

                                    <div class="row">
                                
                                        <div class="col-md-12">
                                         <form class="form-horizontal" method="POST" action="{{ url('seller/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                           <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Sign up
                                </button>
                            </div>
                        </div>

                     
                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <img src="{{url('assets/images/selling-online-today.png')}}" width="400px" style="padding: 10px;" />
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
    @endsection

        <!-- Javascripts -->





