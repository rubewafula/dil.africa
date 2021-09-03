@extends('logistics::layouts.logistics_master')
@section('content')

<div  class="container">
           <div class="page-breadcrumb " >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                      <div class="col-md-4">
                        <a href="{{ url('/logistics/customer/orders/'.$referrer) }}" title="Back"><button class="btn btn-warning btn-sm" style="margin: 20px 0px 0px -30px;" ><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                      </div>
                    <div class="col-md-8">
                        <h2> Order Details, Order Reference <span style="color: #0F7DC2;"> {{ $order->order_reference }} </span></h2>
                      </div>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                      <div class="col-md-12">
                            				
    <table class="table table-bordered" style="margin-left: 15px;width: 99%;">
      <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
        <tr>
          <th> Product Name </th>
          <th> Quantity </th>
          <th> Seller Name</th>
          <th> Seller Address</th>
          <th> Seller Telephone No.</th>
          <th> Seller Email Address</th>
          @if($referrer == 'direct-shipment')
          <th>Action</th>
          @endif
        </tr>
      </thead>
      <tbody>

  	@foreach($order_details as $order_detail)

    @php($seller_order = \App\Seller_order::where('order_detail_id', $order_detail->id)->first())
    @php($seller = \App\Seller::find($seller_order->seller_id))
  	<tr>
  		<td> {{ $order_detail->product->name }} </td>
  	  <td> {{ $order_detail->quantity }} </td>
      <td> {{ $seller->name }}</td>
      <td> {{ $seller->physical_location }}</td>
      <td> {{ $seller->telephone }}</td>
      <td> {{ $seller->email_address }}</td>
      @if($referrer == 'direct-shipment')
      <td>
      @if($order_detail->delivery_status != 'DELIVERED' && $order_detail->delivery_status != 'RETURNED')
      <a href="{{ url('/logistics/trips/orders/order-detail-delivered/' . $order_detail->id) }}" title="Mark as Delivered"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;">Mark as Delivered</button></a>

      <a data-target="#returned-item{{$order_detail->id}}" title="Mark as Returned" data-toggle="modal"><button class="btn btn-primary btn-sm" style="background: #CC0000;">Mark as Returned</button></a>
      <div class="modal fade" id="returned-item{{$order_detail->id}}" tabindex="-1" role="dialog" aria-labelledby="Order_Return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: #0F7DC2;color: #fff;">
              <h5 class="modal-title" id="exampleModalLongTitle"> Order Item Returned</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="padding: 15px;">

              <div class="row" style="margin:0px;">
                <form  class="form-horizontal" method="POST" action="{{url('logistics/trips/orders/order-detail-returned')}}">
                  {{csrf_field()}}
                  <input  type="hidden" name="order_detail_id" value="{{$order_detail->id}}">

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
    {{$order_detail->delivery_status}}
    @endif
    </td>
    @endif
  	</tr>

  	@endforeach

  </tbody>
</table>
</div>
</div>	
</div>
</div>

@endsection