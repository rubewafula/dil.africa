@extends('logistics::layouts.logistics_master')
@section('content')

<div  class="container">
           <div class="page-breadcrumb " >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Quality  Passed Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                            			<div class="col-md-12">
                            				
                          <table class="table table-bordered" style="width: 99%;margin-left: 15px;">
  <thead class="thead-dark" style="background-color:#ffa200;color:#fff">
    <tr>
      <th> Supplier</th>
      <th> Order Ref </th>
      <th> Product</th>
      <th> Product Variation </th>
      <th> Quantity</th>
      <th> Order  Date </th>
      <th> Status</th>
      <th> Action</th>
     </tr>
  </thead>
  <tbody>

  	@foreach($seller_orders  as $order)

  	<tr>
  		<td> <a  href="{{url('logistics/supplier/'.$order->seller_id)}}" target="_BLANK"> {{$order->seller->name}}</a> </td>
  		<td>{{$order->order_reference}}</td>
  	     <td>{{$order->order_detail->product->name}} </td>
  	     <td>   
  	     	 <p>  
  	     	 	Color: {{$order->order_detail->product_price->color}}  <br/>
  	     	 	Size:   {{$order->order_detail->product->size}} <br/>
  	     	 </p>

  	     </td>
        <td>{{$order->order_detail->quantity}}</td>
        <td>{{$order->order_detail->created_at->format('d/m/Y H:i')}}</td>

        <td>    {{$order->order_status}}
</td>
       <td> 

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