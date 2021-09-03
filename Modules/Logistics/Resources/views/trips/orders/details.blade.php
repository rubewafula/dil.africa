  @extends('logistics::layouts.logistics_master')

  @section('content')
    <div class="page-breadcrumb" >
       {{ Breadcrumbs::render() }}

    </div>

    <div class="page-title">
        <div class="container" class="blue-text" style="padding: 10px;font-size: 18px;">
            Trip ({{ $trip->name }})
        </div>
    </div>
    <div class="container">
      <div class="row">

        <div class="col-md-12">
            <div class="card">
  
                <div class="card-body">

                    <a href="{{ url('/logistics/trips/'.$trip->id.'/orders') }}" title="Back">
                      <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                    </a>
                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr><th> Trip Name</th><td> {{ $trip->name }} </td></tr>
                                <tr><th> Vehicle </th><td> {{ $trip->vehicle->registration_no }} </td></tr>
                                <tr><th> Status </th><td> {{ ($trip->active == 1)?"Active":"Inactive" }} </td></tr>
                            </tbody>
                        </table>
                    </div>
                    <style>
                      
                      .modal-header .close {
                          margin-top: -20px;
                      }
                    </style>
                    <div>

                      <div  class="row">

                        <div  class="col-md-6" style="color: #0F7DC2;font-size: 18px;"> 
                          Order Details
                        </div>
                        <div  class="col-md-6 col-sm-12 pull-right">
                            
                            @if($order->order_status != 'DELIVERED' && $order->order_status != 'RETURNED')
                            <a href="{{ url('/logistics/trips/orders/entire-order-delivered/'.$order->id) }}" class="btn btn-success btn-sm" title="Mark Entire Order as Delivered" style="margin-bottom: 10px;">
                              <i class="fa fa-plus" aria-hidden="true"></i> Mark Entire Order as Delivered
                            </a> 
                            <a data-target="#modal_entire_returned" class="btn btn-success btn-sm" title="Mark Entire Order as Returned" style="margin-bottom: 10px;background: #CC0000;" data-toggle="modal">
                              <i class="fa fa-plus" aria-hidden="true"></i> Mark Entire Order as Returned
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
                        THIS ORDER HAS BEEN MARKED AS {{$order->order_status}}
                        </span>
                        
                        @endif
                                                     
                        </div>
                      </div>

                      <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                        <thead style="background: #ccc;color:#0F7DC2;opacity: 0.7">
                            <tr>
                               <tr>
                                  <th>Order Ref</th>  
                                  <th>Customer</th> 
                                  <th>Mode of Delivery</th>
                                  <th>Delivery Address</th>
                                  <th>Date</th>
                              </tr>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td>{{ $order->order_reference }}</td>
                              <td>{{ $order->user->first_name }}, {{ $order->user->last_name }}, {{ $order->user->email_address }}, {{ $order->user->phone }}</td>
                              <td>{{ $order->shipping_type->name }}</td>
                              <td>{!! $order->getDeliveryAddress() !!} </td>
                              <td>{{ $order->created_at}}</td>
                          </tr>                              
                        </tbody>
                       </table>  

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                     <h4 class="panel-title"></h4> 
                </div>
                <div class="panel-body">
                   <div class="table-responsive">

                    <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                        <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                            <tr>
                               <tr>
                        <th>Product</th>  
                        <th>Quantity</th> 
                        <th>Action</th>
                    </tr>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order_details as $item)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td> 
                              @if($item->delivery_status != 'DELIVERED' && $item->delivery_status != 'RETURNED')
                                <a href="{{ url('/logistics/trips/orders/order-detail-delivered/' . $item->id) }}" title="Mark as Delivered"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;">Mark as Delivered</button></a>

                                <a data-target="#returned-item{{$item->id}}" title="Mark as Returned" data-toggle="modal"><button class="btn btn-primary btn-sm" style="background: #CC0000;">Mark as Returned</button></a>
                                <div class="modal fade" id="returned-item{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="Order_Return" aria-hidden="true">
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
                                            <input  type="hidden" name="order_detail_id" value="{{$item->id}}">

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
                              {{$item->delivery_status}}
                              @endif
                            </td>
                        </tr>
                      @endforeach
                          
                        </tbody>
                       </table>  

                    </div>
                </div>
            </div>
           
        </div>
    </div><!-- Row -->
</div><!-- Main Wrapper -->
<div class="page-footer">
    <div class="container">
        <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA</p>
    </div>
</div>
         
   @endsection