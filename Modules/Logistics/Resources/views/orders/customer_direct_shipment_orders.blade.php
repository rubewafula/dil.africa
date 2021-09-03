@extends('logistics::layouts.logistics_master')
@section('content')

<div  class="container">
           <div class="page-breadcrumb " >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Direct Shipment Orders</h2>
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
      <th> Order Status </th>
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
           
           @if($order->order_status != 'DELIVERED' && $order->order_status != 'RETURNED')
          <a href="{{ url('/logistics/trips/orders/entire-order-delivered/'.$order->id) }}" class="btn btn-success btn-sm" title="Mark Order as Delivered" style="margin-bottom: 10px;">
            <i class="fa fa-plus" aria-hidden="true"></i> Mark Order as Delivered
          </a> 
          <a data-target="#modal_entire_returned" class="btn btn-success btn-sm" title="Mark Order as Returned" style="margin-bottom: 10px;background: #CC0000;" data-toggle="modal">
            <i class="fa fa-plus" aria-hidden="true"></i> Mark Order as Returned
          </a>
          <div class="modal fade" id="modal_entire_returned" tabindex="-1" role="dialog" aria-labelledby="Order_Return" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background: #0F7DC2;color: #fff;">
                  <h5 class="modal-title" id="exampleModalLongTitle"> Order Returned</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="padding: 15px;">

                  <div class="row" style="margin:0px;">
                    <form  class="form-horizontal" method="POST" action="{{url('logistics/trips/orders/entire-order-returned')}}">
                      {{csrf_field()}}
                      <input  type="hidden" name="order_id" value="{{$order->id}}">

                      <label for="return_comments">Return Comment</label>
                      <textarea rows="5" name="return_comments" class="form-control"></textarea>
                      <input type="submit" value="Save" class="btn btn-sm btn-success" style="margin-top: 10px;background: #0F7DC2;">
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div> 
      @else
      <span style="color: #0F7DC2;">
      {{$order->order_status}}
      </span>
      
      @endif

      <a style="margin-bottom: 10px;width: 176px;" href="{{url('logistics/order-details/'.$referrer.'/'.$order->id)}}" class="btn btn-success btn-sm orange-bg">  View Order Details</a>
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