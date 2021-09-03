@extends('seller::layouts.master')
@section('content')
<script type="text/javascript">
  
  $(document).ready(function(){

    $('#ord').DataTable();

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
                        <h3> Welcome , {{Auth::user()->name }}  to  {{Auth::user()->seller->name}} 's  Seller Dashboard. Here you can manage your orders, products, promotions and much more!</h3>
                    </div>
                </div>

                <?php $seller= App\Seller::find(Auth::user()->seller_id); ?>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-6">

                            <div class="panel">
                          <div class="panel-body" style="min-height: 400px;">

                      	<div class="row">
                        <div class="col-lg-12 col-md-12">
                            <h3>Latest  Orders </h3>

                              <table id="or" class="table table-bordered">
  <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
    <tr>
      <th>Ref.</th>
      <th>Product</th>
      <th>Qty</th>
      <th>Order Date</th>
      <th>View</th>

     </tr>
  </thead>
  <tbody>

    @foreach($orders  as $order)
    @if($order->order_detail != null)
    <tr>
        <td>{{$order->order_reference}}</td>
        <td>{{$order->order_detail->product->name}} </td>
      
        <td>{{$order->order_detail->quantity}}</td>
        <td>{{$order->order_detail->created_at->format('d/m/Y H:i')}} ({{$order->order_detail->created_at->DiffForHumans()}})</td>
      
  <td> 
    <a  href="{{url('seller/manage_order/'.$order->id)}}" class="btn  btn-info" style="background: #0F7DC2;"> 
  Manage</a>
  </td>
  @endif

    </tr>


    @endforeach


  </tbody>
</table>
                        </div>
                    </div>
                            <!-- <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">

                                    	<?php $seller=  App\Seller::find(Auth::user()->seller_id); ?>
                                        <p class="counter">
                                         {{ number_format(count($seller->products))}}
                                        </p>
                                        <span class="info-box-title">Products</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-users"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">

                                        {{$seller->users->count()}}

                                    </p>
                                        <span class="info-box-title">Users</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-users"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                      
                    </div><!-- Row -->
 
                                	
                                    </div>
                                </div>

                            </div>

                            <div  class="col-md-6">
                                 <div class="panel">
                          <div class="panel-body" style="min-height: 400px;">
                               <div class="row">
                                <div class="col-md-7">
                                  <h3>Latest  Products</h3>
                                </div>
                                <div class="col-md-5">
                                   <a href="{{url('seller/product/classify')}}" class="btn btn-primary" style="float: right;background: #0F7DC2;"> Add a Product </a>
                                 </div>
                              </div>

                                <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#f5f5f5;color:#888">
    <tr>
      <th> Name </th>
 
      <th> Actions</th>

     </tr>
  </thead>
  <tbody>
       <form method="GET" action="{{ url('seller/products')}}" >
            <input type="hidden" name="search"  value="1">
            <tr>
                                                        
      <td>
       <input type="text" name="name">

          </td>
        
          <td>
            <input type="submit"  class="btn-success" style="margin-left: 15px;background: #ffa200;" value="Filter">
          </td>

        </tr>                              
  </form>

@if(count($seller->products) > 0)
@foreach($seller->products  as $product)
<tr>
    <td>{{$product->name}}</td>
      
     <td>
      
<a  href="{{ url('seller/product/'.$product->slug)}}" class="btn-warning btn-sm" style="background: #0F7DC2;">  
   Manage </a>

     </td>

</tr>


@endforeach

@else
<tr>
  <td  colspan="6"> You have  not added any  products</td>

</tr>
@endif

  </tbody>
</table>    


                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
              

@endsection