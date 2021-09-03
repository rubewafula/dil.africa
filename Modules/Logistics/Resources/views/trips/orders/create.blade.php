@extends('logistics::layouts.logistics_master')
 
@section('content')
<div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}
</div>
<div id="main-wrapper" class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
      
                    <div class="card-body">
                        <a href="{{ url('/logistics/trips/'.$trip->id.'/orders') }}" title="Back">
                          <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr><th> Trip Name</th><td> {{ $trip->name }} </td></tr>
                                <tr><th> Vehicle </th><td> {{ $trip->vehicle->registration_no }} </td></tr>
                                <tr><th> Status </th><td> {{ ($trip->active == 1)?"Active":"Inactive" }} </td></tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 style="font-weight: bold;background: #eee;padding: 10px;"> Add Order to this Trip </h3>
                </div>
                 
                <div class="panel-body">
                                            
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div>
                        
                        <table id="or" class="table table-bordered">
                            <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
                                <tr>
                                    <th>Ref.</th>
                                    <th>Customer</th>
                                    <th>Items Ordered</th>
                                    <th>Delivery Address</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->order_reference}}</td>
                                <td>{{$order->user->first_name}} {{$order->user->last_name}}, {{$order->user->phone}}, {{$order->user->email}}</td>
                                <td>{!! $order->getItemsOrdered() !!} </td>
                                <td>{!! $order->getDeliveryAddress() !!} </td>
                                <td>{{$order->created_at->format('d/m/Y H:i')}} ({{$order->created_at->DiffForHumans()}})</td>
                                <td>
                                    <a href="{{ url('/logistics/trips/orders/add-to-trip/'.$trip->id.'/' . $order->id) }}" title="Add to Trip"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;">Add</button></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                  
                </div>
            </div>         
        </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->
<div class="page-footer">
    <div class="container">
        <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA </p>
    </div>
</div>
       
 @endsection