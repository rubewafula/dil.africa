    <!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title> Dil.Africa | @if(isset($title)) {{$title}} @else Home  @endif</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="{{url('assets/plugins/pace-master/themes/blue/pace-theme-flash.css')}}" rel="stylesheet"/>
        <link href="{{url('assets/plugins/uniform/css/uniform.default.min.css')}}" rel="stylesheet"/>
        <link href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/> 
        <link href="{{url('assets/plugins/waves/waves.min.css')}}" rel="stylesheet" type="text/css"/>  
        <link href="{{url('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/3d-bold-navigation/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/slidepushmenus/css/component.css')}}" rel="stylesheet" type="text/css"/> 
        <link href="{{url('assets/plugins/weather-icons-master/css/weather-icons.min.css')}}" rel="stylesheet" type="text/css"/>   
        <link href="{{url('assets/plugins/metrojs/MetroJs.min.css')}}" rel="stylesheet" type="text/css"/>  
        <link href="{{url('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>    
        <link href="{{url('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>

            
        <!-- Theme Styles -->
        <link href="{{url('assets/css/modern.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/css/custom.css')}}" rel="stylesheet" type="text/css"/>
 <link href="{{url('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/bootstrap-colorpicker/css/colorpicker.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css"/>

        <link href="{{url('assets/css/jquery-te-1.4.0.css')}}" rel="stylesheet" type="text/css"/>
        
        <script src="{{url('assets/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>
        <script src="{{url('assets/plugins/jquery/jquery-2.1.4.min.js')}}"></script>

        <script src="{{url('assets/js/jquery-te-1.4.0.min.js')}}"></script>
        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
        <![endif]-->

        <script type="text/javascript">
            $(document).ready(function(){

                var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };

                  $(".textarea").ckeditor(options);


            });

        </script>
        
    </head>
    <body class="page-header-fixed compact-menu page-horizontal-bar">
        <div class="overlay"></div>
         @include('seller::layouts.chat')
        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div><!-- Input Group -->
        </form><!-- Search Form -->
        <main class="page-content content-wrap">
            <div class="navbar">
                <div class="navbar-inner container">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a href="{{url('backend')}}" class="logo-text">
                           <img src="{{url('assets/images/logo.png')}}" alt="Logo"> </a>
                    </div><!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-left">
                                <li>        
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                                </li>
                                <li>
                                    <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                                </li>
                                <li>        
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-md dropdown-list theme-settings" role="menu">
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Header 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-header-check" checked>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="li-group">
                                            <ul class="list-unstyled">
                                                <li class="no-link" role="presentation">
                                                    Fixed Sidebar 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right fixed-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Toggle Sidebar 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right toggle-sidebar-check">
                                                    </div>
                                                </li>
                                                <li class="no-link" role="presentation">
                                                    Compact Menu 
                                                    <div class="ios-switch pull-right switch-md">
                                                        <input type="checkbox" class="js-switch pull-right compact-menu-check" checked>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="no-link"><button class="btn btn-default reset-options">Reset Options</button></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>    
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                                </li>
                               
                               @include('seller::layouts.messages')
                               @include('seller::layouts.alerts')
                              @include('seller::layouts.profile_overview')

                               
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic" id="showRight">
                                        <i class="fa fa-comments"></i>
                                    </a>
                                </li>
                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>
                </div>
            </div><!-- Navbar -->

          <?php   $user=  App\User::find(Auth::user()->id); ?>

          @if($user->hasRole('admin') || $user->hasRole('customer_care'))

            @include('backend::layouts.menu')


          @else if($user->hasRole('seller') || $user->hasRole('seller_care'))
          
           @include('seller::layouts.menu')
           
           @endif


           {!! Toastr::render() !!}

  @if(Session::has('flash_message'))
<div class="mess alert {{ Session::get('alert-class', 'alert-success') }} alert-dismissable"> 
 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
{{ Session::get('flash_message') }}</div>
@endif

@if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif


                 <div class="page-inner container">

        <div id="main-wrapper">
    <div class="row">
                        <div class="col-md-12">
                                 <div class="panel-heading clearfix"> Header</div>

                            <div class="panel panel-white">

                    <div class="row m-t-md">
                        <div class="col-md-12">
                            <div class="row mailbox-header">
                                <div class="col-md-2">
                                    <a href="{{url('messages/create')}}" class="btn btn-success btn-block">Compose</a>
                                </div>
                            
                            </div>
                        </div>
                        <div class="col-md-2">
                            <ul class="list-unstyled mailbox-nav">

                                <p> Recent  Messsages </p>
                     <li class="active"><a href="{{ url('messages')}}"><i class="fa fa-inbox"></i>Inbox </a></li>

       <?php  $threads = Cmgmyr\Messenger\Models\Thread::getAllLatest()->get();
 ?>

        @foreach($threads  as $thread)
        <li> <a href="{{ url('messages/'.$thread->id)}}">  {{ $thread->participantsString(Auth::id(),['first_name','last_name']) }} 
@if($thread->userUnreadMessagesCount(Auth::id()) > 0)

  ({{ $thread->userUnreadMessagesCount(Auth::id()) }})

@endif
     </a>  </li>

        @endforeach
                              <!--   <li class="active"><a href="{{ url('messages')}}"><i class="fa fa-inbox"></i>Inbox <span class="badge badge-success pull-right">4</span></a></li>
                                <li><a href="#"><i class="fa fa-sign-out"></i>Sent</a></li>
                                <li><a href="#"><i class="fa fa-file-text-o"></i>Draft</a></li>
                                <li><a href="#"><i class="fa fa-exclamation-circle"></i>Spam</a></li>
                                <li><a href="#"><i class="fa fa-trash"></i>Trash</a></li> -->
                            </ul>
                        </div>
                      @yield('content')
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div>
        </div>
    </div>
            
            </div><!-- Page Inner -->

        </main><!-- Page Content -->
        <nav class="cd-nav-container" id="cd-nav">
            <header>
                <h3>Navigation</h3>
                <a href="#0" class="cd-close-nav">Close</a>
            </header>
            <ul class="cd-nav list-unstyled">
                <li class="cd-selected" data-menu="index">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li data-menu="profile">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <p>Profile</p>
                    </a>
                </li>
                <li data-menu="inbox">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-envelope"></i>
                        </span>
                        <p>Mailbox</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-tasks"></i>
                        </span>
                        <p>Tasks</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-cog"></i>
                        </span>
                        <p>Settings</p>
                    </a>
                </li>
                <li data-menu="calendar">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <p>Calendar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="cd-overlay"></div>
    <script type="text/javascript">
        $(document).ready(function(){
       $('select').select2();

        });

    </script>

        <!-- Javascripts -->
        <script src="{{url('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{url('assets/plugins/select2/js/select2.min.js')}}"></script>

        <script src="{{url('assets/plugins/pace-master/pace.min.js')}}"></script>
        <script src="{{url('assets/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
        <script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{url('assets/plugins/switchery/switchery.min.js')}}"></script>
        <script src="{{url('assets/plugins/uniform/jquery.uniform.min.js')}}"></script>
        <script src="{{url('assets/plugins/classie/classie.js')}}"></script>
        <script src="{{url('assets/plugins/waves/waves.min.js')}}"></script>
        <script src="{{url('assets/plugins/3d-bold-navigation/js/main.js')}}"></script>
        <script src="{{url('assets/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{url('assets/plugins/jquery-counterup/jquery.counterup.min.js')}}"></script>
        <script src="{{url('assets/plugins/toastr/toastr.min.js')}}"></script>
       <script src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <script src="{{url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
        <script src="{{url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
        <script src="{{url('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>

<!--         <script src="{{url('assets/plugins/flot/jquery.flot.min.js')}}"></script>
        <script src="{{url('assets/plugins/flot/jquery.flot.time.min.js')}}"></script>
        <script src="{{url('assets/plugins/flot/jquery.flot.symbol.min.js')}}"></script>
        <script src="{{url('assets/plugins/flot/jquery.flot.resize.min.js')}}"></script>
        <script src="{{url('assets/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{url('assets/plugins/curvedlines/curvedLines.js')}}"></script>
        <script src="{{url('assets/plugins/metrojs/MetroJs.min.js')}}"></script>
        <script src="{{url('assets/js/modern.js')}}"></script>
        <script src="{{url('assets/js/pages/dashboard.js')}}"></script>
         -->
    </body>
</html>