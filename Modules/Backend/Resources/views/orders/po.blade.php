    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

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

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    </head>
    <body class="cnt-home" style="background: #fff;">   

        <div class="body-content">

            <div class="container" style="border: 1px solid #ddd;padding-bottom: 30px;">

                <div class="checkout-box ">

                    <div class="row">

                        <table style="width: 100%;background-image: url('/assets/images/po.png');background-repeat: repeat-y;">
                            
                            <tr>
                                <td style="width:60%;border: 0px;padding: 10px 0px 10px 15px;">
                                    <div class="logo">
                                        <img src="{{url('assets/images/logo.png')}}" alt="">
                                    </div>
                                </td>
                                <td style="width:40%;border: 0px;padding-left: 15px;">
                                    <div style="font-size: 20px;text-align: right;padding-right: 0px;">

                                        <div style="font-weight: bold;padding: 5px 15px;">PURCHASE ORDER</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <table style="border-top: 2px solid #ccc;width: 100%;">
                        <tr>
                            <td style="width:80%"></div>
                            <td style="padding: 10px;width: 20%;">
                               <div style="margin:10px 0px;"> PO #:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style="font-weight: bold;"> {{$order->order_reference}} </span> </div>
                               <div> PO Date: <span style="font-weight: bold;"> {{ date('d-m-Y') }} </span> </div>
                            </td>
                        </tr>
                    </table>

                        <style type="text/css">
                            
                            tr {
                                padding: 5px;
                                border: 1px solid #ddd;
                                line-height: 1.5em;
                            }

                        </style>

                    <div class="row" style="padding:0px;">

                        <div class="col-md-12" style="line-height: 2em;">
                            
                            <table style="margin-top:15px;width: 100%;border: 1px solid #ddd;">

                                @if($order != null)
                                <tr>
                                    <td style="vertical-align: top;padding-left: 5px;">To:</td>
                                    <td> 
                                        <div>{{ isset($seller)?ucwords($seller->name):""}}</div>
                                        <div>Telephone: <span style="color: #FFA200;font-weight: bold;">{{ isset($seller)?$seller->telephone:""}} </span></div>
                                        <div>Email: <span style="color: #FFA200;font-weight: bold;">{{ isset($seller)?$seller->email_address:""}} </span></div>
                                    </td>
                                </tr>
                                @endif
                            </table>

                            <div class="col-md-12" style="text-transform: uppercase;font-weight: bold;font-size: 16px;margin:30px 0px 10px 0px;padding-left: 0px;">Order Details</div>

                            <style type="text/css">
                            
                                td {
                                    padding: 5px;
                                    line-height: 1.5em;
                                }

                            </style>

                            <table style="width: 100%;margin-bottom: 30px;">
                                <tr style="background: #0F7DC2;font-size: 14px;font-weight: bold;color: #fff;">
                                    <td>SKU</td>
                                    <td>Description</td>
                                    <td style="padding-right: 5px;text-align: right;">Qty</td>
                                    <td style="padding-right: 5px;text-align: right;">Unit Price</td>
                                    <td style="padding-right: 5px;text-align: right;">Total Price</td>
                                </tr>
                                @php($subtotal = 0)
                                @if($seller_orders != null)
                                @foreach($seller_orders as $order_detail)
                                @php($commission = $order_detail->order_detail->getCommission())
                                @php($commission_value = $order_detail->order_detail->price * ($commission/100))
                                <tr>
                                    <td> {{ $order_detail->order_detail->product->product_code }}</td>
                                    <td> {{ $order_detail->order_detail->product->name }}</td>
                                    <td style="padding-right: 5px;text-align: right;"> {{ ucwords($order_detail->order_detail->quantity) }}</td>
                                    <td style="text-align: right;padding-right: 5px;"> KES {{ number_format($order_detail->order_detail->price - $commission_value) }}</td>
                                    <td style="text-align: right;padding-right: 5px;"> KES {{ number_format(($order_detail->order_detail->price - $commission_value) * $order_detail->order_detail->quantity) }}</td>
                                </tr>
                                @php( $subtotal+= ($order_detail->order_detail->price - $commission_value))
                                @endforeach
                                @endif
                                <tr style="background: #ddd;font-weight: bold;"><td colspan="4" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Subtotal</td><td style="text-align: right;padding-right: 5px;">KES {{ number_format($subtotal) }}</td></tr>
                            </table>

                            <table style="width: 50%">
                                <tr>
                                <td width="20%">Received By: </td>
                                <td width="50%">
                                    <div style="border-bottom: 1px solid #444;height: 17px;"></div>
                                </td>
                                </tr>
                            </table>

                           <table style="width: 50%;margin-top: 20px;">
                                <tr>
                                <td width="20%">Signature: </td>
                                <td width="50%">
                                    <div style="border-bottom: 1px solid #444;height: 17px;"></div>
                                </td>
                                </tr>
                            </table>

                        </div>

                    </div>

            </div>
        </div>

    </body>

</html>