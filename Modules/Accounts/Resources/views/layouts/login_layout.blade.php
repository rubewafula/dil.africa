
<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title>DIl.AFRICA | Accounts  Login</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Seller center" />
        <meta name="keywords" content="Seller Dashboard" />
        <meta name="author" content="Steelcoders" />

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

        <!-- Fonts --> 
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

   
    </head>
        <body class="page-login login-alt">
            @include('seller::layouts/notifications')

                @yield('content')

            <script src="{{ url('assets/js/jquery-1.11.1.min.js')}}"></script>


        </body>
</html>