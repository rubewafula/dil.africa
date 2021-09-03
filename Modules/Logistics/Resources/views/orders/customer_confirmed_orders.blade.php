@extends('logistics::layouts.logistics_master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     
                               <div class="panel-heading clearfix"> <strong>Customer Confirmed Orders </strong> Awaiting  Shipment</div>

                            <div class="panel panel-white">
                            	    <div class="panel-body">
 <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Ref </th>
      <th> Order Details</th>
      <th> Delivery Location</th>
      <th> Order Date </th>
      <th> Assigned To </th>
     </tr>
  </thead>

    <tbody>
     @foreach($orders  as $order)
     <tr>
     	<td> {{$order->order_reference}} </td>
     	<td>  
     		@foreach($order->order_details  as $detail) 
        @if($detail != null)
     		   <ol>
     		   	<li>
              <u> Product: {{str_limit($detail->product->name, 50,'...')}} </u>
                Qty:{{$detail->quantity }} <br/>
              <a href="">By {{$detail->product->seller->name}} </a>
            </li>
     		   </ol>
        @endif
     		@endforeach

     	</td> 
      <td>
         {!! $order->getDeliveryAddress() !!}
      </td>
      <td>
      {{$detail->created_at->format('Y-m-d H:i')}} 
      ({{$detail->created_at->DiffForHumans()}})    
          </td>
    <td> 
         <form method="POST"  action="{{url('logistics/assign_warehouse')}}">
            {{csrf_field()}}
            <input type="hidden" name="order_id" value="{{$order->id}}">

            <div class="form-group">

              <?php $warehouses = App\Warehouse::pluck('name', 'id')->prepend('Select Warehouse', ''); ?>

              {{Form::select('warehouse_id', $warehouses, $order->warehouse_id or '',['class'=>'form-control'])}}

              <input  style="margin-top: 10px;" type="submit"  class="btn  btn-primary blue-bg" value="Ship to Selected Warehouse">

            </div>
    </form>  

    <a href="{{url('logistics/direct-shipment/'.$order->id)}}">
      <button class="btn  btn-success orange-bg" style="margin-left: 0px;">Direct Shipment to Customer</button>
    </a>   

    </td>

     </tr>

     @endforeach

  </tbody>
</table>
                                	
                </div>
            </div>

        </div>
    </div>
</div>
              

@endsection