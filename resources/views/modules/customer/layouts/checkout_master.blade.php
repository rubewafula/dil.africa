<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        @if(isset($product))
        <meta name="keywords" content="{{$product->keywords}},Buy, Products, eCommerce">
        @else
        <meta name="keywords" content="Buy, Products, eCommerce">
        @endif
        <meta name="robots" content="all">

        <title>{{ isset($title)?$title:"DIL.AFRICA" }}</title>

        <link rel="icon" type="image/png" href="{{url('favicon.png')}}" />

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/jquery-ui.css')}}">
        <!-- Customizable CSS -->
        <link rel="stylesheet" href="{{url('assets/css/main.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/blue.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/owl.carousel.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/owl.transitions.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/rateit.css')}}">       
        <link rel="stylesheet" href="{{url('assets/css/bootstrap-select.min.css')}}">
        <link href="{{url('assets/css/lightbox.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{url('assets/css/anto_custom.css')}}">

        <!-- Icons/Glyphs -->
        <link rel="stylesheet" href="{{url('assets/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/jquery-editable-select.min.css')}}">

        <!-- Fonts --> 
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <script src="{{url('assets/js/jquery-1.11.1.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn77bBDVT20MUJKNFSqsECV09sEntIe5k&libraries=places"></script>
        <script type="text/javascript">
            function initialize() {
              var input = document.getElementById('area');
              new google.maps.places.Autocomplete(input);
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        </script>

    </head>
    <body class="cnt-home">

        <div id="successdialog" title="Success" style="color: #0F7DC2;overflow: hidden;">

        </div>

        <div id="failuredialog" title="Failed" style="color: #CC0000;overflow: hidden;">

        </div>

        @include('customer::layouts.checkout_header')
        @include('customer::layouts/notifications')
        @yield('content')

        @include('customer::layouts.footer')

        <!-- For demo purposes ??? can be removed on production -->

        <!-- For demo purposes ??? can be removed on production : End -->

        <!-- JavaScripts placed at the end of the document so the pages load faster -->

        <script src="{{ url('assets/js/jquery-ui.min.js')}}"></script>
        <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{url('assets/js/bootstrap-hover-dropdown.min.js')}}"></script>
        <script src="{{url('assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{url('assets/js/echo.min.js')}}"></script>
        <script src="{{url('assets/js/jquery.easing-1.3.min.js')}}"></script>     
        <script src="{{url('assets/js/bootstrap-slider.min.js')}}"></script>
        <script src="{{url('assets/js/jquery.rateit.min.js')}}"></script>
        <script src="{{url('assets/js/lightbox.min.js')}}"></script>
        <script src="{{url('assets/js/bootstrap-select.min.js')}}"></script>
        <script src="{{url('assets/js/wow.min.js')}}"></script>
        <script src="{{url('assets/js/scripts.js')}}"></script>
        <script src="{{url('assets/js/main.js')}}"></script>
        <script src="{{url('assets/js/processor.js')}}"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123147179-1"></script>
        
        <!-- <script type="text/javascript">function add_chatinline(){var hccid=62277915;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline(); </script> -->

        <!--Start of Tawk.to Script-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5ba28668c9abba579677b4dd/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>

        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-123147179-1');
        </script>

    </body>
</html>