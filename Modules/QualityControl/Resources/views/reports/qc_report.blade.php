@extends('seller::layouts.master')
@section('content')

<script type="text/javascript">
  $(document).ready(function(){
    $("#from").datepicker({
      format:"yyyy-mm-dd"

    });

      $("#to").datepicker({
      format:"yyyy-mm-dd"

    });

      $("#orders").DataTable();

  });

</script>

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Sales  Reports </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> </div>

                            <div class="panel panel-white">
                            <div class="panel-body">

                              <table class="table">
                                <tr> <td  colspan="2">
                                  Filter  your sales

                                </td></tr>
                               <form  method="GET" action="{{url('seller/sales_report')}}">
                                <input  type="hidden" name="sales_report" value="1">
                                 <tr>
                                   <td> <input type="text" name="from" id="from" class="form-control" placeholder=" From" required></td>
                                   <td>
                                     
                                     <input type="text" name="to" id="to" class="form-control" placeholder="To" required>
                                   </td>
                                   <td>
                                     <input type="submit" value="Filter"  class="btn btn-primary">

                                   </td>
                                   <td>  <a href="{{url('seller/sales_report')}}" class="btn  btn-success"> Refresh</a></td>
                                 </tr>

                               </form>
                              </table>
                              <div  class="row">
                                <div  class="col-md-12">
                                   <p>Number of  records: {{count($orders)}}</p>

                                </div>

                              </div>
                            	 <table id="orders" class="table table-bordered">
  <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
    <tr>
      <th> Order  Date </th>
      <th> Order Ref </th>
      <th> Product</th>
      <th> Category</th>
      <th> Quantity</th>
      <th> Total Price </th>

    

     </tr>
  </thead>
  <tbody>

  	@foreach($orders  as $order)

  	<tr>
  		 <td>{{$order->order_detail->created_at->format('d/m/Y H:i')}} </td>

  		<td>{{$order->order_reference}}</td>
  	   <td>{{$order->order_detail->product->name}} </td>
  	   <td> 
  	   	@if(App\Category::where('id',$order->order_detail->product->category_id)->exists())
  	   	{{$order->order_detail->product->category->name}} 
  	   	@endif

  	   </td>
  	   <td>{{$order->order_detail->quantity}}</td>

       <td>  
         <?php $total_price= $order->order_detail->price  *  $order->order_detail->quantity ?>

         {{ number_format($total_price)}}

       </td>

  	</tr>

  	@endforeach
  </tbody>
  <tfoot>
  	<tr>
  		<td></td>
  		<td></td>
  		<td></td>
  		<td colspan="2"> Total Sales :</td>
  		<td> </td>

  	</tr>
  </tfoot>
</table>


                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection