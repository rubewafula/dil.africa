@extends('accounts::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Order  Ref : #{{$order->order_reference}} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container " style="background: #fff">

                	<div class="row">
                		<div  class="col-md-8">
                			<table class="table">
                					<tr>
                					<th> Order  Status :</th>
                					<td> 
                						@if($order->order_status == NULL)

                						PENDING
                						@else
                						{{$order->order_status}} 
               						@endif


                					</td>

                				</tr>
                				<tr>
                					<th> Order Ref :</th>
                					<td>{{$order->order_reference}} </td>

                				</tr>
                					<tr>
                					<th> Order Date :</th>
                					<td>{{$order->order_date}} </td>

                				</tr>
                				
                					<tr>
                					<th> Product :</th>
                					<td>
                						@if(isset($order->order_detail->product->name))

                				  {{$order->order_detail->product->name}}

                				  @endif

                			      </td>

                			      		

                				</tr>
                				<tr>
                					<th> SKU : </th>
                					<td>
                					@if(isset($order->order_detail->product_price->seller_code))

                				   SKU-{{$order->order_detail->product_price->seller_code}}-{{$order->order_detail->product_price->skuid}}

                				   @endif

                			      </td>
                				</tr>
                				<th> Size : </th>
                					<td>
                					@if(isset($order->order_detail->product_price->size))

                				  {{$order->order_detail->product_price->size}}
                				   @endif

                			      </td>
                				</tr>
                				<th> Color : </th>
                					<td>
                					@if(isset($order->order_detail->product_price->color))

                				   {{$order->order_detail->product_price->color}}

                				   @endif

                			      </td>
                				</tr>
                				
                				<tr>
                					<th> Price : </th>
                					<td>
                                 @if(isset($order->order_detail->price))

                				 Ksh {{ number_format($order->order_detail->price)}}

                				  @endif


                					  </td>
                				</tr>
                				<tr>
                			       @if($order->order_status !=='ACCEPTED')

                					<td> <a  href="{{url('accounts/confirm_order/'.$order->id)}}" class="btn btn-success"> Confirm  Availability </a></td>

                					@endif


                					@if($order->order_status !=='CANCELLED')
                					 <td> <a  href="{{url('accounts/cancel_order/'.$order->id)}}"  onclick=" return  confirm('Are you sure?')" class="btn btn-danger"> Cancel Order</a>  </td>

                					 @endif

                					<td> <a href="" class="btn btn-primary"> Push to DIL  FIRE</a> </td>

                				</tr>


                			</table>

                		</div>

                		<div  class="col-md-4">
                			<h3> Product  Images</h3>

                			<a  href="{{url('shop/product/detail/'.$order->order_detail->product->slug)}}" target="_BLANK" class="btn  btn-primary"> Preview Product </a>

                			  <h3> Order notes  </h3>

        @if(count($order->notes) < 1)



        @endif

      @foreach($order->notes as  $note)

      <p> {{$note->note}}  <br/>

      <span  class="pull-right"> By  <sub>  

      @if(\App\User::where('id',$note->user_id)->exists())
        {{$note->user->name}}  on {{$note->created_at->format('j,F,Y H:i')}} ({{$note->created_at->DiffForHumans()}})
       @endif
         </sub>

         @if($note->user_id == Auth::user()->id)
         <br/>
         <a  href="{{url('accounts/delete_note/'.$note->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">Delete</a>

         @endif
         </span>  </p>


      @endforeach


   

            
<form  method="POST"  action="{{url('accounts/post_note')}}">
    {{csrf_field()}}
    <input type="hidden" name="user_id"  value="{{Auth::user()->id}}">
        <input type="hidden" name="order_id"  value="{{$order->order_reference}}">
       <input type="hidden" name="seller_order_id"  value="{{$order->id}}">
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

 @endsection