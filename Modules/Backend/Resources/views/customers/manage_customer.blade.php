@extends('backend::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Information  about  Customer {{$customer->name}} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >

                	<div  class="row">
                		     <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading">
            <h4 class="panel-title">Profile  information </h4>
                                    <div class="panel-control">
                                       <span  class="pull-right">  CUSTOMER ID: [{{$customer->id}}] </span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="inbox-widget slimscroll">
                                     <p> Name : {{$customer->name}} <br/>

                                          Gender: {{$customer->gender}} <br/>

                                          Date  of Birth: {{$customer->dob}}


                                     </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                		     <div class="col-md-6">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Notes</h4>
                                    <div class="panel-control">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Reload" class="panel-reload"><i class="icon-reload"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="inbox-widget ">
                                       <form method="POST" action="{{ url('backend/notes/add_note')}}">
                                       	{{csrf_field()}}
                                       	<input  type="hidden" name="user_id" value="{{$customer->id}}">
                                       		<div class="form-group">
                                       			<label> Note</label>
                                       			<textarea name="note" class="form-control"></textarea>
                                       		</div>
                                            <div  class="form-group">
                                            	
                                            	<span class="pull-right">
                                            		<input type="submit" class="btn  btn-success" value="Send" >
                                            	</span>
                                            </div>
                                       	

                                       </form>

                                       @if($customer->notes->count() > 0)

                                       <hr/>
                                       @foreach($customer->notes  as $note)
                                       <div  class="row">
                                       	<div  class="col-md-12">
                                       <p>
                                       	{{$note->note}}  <a href="{{url('backend/delete_note/'.$note->id)}}"
                                       	 onclick="return confirm('Are you  sure?')"> delete</a>

                                        <span  class="pull-right">
                                       	
                                       @if($note->created_by > 0)

                                       <?php $user=  App\User::find($note->created_by) ?>
                                       <i>By : {{$user->name}}</i>
                                       @endif

                                       </span></p>
                                       <hr/>
                                       </div>
                                       </div>
                                       @endforeach

                                       @else
                                       <p>There  are  no notes</p>
                                       @endif
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                		

                	</div>

                	<div  class="row">
                		                        <div class="col-md-6">
                		                        	  <div class="col-lg-12 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Orders ({{$customer->orders->count()}})</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Payment Form</th>
                                                   <th>Status</th>
                                                   <th>Products</th>
                                                   <th>Total  Amount</th>
                                                   <th></th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               @foreach($customer->orders  as $order)
                                               <tr>
                                                 <td>{{$order->order_reference}}</td>
                                                 <td> 
                                                  @if(App\Payment_gateway::where('id',$order->payment_gateway_id)->exists())
                                                  {{$order->payment_gateway->name}}
                                                  @endif

                                                  </td>
                                                  <td>{{$order->order_status}} </td>
                                                  <td>
                                                    {{$order->order_details->count()}}

                                                  </td>
                                                  <td>
                                                    
                                              {{number_format($order->total_value)}}
                                                  </td> 
                                                  <td>
                                                    
                                                    <a  href="{{url('backend/customer/order/'.$order->id)}}" class="btn-success btn-sm"> View</a>
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
                                            <div class="col-md-6">
                                                <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">User  Addresses</h4>
                                </div>
                                <div class="panel-body">
                                  <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>Address type</th>
                                                   <th>Delivery  Address</th>
                                                   <th>Location</th>
                                                   <th>Landmark</th>
                                                   <th>Telephone</th>
                                                   <th></th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                            @foreach($customer->addresses  as $address)
                                            <tr>
                                              <td>{{$address->address_type}}</td>
                                              <td>{{$address->delivery_address}}</td>
                                              <td> 
                                        @if(App\Area::where('id',$address->area_id)->exists())
                                                {{$address->area->name}},
                                                @endif
                                                 @if(App\City::where('id',$address->city_id)->exists())
                                                {{$address->city->name}},
                                                @endif
                                                 @if(App\Country::where('id',$address->country_id)->exists())
                                                {{$address->country->name}},
                                                @endif
                                              </td>
                                              <td>
                                                
                                                {{$address->landmark}}
                                              </td>
                                              <td>
                                                {{$address->telephone}}
                                              </td>
                                              <td>
                                             @if($address->default > 0)
                                               Default  Address

                                             @endif   

                                              </td>

                                            </tr>
                                            @endforeach

                                            </tbody>
                                          </table>
                                </div>
                            </div>
</div>

                <!--     <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> Header</div>

                            <div class="panel panel-white">
                            	                                <div class="panel-body">

                                	
                                    </div>
                                </div>

                            </div>
                        </div> -->
                    </div>
              

@endsection