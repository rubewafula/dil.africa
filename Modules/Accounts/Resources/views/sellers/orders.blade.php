@extends('accounts::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Orders </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container " style="background: #fff">


                	  <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                            <tr>
                                               <tr>
                                    <th>Seller</th>
                                    <th> Order ref </th>
                                    <th> Order  Time </th>
                                    <th>Delivery  Due  date </th>
                                   <th>Status</th>
                                    <th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                       @foreach($orders  as $order)

                                       	<tr>  
                                       		<td> 
                                       		@if(App\Seller::where('id',$order->seller_id)->exists())

                                       		{{$order->seller->name}}

                                      		@endif 

                                       		</td>
                                       		<td>  
                                            <a href="{{url('accounts/seller_order/'.$order->id)}}" target="_BLANK"  >  {{$order->id}}  </a>

                                       		</td>
                                       		<td>  
                                       		{{$order->created_at->format('F,j,Y H:i:s')}}

                                       		({{$order->created_at->DiffForHumans()}}) 

                                      		</td>
                                      		<td> 
                                      		{{$order->delivery_due_date}}

                                      		</td>
                                      		<td>  
                                      			{{$order->order_status}}
                                      		</td>

                                      		<td> 

                                      		<a  href="{{url('accounts/seller_order/'.$order->id)}}" target="_BLANK"  class="btn  btn-primary">  View Details  </a>	

 								               
                                      		</td>



                                       </tr>


                                       @endforeach

                                        </tbody>
                                       
                                    </table>
                                       <div class="pagination-wrapper"> {!! $orders->appends(['search' => Request::get('search')])->render() !!} </div>



                </div>

   @endsection             