@extends('seller::layouts.login_layout')

@section('content')
        <div class="body-content">

                <div class="main-header" style="border-bottom: 2px solid #108bea;">

                        <div class="container">
                            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                                <!-- ============================================================= LOGO ============================================================= -->
                                <div class="logo">
                                    <a href="{{url('/')}}">

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

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

            <h3> SELLER  CENTER</h3>
                                    <div class="row">
                                
                                        <div class="col-md-12">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

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
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>

                    <div class="col-md-4" style="text-align: right;">
                         Not Registered Yet? 
                     </div>
                     <div class="col-md-6">
                         <a href="{{url('seller/register')}}" class="btn btn-block m-t-md" style="background: #ffa200;color: #fff;">Create an account as a Seller</a>
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





