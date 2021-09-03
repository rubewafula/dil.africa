@extends('logistics::layouts.logistics_master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     
                               <div class="panel-heading clearfix"> <strong>Validated  Orders: </strong> Awaiting  Warehouse Allocation</div>

                            <div class="panel panel-white">
                            	    <div class="panel-body">
 <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Ref </th>
      <th> Order Details</th>
      <th> Delivery Location</th>
      <th> Order Date </th>
      <!-- <th> Assigned To </th> -->
     </tr>
  </thead>

    <tbody>
     @foreach($orders  as $order)
     <tr>
     	<td> {{$order->order_reference}} </td>
     	<td>  
  
        @if($order->order_detail != null)
     		   <ol>
     		   	<li>
              <u> Product: {{str_limit($order->order_detail->product->name, 50,'...')}} </u>
                Qty:{{$order->order_detail->quantity }} <br/>
              <a href="">By {{$order->order_detail->product->seller->name}} </a>
            </li>
     		   </ol>
        @endif

     	</td> 
      <td>

         {!! $order->order->getDeliveryAddress() !!}
        }
        }
      </td>
      <td>
      {{$order->created_at->format('Y-m-d H:i')}} 
      ({{$order->created_at->DiffForHumans()}})    
          </td>
    <!-- <td> 
         <form method="POST"  action="{{url('logistics/assign_warehouse')}}">
            {{csrf_field()}}
            <input type="hidden" name="order_id" value="{{$order->id}}">

            <div class="form-group">

              <?php $warehouses = App\Warehouse::pluck('name', 'id')->prepend('Select Warehouse', ''); ?>

              {{Form::select('warehouse_id', $warehouses, $order->warehouse_id or '',['class'=>'form-control'])}}

              <input  style="margin-top: 10px;" type="submit"  class="btn  btn-primary blue-bg" value="Ship to Selected Warehouse">

            </div>
    </form>     

    <form method="POST" action="{{url('logistics/direct_shipment')}}">
        
        {{csrf_field()}}
        <input type="hidden" name="order_id" value="{{$order->id}}">

        <div class="form-group">

          <input type="submit"  class="btn  btn-success orange-bg" value="Direct Shipment to Customer">

        </div>
    </form>

    </td> -->

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