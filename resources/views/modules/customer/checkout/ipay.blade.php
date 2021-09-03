@extends('customer::layouts.checkout_master')

@section('content') 

<div class="body-content">
        <div class="container">
            <div class="checkout-box ">

                <div class="row">
                    <div class="col-md-12 col-sm-12">

    <?php

    if($user == null){

        $userId = Session::get('userId');

        if($userId != null){ $user = User::find($userId); }

        if($user == null){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Please login in order to checkout successfully');

            echo "<script>location.href='".url('/checkout/payment')."</script>";
        }

    }

    $mpesa = 1;
    $live = 1;
    $shipping_cost = $order->shipping_cost;
    $order_value = $order->total_value;
    $transaction_cost = $order->transaction_cost;
    $voucher_amount = $order->voucher_amount;
    $oid = $order_id;
    $inv = $order_id;
    $ttl = ($order_value + $shipping_cost + $transaction_cost) - $voucher_amount;

    if($user->phone == null){

        Session::flash('alert-class', 'alert-danger');
        Session::flash('flash_message', 'Please update your mobile number first in order to proceed.');

        echo "<script>location.href='".url('/checkout/delivery')."</script>";
    }

    $tel = \Modules\Customer\Utilities\Utilities::prepareMSISDN($user->phone);
    $eml = $user->email;
    $vid = "dayibson";
    $curr = "KES";
    $p1 = $order_id;
    $p2 = "";
    $p3 = "";
    $p4 = "";
    $cbk = "https://dil.africa/shop/ipay/callback";
    $cst = 1;
    $crl = 0;

    $fields = array("live"=> $live,
        "mpesa"=> $mpesa,
        "oid"=> $oid,
        "inv"=> $inv,
        "ttl"=> $ttl,
        "tel"=> $tel,
        "eml"=> $eml,
        "vid"=> $vid,
        "curr"=> $curr,
        "p1"=> $p1,
        "p2"=> $p2,
        "p3"=> $p3,
        "p4"=> $p4,
        "cbk"=> $cbk,
        "cst"=> $cst,
        "crl"=> $crl
    );

    $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
    $hashkey ="Day10NvtM47DX";

    $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

    ?>

    <div>
        
        <h2 style="font-size: 20px;margin-top: 10px;">Thank you <span style="color: #FFA200;">{{$user->first_name}}, </span> <span style="font-weight: normal;font-size: 16px;">Here are your Order Details</span></h2>
        @php($total = 0)

        <style type="text/css">
            
            td {

                padding:5px;
            }
        </style>

        <table style="width: 100%;background:#FFF;border: 1px solid #ccc;">
            <tr style="background: #ddd;font-weight: bold;color: #0F7DC2;">
                <td>Product Name</td><td>Quantity</td><td style="text-align: center;">Unit Price (KES) </td><td style="text-align: right;">Total Price (KES)</td>
            </tr>
            @foreach($order->order_details()->get() as $detail)
            <tr>
            <td>{{ ucwords($detail->product->name) }}</td> <td><span style="color: #FFA200;">{{ $detail->quantity }}</span></td>
            <td style="text-align: center;"> {{ number_format($detail->price) }} </td> <td style="text-align: right;"> {{ number_format($detail->quantity * $detail->price) }} </td>
            @php($total += ($detail->quantity * $detail->price))
            </tr>
            @endforeach
            <tr style="color: #0F7DC2;background: #f5f5f5;font-weight: bold;">
                <td colspan="3">Subtotal</td>
                <td style="text-align: right;"> {{ number_format($total) }} </td>
            </tr>
            @if($shipping_cost > 0)
            @php( $total += $shipping_cost)
            <tr style="color: #FFA200;background: #f5f5f5;">
                <td colspan="3">Shipping Cost</td>
                <td style="text-align: right;"> {{ number_format($shipping_cost) }} </td>
            </tr>
            @endif
            @if($transaction_cost > 0)
            @php( $total += $transaction_cost)
            <tr style="color: #FFA200;background: #f5f5f5;">
                <td colspan="3">Transaction Cost</td>
                <td style="text-align: right;"> {{ number_format($transaction_cost) }} </td>
            </tr>
            @endif
            @if($voucher_amount > 0)
            @php( $total -= $voucher_amount)
            <tr style="color: #FFA200;background: #f5f5f5;">
                <td colspan="3">Voucher Discount</td>
                <td style="text-align: right;"> ( {{ number_format($voucher_amount) }} ) </td>
            </tr>
            @endif
            <tr style="color: #FFF;background: #0F7DC2;font-weight: bold;font-size: 15px;">
                <td colspan="3">Grand Total</td>
                <td style="text-align: right;"> KES {{ number_format($total) }} </td>
            </tr>
        </table>

    </div>

    <form method="post" action="https://payments.ipayafrica.com/v3/ke">

        <?php 
        foreach ($fields as $key => $value) {
           echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
        }
       ?>
       <input name="hsh" type="hidden" value="<?php echo $generated_hash ?>" >

       <button type="submit" class="btn-upper btn btn-success" style="background: #FFA200;border: none;margin-top: 10px;">Pay for your Order</button>
   </form>
</div>
</div>
</div>
</div>
</div>
@stop