<!DOCTYPE html>
   <html>
    <head>
        
        <!-- Title -->
        <title> DIL.AFRICA | @if(isset($title)) {{$title}} @else QC  Dashboard  @endif </title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="DIL.AFRICA" />
        <meta name="keywords" content="DIL.AFRICA" />
        <meta name="author" content="Steelcoders" />
        
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

        <link href="{{url('assets/backend/css/jquery-te-1.4.0.css')}}" rel="stylesheet" type="text/css"/>

        <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="{{url('assets/css/main.css')}}">

        <link rel="icon" type="image/png" href="{{url('favicon.png')}}" />
        
        <script src="{{url('assets/backend/plugins/3d-bold-navigation/js/modernizr.js')}}"></script>
        <script src="{{url('assets/backend/plugins/jquery/jquery-2.1.4.min.js')}}"></script>

        <!-- <script src="{{url('assets/backend/js/jquery-te-1.4.0.min.js')}}"></script> -->
        <script src="{{url('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
        <script src="{{url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

        <script type="text/javascript">

            $(document).ready(function(){

                 $('#start_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                 $('#end_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                 $('#product_expiry_date').datepicker({
                    format: 'yyyy-mm-dd'       
                 });

                var options = {
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                  };

                  // $('textarea').ckeditor(options);
                  
                  CKEDITOR.replace( 'desc', options);

            });

        </script>
        
    </head>
    <body class="compact-menu page-horizontal-bar">
        <div class="overlay"></div>
      
        <main class="content-wrap">
            
            @include('qc::layouts.header')
         
            <div class="page-inner container">
                     
                @include('qc::layouts.notifications')
                      
                @yield('content')

                @include('qc::layouts.footer')
                
            </div><!-- Page Inner -->

        </main><!-- Page Content -->
       
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

        <script>

            $(document).ready(function () {

                $(".mess").fadeTo(8000, 4000).slideUp(4000, function () {
                    $(".mess").slideUp(1000);
                });

                $(".mess2").fadeTo(8000, 4000).slideUp(4000, function () {
                    $(".mess2").slideUp(4000);
                });
            });
        </script>

    </body>
</html>