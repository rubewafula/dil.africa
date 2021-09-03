      @extends('backend::layouts.master')
      @section('content')

      <div class="page-breadcrumb" >
        {{ Breadcrumbs::render() }}

      </div>
      <div class="page-title">
        <div class="container">
          <h3> Order 
            {{$order->order_reference}} from {{ ucwords($order->user->name)}}
            <span  class="pull-right"> Status:
              @if($order->order_status !== NULL)
              {{$order->order_status}}

              @else
              NEW
              @endif

            </span></h3>
          </div>
        </div>
        <div id="main-wrapper" class="container" >
          <div  class="top-sectionn">
            <div  class="row">

              <div  class="col-md-2">
               <div class="panel info-box panel-white" style="height: 100px">
                <div class="panel-body">
                  <div class="">
                   <p class="counter"> {{$order->created_at->format('j,F,Y H:i')}}</p>
                   <span class="info-box-title">Order  date </span>
                 </div>
                 <div class="info-box-icon">
                  <i class="icon-year"></i>
                </div>

              </div>
            </div>
          </div>

          <div  class="col-md-2">
           <div class="panel info-box panel-white"  style="height: 100px">
            <div class="panel-body">
              <div class="">
               <p class="counter">
                @if($order->shipping_cost > 0)

                KES {{ number_format($order->total_value + $order->shipping_cost) }}

                @else
                KES {{$order->total_value}}
                @endif
              </p>
              <span class="info-box-title">Total </span>
            </div>
            <div class="info-box-icon">
              <i class="icon-year"></i>
            </div>

          </div>
        </div>
      </div>

      <div  class="col-md-2">
       <div class="panel info-box panel-white"  style="height: 100px">
        <div class="panel-body">
          <div class="">
           <p class=""> {{$order->order_status}}</p>
           <span class="info-box-title">status </span>
         </div>
         <div class="info-box-icon">
          <i class="icon-year"></i>
        </div>

      </div>
    </div>
  </div>

  <div  class="col-md-2">
   <div class="panel info-box panel-white"  style="height: 100px">
    <div class="panel-body">
      <div class="">
       <p class="counter"> {{$order->order_details->count()}}</p>
       <span class="info-box-title">Products </span>
     </div>
     <div class="info-box-icon">
      <i class="icon-year"></i>
    </div>

  </div>
</div>
</div>
<div  class="col-md-2">
 <div class="panel info-box panel-white"  style="height: 100px">
  <div class="panel-body">
    <div class="">
     <p class="counter" style="color:#0F7DC2;font-weight: bold;">
      {{$order->payment_status}}

    </p>
    <span class="info-box-title">Payment  Status </span>
  </div>
  <div class="info-box-icon">
    <i class="icon-year"></i>
  </div>

</div>
</div>

</div>
<div  class="col-md-2">
 <div class="panel info-box panel-white"  style="height: 100px">
  <div class="panel-body">
    <div class="">
     <p class="counter">
      @if(\App\Payment_gateway::where('id',$order->payment_gateway_id))
      {{$order->payment_gateway->name}}

      @endif
    </p>
    <span class="info-box-title">Payment  Method </span>
  </div>
  <div class="info-box-icon">
    <i class="icon-year"></i>
  </div>

</div>
</div>
</div>

</div>

</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-white">
     <div class="panel-body">
       <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">

         <li role="presentation" class="active"><a href="#operations" role="tab" data-toggle="tab"> <span class="glyphicon glyphicon-files" aria-hidden="true"></span>   Operations</a></li>

         <li role="presentation"   ><a href="#products" role="tab"   data-toggle="tab">Product  Information</a></li>
         <li role="presentation"   ><a href="#customer" role="tab"   data-toggle="tab">Customer  Information</a></li>
         <li role="presentation"   ><a href="#supplier" role="tab"   data-toggle="tab">Supplier  Fullfillment</a></li>
         <li role="presentation"   ><a href="#shipping" role="tab"   data-toggle="tab">
         Shipping Information</a></li>
         <li role="presentation"   ><a href="#notes" role="tab"   data-toggle="tab">
         Notes</a></li>

         @php($order_payments = \App\Order_payment::where('order_id', $order->id)->get())

         @if(count($order_payments) > 0)
         <li role="presentation"   ><a href="#payments" role="tab"   data-toggle="tab">Order Payments</a></li>
         @endif
       </ul>
       <!-- Tab panes -->
       <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="operations">

          @if($order->order_status == "NEW" || $order->order_status == null)
          <div  class="row">
            <div  class="col-md-1">
              <a href="{{url('backend/accept_order/'.$order->id)}}" class="btn btn-success"> Accept Order</a>
            </div>
            <div  class="col-md-1">
              <a style="margin-left: 20px;" href="{{url('backend/cancel_order/'.$order->id)}}" class="btn btn-danger"> Cancel  Order</a>
            </div>
            <div class="col-md-1">
              <a style="margin-left: 40px;background-color: #FFA200;" href="{{url('backend/waybill/'.$order->id)}}" class="btn btn-danger" target="_blank">Waybill</a>
            </div>
            
            @if($order->payment_status != "PAID")
            <div  class="col-md-1">
              <form method="POST" action="{{url('backend/order/markaspaid')}}">

                {{ csrf_field() }}
                <input type="hidden" name="order_id" value="{{$order->id}}" />
                <button class="btn btn-danger" style="margin-left: 40px;background-color: #0F7DC2;">Mark as Paid</button>
              </form>
            </div>
            @endif

            @if($order->order_status != "CONFIRMED")
            <div  class="col-md-2">
              <form method="POST" action="{{url('backend/order/markasconfirmed')}}">

                {{ csrf_field() }}
                <input type="hidden" name="order_id" value="{{$order->id}}" />
                <button class="btn btn-danger" style="margin-left: 60px;background-color: #FFA200;">Confirm and Notify Seller</button>
              </form>
            </div>
            @endif

          </div>
          @elseif($order->order_status !=='CANCELLED')
          <div  class="row">

           <div class="col-md-1">
            <a  style="margin-left: 20px;" href="{{url('backend/cancel_order/'.$order->id)}}" class="btn btn-danger"> Cancel  Order</a>
          </div>
          <div  class="col-md-1">
              <a  style="margin-left: 40px;background-color: #FFA200;" href="{{url('backend/waybill/'.$order->id)}}" class="btn btn-danger" target="_blank">Waybill</a>
          </div>
          @if($order->payment_status != "PAID")
          <div  class="col-md-1">
            <form method="POST" action="{{url('backend/order/markaspaid')}}">

              {{ csrf_field() }}
              <input type="hidden" name="order_id" value="{{$order->id}}" />
              <button class="btn btn-danger" style="margin-left: 40px;background-color: #FFA200;">Mark as Paid</button>
            </form>
          </div>
          @endif
          @if($order->order_status != "CONFIRMED")
            <div  class="col-md-2">
              <form method="POST" action="{{url('backend/order/markasconfirmed')}}">

                {{ csrf_field() }}
                <input type="hidden" name="order_id" value="{{$order->id}}" />
                <button class="btn btn-danger" style="margin-left: 60px;background-color: #FFA200;">Confirm and Notify Seller</button>
              </form>
            </div>
            @endif
        </div>
        @endif
      </div>

      <div role="tabpanel" class="tab-pane" id="customer">
        @if(\App\User::where('id',$order->user_id)->exists())

        <p>
          <strong> Full  Name : </strong> {{$order->user->name}} <br/>

          <p>
            <strong> Telephone : </strong> {{$order->user->phone}} <br/>
          </p>
          <p>
            <strong> Email  Address : </strong> {{$order->user->email}} <br/>
          </p>

          @endif

        </div>

        <div role="tabpanel" class="tab-pane " id="products">
          <table  class="table">
            <thead>
              <tr>
                <th></th>
                <th> Supplier</th>
                <th> Supplier Contacts</th>
                <th> Product</th>
                <th> Price</th>
                <th> Qty</th>
                <th> Total</th>

              </tr>
            </thead>
            <tbody>
              @foreach($order->order_details  as $detail)
              <tr>
                <td>  

                  <?php $image= App\Product_image::where(['product_id'=> $detail->product_id, 'default'=>1])->first(); ?>

                  @if(!empty($image))
                  <img src="{{url('assets/images/products/'.$image->image_url)}}" width="50px" width="50px" alt="{{$detail->product->name}}"
                  />

                  @else
                  No image 
                  @endif

                </td>
                <td> <a href="{{url('backend/sellers/manage/'.$detail->product->seller_id)}}"> {{$detail->product->seller->name}}</a></td>
                <td>{{ $detail->product->seller->telephone  }} {{ ($detail->product->seller->telephone != $detail->product->seller->other_telephone)?", ".$detail->product->seller->other_telephone:"" }}, {{$detail->product->seller->email_address}}</td>
                <td>{{$detail->product->name}} @if($detail->product_price->size != null)  <span style="font-weight: bold;"> Size: </span> {{ ucwords($detail->product_price->size) }} @endif @if($detail->product_price->color != null)  <span style="font-weight: bold;"> Color: </span> {{ ucwords($detail->product_price->color) }} @endif</td>
                <td>{{$detail->price}}</td>
                <td>{{$detail->quantity}}</td>
                <td>{{ $detail->price *  $detail->quantity}}</td>

              </tr>

              @endforeach
            </tbody>

          </table>

          <div class="row"> 
            <div class="col-md-6"> 

            </div>
            <div class="col-md-6"> 
              <div class="voucher">
                <table class="table">
                  <tr> 

                    <th> Discount Name</th>
                    <th>  Value </th>
                  </tr>
                  @foreach($order->discounts as  $discount)
                  <tr> 
                    <td>{{$discount->name}}</td>
                    <td>{{$discount->value }}</td>

                  </tr>

                  @endforeach

                </table> 

              </div>

            </div>
          </div>

          <div class="row" style="margin-top:10px"> 
            <div class="col-md-6"> 

            </div>
            <div class="col-md-6"> 
              <div class="voucher">
                <table class="table">
                  <tr> 

                    <th> Discount </th>
                    <th>  {{$order->discounts->sum('value')}} </th>
                  </tr> 
                  <tr>

                   <th>   Shipping Charges</th>

                   <td> {{number_format($order->shipping_cost)}} </td>
                 </tr>
                 <tr>
                   <th> Total </th>
                   <th> {{number_format($order->total_value + $order->shipping_cost)}}</th>
                 </tr>

               </table> 

             </div>

           </div>
         </div>
       </div>
       <div role="tabpanel" class="tab-pane " id="supplier">
        <table  class="table">
          <thead>
            <tr>
              <th></th>
              <th> Supplier</th>
              <th> Product</th>
              <th> Price</th>
              <th> Qty</th>
              <th> Status</th>
              <td></td>

            </tr>
          </thead>
          <tbody>
            @foreach($order->order_details  as $detail)
            <tr>
              <td>  
                <?php $image= App\Product_image::where(['product_id'=>$detail->product_id,'default'=>1])->first(); ?>
                @if(!empty($image))
                <img src="{{url('assets/images/products/'.$image->image_url)}}" width="50px" width="50px" alt="{{$detail->product->name}}"
                />

                @else
                No image 
                @endif

              </td>
              <td> <a href="{{url('backend/sellers/manage/'.$detail->product->seller_id)}}"> {{$detail->product->seller->name}}</a></td>
              <td>{{$detail->product->name}}</td>
              <td>{{$detail->price}}</td>
              <td>{{$detail->quantity}}</td>

               <?php $seller_order= App\Seller_order::where('order_detail_id',$detail->id)->first();  ?>

               @if(!empty($seller_order))

               <td> 
                 @if($seller_order->shipping_status_id > 0)

                 {{$seller_order->shipping_status->name}}

                 @else

                 NEW

                 @endif

                 @if($seller_order->shipping_status_id == 1 || $seller_order->shipping_status_id == 2)

                 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#receive{{$seller_order->id}}">Receive </button>

                 <div id="receive{{$seller_order->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Receive Products  to  Warehouse</h4>
                      </div>
                      <div class="modal-body">
                        <p> 
                          <form  method="POST" action="{{url('backend/receive_products')}}">

                            <input  type="hidden" name="seller_order_id" value="{{$seller_order->id}}">
                            <input  type="hidden" name="product_id" value="{{$detail->product_id}}">

                            {{csrf_field()}}
                            <div  class="row">
                              <div  class="col-md-6">
                                <div  class="form-group">
                                  <label> Select  Warehouse</label>
                                  <select  name="warehouse_id"  class="form-control">
                                    <?php $warehouses= App\Warehouse::get(); ?>

                                    @foreach($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}">  {{$warehouse->name}}</option>
                                    @endforeach

                                  </select>
                                </div>
                              </div>
                            </div>

                            <div  class="row">
                              <div  class="col-md-6">
                                <div  class="form-group">
                                  <label>Quantity</label>
                                  <input type="text" name="quantity" class="form-control">
                                </div>
                              </div>
                            </div>
                            <div  class="row">
                              <div  class="col-md-6">
                                <div  class="form-group">
                                  <input type="submit"  class="btn btn-warning"  value="Receive">
                                </div>
                              </div>
                            </div>
                          </form>
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>

                @endif 

                @endif        


              </td>
              <td> 
                <a style="margin-left: 40px;background-color: #FFA200;" href="{{url('backend/po/'.$detail->id)}}" class="btn btn-danger" target="_blank">Purchase Order</a>
              </td>

            </tr>

            @endforeach

          </tbody>

        </table>

      </div>

      @if(count($order_payments) > 0)
      <div role="tabpanel" class="tab-pane " id="payments">
        <table  class="table">
          <thead>
            <tr>
              <th> Transaction Code</th>
              <th> Transaction Date</th>
              <th> Amount</th>

            </tr>
          </thead>
          <tbody>
            @foreach($order_payments  as $payment)
            <tr>
              <td>{{$payment->transaction_code}}</td>
              <td>{{$payment->transaction_date}}</td>
              <td>{{$payment->amount}}</td>
            </tr>
            @endforeach

          </tbody>

        </table>

      </div>
      @endif

      <div role="tabpanel" class="tab-pane " id="shipping">
        <div  class="row">

          <div  class="col-md-12">
            @if($order->shipping_type_id == 2)
            @if(\App\User_address::where('id',$order->user_address_id))

            <p>

             <strong> Delivery Address:</strong>

             {{$order->user_address->delivery_address}}

             <br/>
             <strong>  Area: </strong>

             {{$order->user_address->google_area}}

             <br/>
             <strong>  Street/ Building / Floor: </strong>

             {{$order->user_address->street.' ,'.$order->user_address->building}}
             <br/>

             <strong>  City: </strong>
             @if(\App\City::where('id',$order->user_address->city_id)->exists())
             {{$order->user_address->city->name}}
             @endif
             <br/>

             <strong>  Country: </strong>
             @if(\App\City::where('id',$order->user_address->country_id)->exists())
             {{$order->user_address->country->name}}
             @endif
             <br/>
           </p>
           @endif
           @else
           <p>

             <strong> Pickup Station:</strong>
             @php($pickup_location = \App\User_pickup_location::findorfail($order->user_address_id))
             @if($pickup_location != null)
             @php($warehouse = \App\Warehouse::findorfail($pickup_location->warehouse_id))
             @if($warehouse != null)
             {{$warehouse->name}}
             @endif

             <br/>
             <strong>  Contact Phone: </strong>

             @if($warehouse != null)
             {{$order->user->phone}}
             @endif

             <br/>

             <strong>  City: </strong>
             @if(\App\City::where('id',$warehouse->city_id)->exists())
             {{$warehouse->city->name}}
             @endif
             @endif
           </p>

           @endif

         </div>

       </div>

     </div>

     <div role="tabpanel" class="tab-pane " id="notes">
      <div  class="row">
        <div  class="col-md-12">

          <h3> Order notes  </h3>

          @if(count($order->order_notes) > 1)

            @foreach($order->order_notes as  $note)

          <p> {{$note->note}}

            <span  class="pull-right"><sub>  

              @if(\App\User::where('id',$note->user_id)->exists())
              {{$note->user->name}}  on {{$note->created_at->format('j,F,Y H:i')}} ({{$note->created_at->DiffForHumans()}})
              @endif
            </sub>

            @if($note->user_id == Auth::user()->id)
            <a  href="{{url('backend/delete_note/'.$note->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">Delete</a>

            @endif
          </span>  </p>


          @endforeach

          @endif

        </div>
      </div>


      <form  method="POST"  action="{{url('backend/post_note')}}">
        {{csrf_field()}}
        <input type="hidden" name="user_id"  value="{{Auth::user()->id}}">
        <input type="hidden" name="order_id"  value="{{$order->id}}">

        <div  class="row">

          <div  class="col-md-12">
            <div  class="form-group">
              <label> Message</label>
              <textarea  class="form-control" name="note"></textarea>

            </div>

          </div>
        </div>

        <div  class="row">

          <div  class="col-md-12">
            <div  class="form-group">
             <input type="submit" value="Post" class="btn  btn-primary btn-sm">

           </div>

         </div>
       </div>

     </form>


   </div>


 </div>
</div>

</div>
</div>
</div>
</div>
</div>

@endsection