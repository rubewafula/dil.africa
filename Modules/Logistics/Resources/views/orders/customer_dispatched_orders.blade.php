@extends('logistics::layouts.logistics_master')
@section('content')

<div  class="container">
           <div class="page-breadcrumb " >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Dispatched Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                      <div class="col-md-12">
                            				
                    <table class="table table-bordered" style="margin-left: 15px;width: 99%;">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Order Ref </th>
      <th> Customer Name</th>
      <th> Email Address </th>
      <th> Order Value</th>
      <th> Order  Status </th>
      <th> Ordered At</th>
      <th> Action</th>
     </tr>
  </thead>
  <tbody>

  	@foreach($orders as $order)

  	<tr>
  		<td>{{$order->order_reference}}</td>
  	     <td>{{$order->user->first_name}} {{$order->user->last_name}}</td>
  	     <td>   
          {{$order->user->email}}
  	     </td>
         <td>{{$order->total_value}}</td>
        <td>{{$order->order_status}}</td>
        <td>{{$order->created_at->format('d/m/Y H:i')}}</td>
        <td> 
           <a style="margin-bottom: 10px;" href="{{url('logistics/order-details/'.$referrer.'/'.$order->id)}}" class="btn btn-success btn-sm" >  View Order Details</a>
        </td>
  	</tr>

  	@endforeach

  </tbody>
</table>
</div>
</div>	
</div>
</div>

@endsection