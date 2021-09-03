<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<title></title>

<link rel="icon" type="image/png" href="{{url('favicon.png')}}" />

<link href="{{ asset('assets/document_styles/css/fonts.css')}}" rel="stylesheet">
<link href="{{ asset('assets/document_styles/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{ asset('assets/document_styles/css/bootstrap-theme.css')}}" rel="stylesheet">
<link href="{{ asset('assets/document_styles/css/main.css')}}" rel="stylesheet">
<link href="{{ asset('assets/document_styles/css/dil.css')}}" rel="stylesheet">

<!--[if lt IE 9]>
<script src="/templates/hai/js/html5shiv.min.js"></script>
<script src="/templates/hai/js/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('assets/document_styles/js/jquery.js')}}"></script>
<script src="{{ asset('assets/document_styles/js/bootstrap.js')}}"></script>


<link href="{{ asset('assets/document_styles/css/print.css')}}" rel="stylesheet" media="print">
</head>
<body>

    <div class="bill-view">
        <div class="bill-header">
            <table width="100%">
                <tbody>
                    <tr style="background: #eee;">

                    @if($seller_order->seller->logo != null)
                    <td class="bill-header-left" style="width:28%;padding: 10px;">

                        <img src="{{asset($seller_order->seller->logo)}}" alt="">

                    </td>
                    @endif
                    <td class="bill-header-details" style="padding: 10px;">
                        @if($seller_order->seller != null)
                        <p class="lead">{{$seller_order->seller->name}}</p>
                        <p>{{$seller_order->seller->postal_address}}</p>
                        <p>{{$seller_order->seller->telephone}}</p>
                        @else
                        Not Known
                        @endif
                    </td>
                    <td class="text-center">
                        <span style="color:#ffa200;font-size: 24px;">Customer's Invoice</span>
                    </td>
                    <td class="bill-header-right" style="width: 28%;padding: 10px;line-height: 1.8em;">
                        <img src="{{ asset('assets/document_styles/logo.png')}}" alt="" style="margin-bottom:10px">
                        <table class="data-table values-right">
                            <tbody> 

                            <tr>
                                <th>Order Reference :</th>
                                <td>{{$seller_order->order_reference}}</td>
                            </tr>
                            <tr>
                                <th>Invoice Date:</th>
                                <td>{{$seller_order->created_at->format('d/m/Y')}}</td>
                            </tr>
                             <tr>
                                <th> PIN  NUMBER: </th>
                                <td>{{$seller_order->seller->pin_number}}</td>
                            </tr>

                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody></table>
        </div>

        <hr>

        <div class="bill-details">
            <div style="float:right;width:200px;font-weight:bold;">
            </div>
            <table class="data-table text-large" width="500">
                <tbody><tr>
                    <th width="100">Customer</th>
                    <td>
                        @if($seller_order->order != null)
                        @if($seller_order->order->user != null)
                       {{$seller_order->order->user->name}} <br>
                       @else
                       Unknown
                       @endif
                       @else
                       Unknown
                       @endif
                    </td>
                </tr>
                <!--
                <tr>
                    <th>Paid Date</th>
                    <td>
                        Unpaid                    </td>
                </tr>
                -->
            </tbody></table>

           
        </div>

        <hr>

        <div class="bill-invoice">
            <table class="table invoice-table" width="100%">
                <thead>
                    <tr>
                        <th>Reference  Number</th>
                        <th>Product</th>
                        <th width="100">Price <small>(VAT  inclusive)</small></th>
                        <th width="100">Tax (%)</th>
                        <th width="100">Quantity</th>
                        <th width="100">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$seller_order->order_reference}}</td>
                        <td>
                            {{$seller_order->order_detail->product->name}}
                        </td>
                        <td>
                           KES {{$seller_order->order_detail->price}}
                       </td>
                        <td class="type-numeric">
                          
                       {{$seller_order->order_detail->product->tax_class}}

                        </td>
                        <td class="type-numeric">{{$seller_order->order_detail->quantity}}</td>
                        <td class="type-numeric">
                            <?php $total= $seller_order->order_detail->price * $seller_order->order_detail->quantity  ?>
                            KES {{$total}}

                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th rowspan="4" colspan="3" style="text-align:left;font-weight:normal">
                           
                        </th>
                        <th colspan="2">Subtotal Before VAT</th>
                        @if($seller_order->order_detail->product->tax_class > 0)
                        <td class="type-numeric">KES {{number_format($total/(1 + ($seller_order->order_detail->product->tax_class/100)))}}</td>
                        @else
                        <td class="type-numeric">KES {{number_format($total)}}</td>
                        @endif
                    </tr>
                    <tr>
                        <th colspan="2">Total VAT</th>
                        <td class="type-numeric">
                        @if($seller_order->order_detail->product->tax_class > 0)
                        KES {{ number_format(($total/(1 + ($seller_order->order_detail->product->tax_class/100))) * ($seller_order->order_detail->product->tax_class/100))}}
                        @else
                        0.00

                        @endif
                         </td>
                    </tr>
                    <tr>
                        <th colspan="2">
                            Amount Due                        </th>
                        <td class="type-numeric">KES {{ number_format($total)}}</td>
                    </tr>
                    <tr>
                        <th colspan="3">&nbsp;</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!--
        <hr>

        <div class="bill-footer">
            <code>ETR Placeholder</code>
        </div>
        -->
        
    </div>



</body></html>