@extends('customer::layouts.master')

@section('content')

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            @include('customer::product.sidebar.index')
            <div class='col-md-9'>
                <div class="detail-block">
                    <div class="row  wow fadeInUp">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row" style="padding-top: 15px;line-height: 1.8em;background: #f5f5f5;">
                                        
                                        <div class="col-md-8 col-sm-8">
                                            Total Orders: <span class="header-text">{{$total}}</span>                       
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            {!! Form::open(['method' => 'GET', 'url' => '/shop/history', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin-top:0px;'])  !!}
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 user-header" style="margin-top: 10px;padding: 10px 0px;background: #ffa200;text-align: center;color: #FFF;">
                                            Orders History
                                        </div>
                                    </div>

                                    <style> 
                                        .col-padding{
                                            padding:  5px 15px;
                                        }
                                    </style>

                                    <div id="topup_numberstable" class="row hidden-xs" style="background:#ddd;color:#337AB7;padding: 10px 0px;font-weight: bold;">
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Date</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Order Reference</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Total Value</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12 col-padding">Shipping</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Transaction Cost</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12 col-padding">Status</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Tran. Document</div>                    
                                    </div>

                                    @foreach($orders as $order)

                                    <div class="row" style="background:#fff;padding: 10px 0px;border-bottom: 1px solid #ddd;">
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Date: </span>{{$order->created_at}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Ref.: </span>{{$order->order_reference}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Total Value: </span> {{$order->total_value}}
                                        </div>
                                        <div class="col-md-1 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Shipping: </span> {{$order->shipping_cost}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Transaction Cost: </span> {{$order->transaction_cost}}
                                        </div>
                                        <div class="col-md-1 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Status: </span> {{($order->order_status != null)?str_replace("_", " ", $order->order_status):"NEW"}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Tran. Document: </span>
                                            <a href="{{url('/shop/order/invoice/view/'.$order->id)}}" target="_blank">
                                                View
                                            </a>
                                            <a style="color: #ffa200;padding-left: 5px;" href="{{url('/shop/order/invoice/download/'.$order->id)}}">
                                                Download
                                            </a>
                                        </div>                 
                                    </div>					

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div>

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">

                        @include('customer::home.recommended.index')
                    </div><!-- /.scroll-tabs -->
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop