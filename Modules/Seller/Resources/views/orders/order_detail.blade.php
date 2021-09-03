@extends('seller::layouts.master')
@section('content')

<script type="text/javascript">
  
  $(document).ready(function(){

      $(".rejections").hide();

      $("#order_status").change(function(){

          var  status= $("#order_status").val();

          if(status ==='REJECT')
          {
            $(".rejections").show();

          } else{
             $(".rejections").hide();


          }

      });

  });

</script>

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Manage  Order #{{ $order->order_reference }} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                    <div class="panel-heading clearfix"> Items  Ordered</div>
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div  class="row">
                                        <div class="col-md-12">
                                            

                          <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#F89530;color:#fff">
    <tr>
      <th> Order Ref </th>
      <th> Product</th>
      <th> Product Variations</th>
      <th> Quantity</th>
      <th> Order Date </th>
      <th> Warehouse</th>
      <th> Actions</th>
      <th> Invoice </th>

     </tr>
  </thead>
  <tbody>

    <tr>
        <td>{{$order->order_reference}}</td>
       <td>{{$order->order_detail->product->name}} </td>
       <td>  
        <strong> Size: </strong> {{$order->order_detail->product_price->size}} <br/>
        <strong> Color: </strong> {{$order->order_detail->product_price->color}}

       </td>
        <td>{{$order->order_detail->quantity}}</td>
        <td>{{$order->order_detail->created_at->format('d/m/Y H:i')}} ({{$order->order_detail->created_at->DiffForHumans()}})</td>
        <td> 
          @if($order->order != null)
          @if(App\Warehouse::where('id', $order->order->warehouse_id)->exists())

            {{$order->order->warehouse->name}}

          @else
            N/A
          @endif
          @else

          N/A
          @endif

        </td>
        <td> 

         {{$order->order_status}}
<!--         &nbsp;&nbsp; <a  href="{{url('seller/manage_order/'.$order->id)}}"> Review</a>
 -->  

         <form  method="POST"  action="{{url('seller/process_order')}}">
            {{csrf_field()}}
            <input type="hidden" name="seller_order_id" value="{{$order->id}}">

            <div  class="form-group">
              <select class="form-control" name="order_status" id="order_status" required>
                <option  value=""> Select status</option>
                <?php

                   $statuses=[];
                 if($order->order_status == "CONFIRMED")
                 {
                    $statuses= ['ACCEPTED'=>'Accept Order','REJECTED'=>'Reject Order'];

                 }  

                 if($order->order_status =='ACCEPTED')
                 {

                  $statuses =['READY_FOR_PICKING'=>'Ready For Picking'];

                if($order->order->warehouse_id > 0)
                {
                     $statuses['SHIP_TO_WAREHOUSE']= 'Ship to Warehouse';
                }

                 }

                             
                  ?>

                @foreach($statuses  as $status => $value)

                <option  value="{{$status}}">{{$value}}</option>

                @endforeach
              </select>
            </div>

            <div  class="form-group  rejections">
              <label> Reason</label>
              <?php  $rejection_reasons=  App\Rejection_reason::get(); ?>
<select name="rejection_reason_id"  class="form-control">
              @foreach($rejection_reasons  as $rejection)
              <option  value="{{$rejection->id}}">{{$rejection->name}}</option>
              @endforeach
</select>
            </div>



              <input  type="submit"  class="btn  btn-primary" value="Continue">
            </div>

</form>       

  </td>
  <td> <a  href="{{url('seller/order_invoice/'.$order->id)}}" target="_BLANK" class="btn  btn-warning"> 
  View</a></td>

    </tr>



  </tbody>
</table>

                                        </div>

                                    </div>
                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection