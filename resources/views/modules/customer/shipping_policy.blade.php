@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>Shipping Policy</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 1.8em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">Shipping Policy</div>

                    <div>
                        <h3>Overview</h3>
                        <div>
                            DIL.AFRICA commits to an unmatched delivery experience in Africa. We believe that speed is paramount to you as we serve you and we therefore endeavor to do <strong>Same Day Delivery</strong> to our customers.
                        </div>
                        <h3>How Can I Track my Order?</h3>
                        <div>
                            You can easily track your order at DIL.AFRICA. We endeavor to provide accurate information about your order at all times. You can also contact us at any time if you wish to even gather more details about your order. To track your order, use this link:
                            
                            <a href="{{url('shop/track-order')}}">Track Order</a>
                        </div>
                        <h3>Delivery Charges</h3>
                        <div>
                            DIL.AFRICA believes that delivering to you needs not be expensive. To this end, we do free shipping for many orders subject to our terms from time to time. However, some deliveries do attract a shipping cost. This is calculated based on various factors including zone of delivery, item size, number of items etc. Please see an indication of shipping charges to the various zones.
                            <div>

                                @if(count($shipping_costs) > 0)
                                <table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;margin-top: 10px;">
                                <tr style="background: #eee;font-weight: bold;" class="blue-text">
                                    <td>Destination City / Town</td>
                                    <td>Category</td>
                                    <td>Shipping Type</td>
                                    <td>Single Item Orders Cost</td>
                                    <td>Multiple Item Orders Cost</td>
                                </tr>
                                @foreach($shipping_costs as $cost)
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td>{{ ($cost->city != null)?$cost->city->name:"" }}</td>
                                    <td>{{ $cost->category->name }}</td>
                                    <td>{{ $cost->shipping_type->name }}</td>
                                    <td> KES {{ $cost->price_one }}</td>
                                    <td> KES {{ $cost->price_many }}</td>
                                </tr>
                                @endforeach
                                </table>
                                @endif
                                
                            </div>
                        </div>

                        <h3><strong>Note</strong></h3>
                        <div>
                            <ol>
                                <li>You can save more on shipping cost by ordering multiple items together</li>
                                <li>Goods are returned in accordance with our Return Policy</li>
                            </ol>
                        </div>
                                             
                    </div>
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop