<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title> DIL.AFRICA | @if(isset($title)) {{$title}} @else Home  @endif</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />

        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Styles -->
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href="{{url('assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css')}}" rel="stylesheet"/>
        <link href="{{url('assets/backend/plugins/uniform/css/uniform.default.min.css')}}" rel="stylesheet"/>
        <link href="{{url('assets/backend/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/fontawesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/line-icons/simple-line-icons.css')}}" rel="stylesheet" type="text/css"/> 
        <link href="{{url('assets/backend/plugins/waves/waves.min.css')}}" rel="stylesheet" type="text/css"/>  
        <link href="{{url('assets/backend/plugins/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/3d-bold-navigation/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/slidepushmenus/css/component.css')}}" rel="stylesheet" type="text/css"/> 
        <link href="{{url('assets/backend/plugins/weather-icons-master/css/weather-icons.min.css')}}" rel="stylesheet" type="text/css"/>   
        <link href="{{url('assets/backend/plugins/metrojs/MetroJs.min.css')}}" rel="stylesheet" type="text/css"/>  
        <link href="{{url('assets/backend/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>    
            
        <!-- Theme Styles -->
        <link href="{{url('assets/backend/css/modern.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/bootstrap-colorpicker/css/colorpicker.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css"/>

        <script type="text/javascript" src="{{url('assets/js/jquery.timepicker.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/jquery.timepicker.css')}}" />
        <script src="{{url('assets/js/bootstrap-datepicker.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap-datepicker.css')}}" />

        <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <link rel="icon" type="image/png" href="{{url('favicon.png')}}" />
        
        <script src="{{url('assets/backend/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>

        <script src="{{url('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
        <script src="{{ url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>

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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

        <style type="text/css">
            
            .page-title .container{
                padding-top: 15px;
            }

        </style>
        
    </head>
    <body class="page-header-fixed compact-menu page-horizontal-bar">
        <div class="overlay"></div>
         @include('backend::layouts.chat')
        <form class="search-form" action="#" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control search-input" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
                </span>
            </div><!-- Input Group -->
        </form><!-- Search Form -->
        <main class="page-content content-wrap">
            <div class="navbar" style="border-bottom: 0px;">
                <div class="navbar-inner container">
                    
                    <div class="logo-box">
                        <a href="{{url('backend')}}" class="logo-text">
                           <img src="{{url('assets/backend/images/logo.png')}}" alt="Logo"> </a>
                    </div><!-- Logo Box -->
                   
                    <div class="topmenu-outer">
                        <div class="top-menu">
                       
                            <ul class="nav navbar-nav navbar-right">
                            
                               @include('backend::layouts.messages')
                               @include('backend::layouts.alerts')
                              @include('backend::layouts.profile_overview')

                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>

                </div>
                                @include('backend::layouts.menu')

                                    </div>

           {!! Toastr::render() !!}

            <div class="page-inner" style="margin-top:100px;">
                 @if(Session::has('flash_message'))
<div class="mess alert {{ Session::get('alert-class', 'alert-success') }} alert-dismissable" style="margin-top: 10px;"> 
 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
{{ Session::get('flash_message') }}</div>
 @endif
                    @if ($errors->any())

                    <ul class="alert alert-danger"  style="margin-top: 10px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                   

                @yield('content')
            
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
    
        <!-- Javascripts -->
        <script src="{{url('assets/backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/pace-master/pace.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/jquery-blockui/jquery.blockui.js')}}"></script>
        <script src="{{url('assets/backend/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/switchery/switchery.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/uniform/jquery.uniform.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/classie/classie.js')}}"></script>
        <script src="{{url('assets/backend/plugins/waves/waves.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/3d-bold-navigation/js/main.js')}}"></script>
        <script src="{{url('assets/backend/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/jquery-counterup/jquery.counterup.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/toastr/toastr.min.js')}}"></script>
       <script src="{{ url('assets/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <script src="{{url('assets/backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
        <script src="{{url('assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
        <script src="{{url('assets/backend/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>

    </body>
</html>