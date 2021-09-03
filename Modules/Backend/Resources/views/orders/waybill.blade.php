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

                        <table style="width: 100%;">
                            
                            <tr>
                                <td style="width:67%;border: 0px;padding-left: 15px;">
                                    <div class="logo">
                                        <img src="{{url('assets/images/logo.png')}}" alt="">
                                    </div>
                                </td>
                                <td style="width:33%;border: 0px;text-align: right;">
                                    <div style="font-size: 18px;text-align: right;padding-right: 0px;">

                                        <div style="font-weight: bold;padding: 5px 15px;">Need Help?</div>
                                        <div style="padding: 5px 15px;">Call us on <span style="font-weight: bold;">0797 522522</span></div>
                                        <div style="padding: 5px 15px;">Website: <span style="color: #0F7DC2;">www.dil.africa</span></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-12" style="font-size: 18px;padding: 5px 10px;background: #ddd;color: #0F7DC2;margin-bottom: 10px;">
                        FULFILLED BY <span style="font-weight: bold;">DIL.AFRICA</span>
                    </div>

                    <div class="row">

                        <table style="width:40%;padding-left: 15px;">
                            <tr><td style="border: 0px;">
                            <input type="checkbox" style="display: inline-block;margin-top:3px;" name="delivery_mode" value="To be Delivered" @if($order->shipping_type_id == 2) checked @endif> 
                            To be Delivered
                            </td>
                            <td style="border: 0px;">
                            <input type="checkbox" style="display: inline-block;margin-top:3px;" name="delivery_mode" value="To be Picked" @if($order->shipping_type_id == 1) checked @endif> 
                            To be Picked
                        </td></tr>
                        </table>
                    </div>

                        <style type="text/css">
                            
                            td {
                                padding: 2px;
                                border: 1px solid #ddd;
                                line-height: 1.3em;
                            }

                        </style>

                    <div class="row" style="padding:0px;">

                        <div class="col-md-12" style="line-height: 2em;">
                            
                            <table style="margin-top:15px;width: 100%;">
                                <tr style="font-size: 14px;background: #FFA200;font-weight: bold;color: #fff;">
                                    <td>Billing Address</td>
                                    <td>Delivery Address</td>
                                    <td>Payment Details</td>
                                </tr>

                                @if($order != null)
                                <tr>
                                    <td> Full Name: <span style="color: #0F7DC2;font-weight: bold;"> {{ ucwords($order->user->first_name)}} {{ ucwords($order->user->last_name) }} </span> <br/>{{ isset($user_address)?ucwords($user_address->google_area):""}}</td>
                                    <td> {{ isset($user_address)?ucwords($user_address->delivery_address):""}}</td>
                                    <td> {{ isset($order->payment_gateway_id)?$order->payment_gateway->name:""}}</td>
                                </tr>
                                <tr>
                                    <td> Telephone: <span style="color: #FFA200;font-weight: bold;">{{ isset($user_address->telephone)?$user_address->telephone:""}} </span> </td>
                                    <td> City: <span style="color: #FFA200;font-weight: bold;"> {{ isset($user_address)?ucwords($user_address->city->name):""}} <span> </td>
                                    <td> Payment Status: <span style="color: #FFA200;font-weight: bold;">{{ isset($order->payment_status)?$order->payment_status:""}}</span> </td>
                                </tr>
                                @endif
                            </table>


                            <div style="width:100%;border:2px solid #0F7DC2;margin-top: 30px;"></div>
                            
                            <table style="width: 100%;">
                                <tr><td style="width: 50%;border: 0px;padding-left: 0px;">
                                    Order Number: <span style="color: #FFA200;font-weight: bold;"> {{$order->order_reference}} </span>
                                </td>
                                <td style="width: 50%;border: 0px;text-align: right;">
                                    Order Date: <span style="color: #FFA200;font-weight: bold;"> {{$order->created_at}} </span>
                                </td></tr>
                            </table>

                            <div class="col-md-12" style="text-transform: uppercase;font-weight: bold;font-size: 16px;margin:30px 0px 10px 0px;padding-left: 0px;">Package Notes</div>

                            <table style="width: 100%;">
                                <tr style="background: #0F7DC2;font-size: 14px;font-weight: bold;color: #fff;">
                                    <td>SKU</td>
                                    <td>Description</td>
                                    <td>Sold By</td>
                                    <td>Selling Price</td>
                                    <td>Qty</td>
                                    <td>Total</td>
                                </tr>
                                @php($subtotal = 0)
                                @if($order != null)
                                @php($total_shipping_cost = 0)
                                @foreach($order->order_details()->get() as $order_detail)
                                @php($shipping_cost = 0)
                                @php($price = 0)
                                @if($order_detail->product->getShippingCost() > 0)
                                @php($shipping_cost = 0)
                                @php($price = $order_detail->price + $order_detail->product->getShippingCost())
                                @else
                                @php($shipping_cost = $order_detail->product->getRealShippingCost($order_detail->id))
                                @php($price = $order_detail->price)
                                @endif
                                <tr>
                                    <td> {{ $order_detail->product->product_code }}</td>
                                    <td> {{ $order_detail->product->name }}</td>
                                    <td style="padding-right: 5px;text-align: right;"> {{ ucwords($order_detail->product->seller->name) }}</td>
                                    <td style="text-align: right;padding-right: 5px;"> KES {{ number_format($price) }}</td>
                                    <td> {{ $order_detail->quantity }}</td>
                                    <td style="text-align: right;padding-right: 5px;"> KES {{ number_format($order_detail->quantity * $price) }}</td>
                                </tr>
                                @php( $subtotal+= ($price * $order_detail->quantity))
                                @php($total_shipping_cost += ($shipping_cost * $order_detail->quantity))
                                @endforeach
                                @endif
                                <tr style="background: #ddd;font-weight: bold;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Subtotal</td><td style="text-align: right;padding-right: 5px;">KES {{ number_format($subtotal) }}</td></tr>
                                @if($shipping_cost > 0)
                                <tr style="background: #ddd;color: #FFA200;font-weight: bold;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Shipping Fee</td><td style="text-align: right;padding-right: 5px;">KES {{ number_format($order->shipping_cost) }}</td></tr>
                                @else
                                <tr style="background: #ddd;color: #FFA200;font-weight: bold;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Shipping Fee</td><td style="text-align: right;padding-right: 5px;">Free</td></tr>
                                @endif
                                @if($order->transaction_cost > 0)
                                <tr style="background: #ddd;color: #FFA200;font-weight: bold;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Transaction Fee</td><td style="text-align: right;padding-right: 5px;">KES {{ number_format($order->transaction_cost) }}</td></tr>
                                @endif
                                @if($order->voucher_amount > 0)
                                <tr style="background: #ddd;color: #FFA200;font-weight: bold;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding-right: 5px;">Voucher Discount</td><td style="text-align: right;padding-right: 5px;"> ( KES {{ number_format($order->voucher_amount) }})</td></tr>
                                @endif
                                <tr style="background: #ccc;font-weight: bold;color: #0F7DC2;"><td colspan="5" style="border-right: 1px solid #bbb;text-align: right;padding: 5px;">GRAND TOTAL</td><td style="padding: 5px;text-align: right;">KES {{ number_format(($subtotal + $shipping_cost + $order->transaction_cost) - $order->voucher_amount) }}</td></tr>
                            </table>

                            <div class="col-md-12" style="text-transform: uppercase;font-weight: bold;font-size: 15px;margin:30px 0px 5px 0px;padding-left: 0px;">MPESA Instructions</div>

                            <div style="padding: 5px 0px;">Use Paybill Number: <span style="font-weight: bold;">829726</span></div>

                            <div>Account Number: <span style="font-weight: bold;"> {{$order->order_reference}} </span></div>

                            <div style="width:100%;border:1px solid #FFA200;margin-top: 30px;"></div>

                            <div style="font-style: italic;font-size: 11px;color:#888;line-height: 1.8em;">The seller bears the responsibility to issue and provide customers with an invoice. This document does not constitute a sales invoice. It is the responsibility of the seller  to  determine  whether  or  not  the  price  of the  items  sold is  subject  to the statutory taxes and fees such as VAT, custom  duties and  other  taxes. It is also the responsibility of the seller to pay VAT, custom duties and other taxes as required by law.</div>
                        </div>

                    </div>

            </div>
        </div>

    </body>

</html>