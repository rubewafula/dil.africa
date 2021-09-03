    @extends('backend::layouts.master')

    @section('content')
    <div class="page-breadcrumb">
        <ol class="breadcrumb container">
            <li><a href="index.html">Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
    <div class="page-title">
        <div class="container">

        </div>
    </div>
    <div id="main-wrapper" class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">


                            <p class="counter"> {{App\User::where('is_customer',1)->count()}}</p>
                            <span class="info-box-title">Customers</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-users"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{App\User::where('is_seller',1)->count()}}</p>
                            <span class="info-box-title">Sellers</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-eye"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p>KES<span class="counter"> 
                                <?php 
                                $today = Carbon\Carbon::today();
                                $evening= $today->addHours(24);

                                $total=  App\Order::total_sales($today,$evening);

                                echo  $total;

                                ?>

                            </span></p>
                            <span class="info-box-title">Todays Sales </span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-basket"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">

                                {{App\Product::where('publish_status',1)->count()}}

                            </p>
                            <span class="info-box-title"> Products</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-envelope"></i>
                        </div>
                        <div class="info-box-progress">
                            <div class="progress progress-xs progress-squared bs-n">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->

        <div class="row">
            <div class="col-md-6">

                <div class="panel">
                    <div class="panel-body" style="min-height: 400px;padding: 0px 15px;">

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3>Latest  Seller Orders </h3>

                                <table id="or" class="table table-bordered">

                                    <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
                                        <tr>
                                            <th>Ref.</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Order Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($seller_orders as $order)

                                        <tr>
                                            <td>{{$order->order_reference}}</td>
                                            @if($order->order_detail != null)
                                            @if($order->order_detail->product != null)
                                            <td>{{$order->order_detail->product->name}} </td>
                                            @else
                                            <td></td>
                                            @endif
                                            @else
                                            <td></td>
                                            @endif

                                            <td>{{$order->order_detail->quantity}}</td>
                                            <td>{{$order->order_detail->created_at->format('d/m/Y H:i')}} ({{$order->order_detail->created_at->DiffForHumans()}})</td>

                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div  class="col-md-6">

                <div class="panel" style="">

                    <div class="panel-body" style="min-height: 400px;padding: 0px 15px;">

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3>Latest  Customer Orders </h3>
                                @if($order->user != null)
                                <table id="or" class="table table-bordered">

                                    <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
                                        <tr>
                                            <th>Ref.</th>
                                            <th>Customer</th>
                                            <th>Delivery Address</th>
                                            <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)

                                        <tr>
                                            <td>{{$order->order_reference}}</td>
                                            <td>{{$order->user->first_name}} {{$order->user->last_name}}, {{$order->user->phone}}, {{$order->user->email}}</td>
                                            <td>{!! $order->getDeliveryAddress() !!} </td>
                                            <td>{{$order->created_at->format('d/m/Y H:i')}} ({{$order->created_at->DiffForHumans()}})</td>

                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div><!-- Main Wrapper -->
    <div class="page-footer">
        <div class="container">
            <p class="no-s"> <?php echo  date('Y') ?> DIL.AFRICA</p>
        </div>
    </div>
    @endsection