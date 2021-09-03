	@extends('logistics::layouts.logistics_master')

	@section('content')
	<div id="main-wrapper" class="container" >
    <div class="row">
        <div class="col-md-6">

            <div class="panel">
          	<div class="panel-body" style="min-height: 400px;">

      		<div class="row">
        	<div class="col-lg-12 col-md-12">
            <h3>Latest  Seller Orders </h3>

              <table id="or" class="table table-bordered">

					<thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
						<tr>
						<th>Ref.</th>
						<th>Seller</th>
						<th>Product</th>
						<th>Qty</th>
						<th>Order Date</th>

						</tr>
					</thead>
					<tbody>

					@foreach($seller_orders as $order)
					<tr>
					<td>{{$order->order_reference}}</td>
					<td>{{ ucwords($order->seller->name) }}</td>
					@if($order->order_detail != null)
					@if($order->order_detail->product != null)
					<td>{{$order->order_detail->product->name}} </td>
					@endif
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
            
            <div class="panel">
          
          		<div class="panel-body" style="min-height: 400px;">

		      		<div class="row">
		        	<div class="col-lg-12 col-md-12">
		            <h3>Latest  Customer Orders </h3>

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
								<td>{{ ucwords($order->user->first_name)}} {{ ucwords($order->user->last_name) }}, {{$order->user->phone}}, {{$order->user->email}}</td>
								
								<td>{{$order->created_at->format('d/m/Y H:i')}} ({{$order->created_at->DiffForHumans()}})</td>
							</tr>

							@endforeach

							</tbody>
							</table>
						</div>
					</div>

		        </div>
        	</div>

           </div>
        </div>
    </div>
	@stop