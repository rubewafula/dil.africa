@extends('logistics::layouts.logistics_master')
@section('content')

<div  class="container">
           <div class="page-breadcrumb " >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h2> Received  Orders</h2>
                    </div>
                </div>
                <div  class="panel panel-white" >
                    <div  class="row">
                            			<div class="col-md-12">
                            				
                          <table class="table table-bordered" style="margin-left: 15px;width: 99%;">
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

           <a style="margin-bottom: 10px;" href="{{url('logistics/quality_passed/'.$order->id)}}" onclick=" return  confirm('You  are  about to  receive Order.Confirm')"  class="btn btn-success btn-sm" >  Quality  Passed</a> &nbsp;&nbsp;&nbsp;&nbsp;

           <!--  <a  href="{{url('logistics/reject_order/'.$order->id)}}"  class="btn  btn-danger  btn-sm"> Reject  Order </a> -->
           <button style="width: 110px;" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject{{$order->id}}">Quality  Failed</button>

           <div id="reject{{$order->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Quality Failed </h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{url('logistics/quality_failed')}}">
          {{csrf_field()}}
          <input type="hidden" name="seller_order_id"  value="{{$order->id}}">
          <input type="hidden" name="order_status"  value="QUALITY_FAILED">


          <div  class="form-group">
            <label>Quality  Issue</label>
            <?php  $quality_issues= App\Quality_issue::get(); ?>
            <select  name="quality_issue_id"  class="form-control">
              @foreach($quality_issues  as $issue)
              <option  value="{{$issue->id}}">{{$issue->name}}</option>
              @endforeach
</select>
          </div>
          <div  class="form-group">
            <label> Comments </label>
            <textarea name="quality_comments"  class="form-control" 
            ></textarea>

          </div>

          <div  class="form-group pull-right">
            <input type="submit" class="btn  btn-danger"  value="Proceed">

          </div>

        </form>
      </div>
      <div class="modal-footer">
<!--         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 -->      </div>
    </div>

  </div>
</div>

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