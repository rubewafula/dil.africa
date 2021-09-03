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
                  
                    <td class="text-center">
                        <span style="color:#ffa200;font-size: 24px;">Customer's Order</span>
                    </td>
                    <td class="bill-header-right" style="width: 28%;padding: 10px;line-height: 1.8em;">
                        <img src="{{ asset('assets/document_styles/logo.png')}}" alt="" style="margin-bottom:10px">
                        <table class="data-table values-right">
                            <tbody> 

                            <tr>
                                <th>Order Reference :</th>
                                <td>{{$order->order_reference}}</td>
                            </tr>
                            <tr>
                                <th>Invoice Date:</th>
                                <td>{{$order->created_at->format('d/m/Y')}}</td>
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
                    <th width="100">Customer:</th>
                    <td>
                        @if($order != null)
                        @if($order->user != null)
                       {{ ucfirst($order->user->first_name) }} {{ ucfirst($order->user->last_name) }},<br>
                       {{ ($order->user->phone != null)?$order->user->phone:"" }} <br>
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
                        Unpaid                    
                    </td>
                </tr>
                -->
            </tbody>
        </table>

           
        </div>

        <hr>

        <div class="bill-invoice">
            <table class="table invoice-table" width="100%">
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Product</th>
                        <th width="100">Price <small>(VAT  inclusive)</small></th>
                        <th width="100">Tax (%)</th>
                        <th width="100">Quantity</th>
                        <th width="100">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php($grandtotal = 0)
                    @php($total_tax = 0)
                    @foreach($order->order_details as $detail)
                    @if($detail->product == null)
                    @continue
                    @endif
                    <tr>
                        <td>{{$detail->order->order_reference}}</td>
                        <td>
                            {{$detail->product->name}}
                        </td>
                        <td>
                           KES {{$detail->price}}
                       </td>
                        <td class="type-numeric">
                          
                        {{$detail->product->tax_class}}
                         @php($total_tax += $detail->product->tax_class)

                        </td>
                        <td class="type-numeric">{{$detail->quantity}}</td>
                        <td class="type-numeric">
                            <?php $total= $detail->price * $detail->quantity  ?>
                            KES {{ number_format($total) }}
                            @php($grandtotal += $total)
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!-- <tr>
                        <th rowspan="4" colspan="3" style="text-align:left;font-weight:normal">
                           
                        </th>
                        @php($tax_class = 0)
                        <th colspan="2">Subtotal Before VAT</th>
                        @if($detail->product != null)
                        <td class="type-numeric">KES {{number_format($total_tax)}}</td>
                        @else
                        <td class="type-numeric">KES {{number_format($grandtotal)}}</td>
                        @endif
                    </tr>
                    <tr>
                        <th colspan="2">Total VAT</th>
                        <td class="type-numeric">
                        @if($detail->product != null)
                        @php($tax_class = $detail->product->tax_class)
                        KES {{ number_format($total_tax)}}
                        @else
                        0.00

                        @endif
                         </td>
                    </tr> -->
                    <tr>
                        <th colspan="5">
                            Total Amount Due                        
                        </th>
                        <td class="type-numeric">KES {{ number_format($grandtotal)}}</td>
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

</body>
</html>