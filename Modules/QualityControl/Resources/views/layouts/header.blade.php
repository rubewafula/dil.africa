<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">

    <!-- ============================================== TOP MENU ============================================== -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            
        </div><!-- /.container -->
    </div><!-- /.header-top -->
    <!-- ============================================== TOP MENU : END ============================================== -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ============================================================= LOGO ============================================================= -->
                    <div class="logo">
                        <a href="{{url('/shop')}}">

                            <img src="{{url('assets/images/logo.png')}}" alt="">

                        </a>
                    </div><!-- /.logo -->
                    <!-- ============================================================= LOGO : END ============================================================= --> 

                          </div><!-- /.logo-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">

                        <div class="search-area" style="background: #fff;text-align: center;color: #F89530;">
                            
                            <span style="font-weight: normal;font-size: 28px;">QUALITY CONTROL (QC)</span>
                        </div>
                        
                    </div><!-- /.top-search-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row" style="    padding-top: 20px;">
                        <div class="header-top-inner">
                    <div class="cnt-account">
                    <ul class="list-unstyled" style="text-transform:uppercase; font-size:11px">
                        @if(Auth::user() == null)
                        <li><a href="{{url('/qc/login')}}"><i class="icon fa fa-lock"></i>Login</a></li>
                        @endif
                        @if(Auth::check())
                        <li class="dropdown  navbar-right special-menu">
                            <a href="{{url('/logout')}}">
                                <span style="color: #fff;background: #F89530;padding: 3px 5px;border-radius: 3px;">Logout</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div><!-- /.cnt-account -->

                <!-- /.cnt-cart -->
                <div class="clearfix"></div>
            </div><!-- /.header-top-inner -->
                    </div>
                
            </div><!-- /.row -->

        </div><!-- /.container -->

    </div><!-- /.main-header -->

    <!-- ============================================== NAVBAR ============================================== -->
    <div class="header-nav animate-dropdown">
        <div class="container" style="padding-left: 0px;padding-right: 0px;">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <style type="text/css">
                    
                    .yamm .dropdown-menu li a:hover, .yamm .dropdown-menu li a:focus {
                        color: #FFF;
                        background: #F89530;
                    }
                </style>

                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav">
                                <li class="active dropdown yamm-fw">
                                    <a href="{{url('qc')}}">Dashboard</a>
                                </li>
                                <li class="active dropdown yamm-fw">
                                    <a href="{{url('qc/products')}}">Products</a>
                                </li>
                                <li class="dropdown yamm mega-menu">
                                    <a href="#" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">Repository Listings</a>
                                    <ul class="dropdown-menu" style="width: 25%">
                                        <li>
                                            <div>
                                                <div class="row">

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-menu">
                                                                               
                                                        <ul class="links">
                                                            
                                                            <li style="padding: 2px 0px;"><a href="{{url('qc/repo/pending')}}">Pending Review</a></li>
                                                            <li style="padding: 2px 0px;"><a href="{{url('qc/repo/passed')}}">QC Passed</a></li>
                                                            <li style="padding: 2px 0px;"><a href="{{url('qc/repo/failed')}}">QC Failed</a></li>

                                                        </ul>
                                                    </div>  
                                                </div>
                                            </div> 
                                        </li>
                                    </ul>

                                </li>
                                <li class="dropdown yamm mega-menu">
                                    <a href="#" data-hover="dropdown" class="dropdown-toggle" data-toggle="dropdown">QC Reports</a>
                                    <ul class="dropdown-menu" style="width: 25%">
                                        <li>
                                            <div>
                                                <div class="row">

                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-menu">
                                                                               
                                                        <ul class="links">
                                                            
                                                            <li style="padding: 2px 0px;"><a href="{{url('qc/rejected')}}">Rejected Listings</a></li>

                                                        </ul>
                                                    </div>  
                                                </div>
                                            </div> 
                                        </li>
                                    </ul>

                                </li>

                                <li class="active dropdown yamm-fw">
                                    <a href="{{url('qc/seller-profiles')}}">Seller Profiles</a>
                                </li>

                            </ul><!-- /.navbar-nav -->
                            <div class="clearfix"></div>        
                        </div><!-- /.nav-outer -->
                    </div><!-- /.navbar-collapse -->

                </div><!-- /.nav-bg-class -->
            </div><!-- /.navbar-default -->
        </div><!-- /.container-class -->

    </div><!-- /.header-nav -->
    <!-- ============================================== NAVBAR : END ============================================== -->

</header>