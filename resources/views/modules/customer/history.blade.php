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
                                        <div class="col-md-12 user-header" style="margin-top: 10px;">
                                            Orders History
                                        </div>
                                    </div>

                                    <table id="topup_numberstable" class="table table-striped table-bordered" style="width:100%;">
                                        <thead>
                                            <tr style="background:#fff;color:#337AB7;">
                                                <th>Date</th>
                                                <th>Order Reference</th>
                                                <th>Total Value</th>                                        
                                                <th>Shipping Cost</th>
                                                <th>Transaction Cost</th>
                                                <th>Order Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($orders as $order)

                                            <tr>
                                                <td>{{$order->created_at}}</td>
                                                <td>{{$order->order_reference}}</td>
                                                <td>{{$order->total_value}}</td>
                                                <td>{{$order->shipping_cost}}</td>                
                                                <td>{{$order->transaction_cost}}</td>
                                                <td>
                                                    {{($order->order_status != null)?$order->order_status:"NEW"}}
                                                </td>

                                            </tr>						

                                            @endforeach
                                        </tbody>
                                    </table>

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