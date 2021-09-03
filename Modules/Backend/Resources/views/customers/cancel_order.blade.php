@extends('backend::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Order  Cancellation  </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> Manage cancellation  for #{{$order->order_reference}}</div>

                            <div class="panel panel-white">
                            	    <div class="panel-body">
                            	    	<form  method="POST" action="{{url('backend/cancel_order')}}">
                            	    	    <input type="hidden" name="order_id"  value="{{$order->id}}">

                            	    		{{csrf_field()}}

                            	    		<div  class="form-group">
                            	    			
                            	    			<label>  Select  Reason</label>

                            	    <?php $reasons=  \App\Cancellation_reason::get(); ?>
                            	    <select  name="cancellation_reason_id" class="form-control">
                           	    	
                                    @foreach($reasons  as $reason)
                            	    <option  value="{{$reason->id}}">{{$reason->name}}</option>

                            	    @endforeach
                            	    </select>
                            	    
                            	    		</div>

                            	    		<div  class="form-group">
                            	    			<label> Comments</label>
                            	    			<textarea name="cancellation_comments"  class="form-control"> </textarea>

                            	    		</div>
                            	    		<div  class="form-group pull-right">
                            	    			<input type="submit" class=" btn btn-danger" value="Cancel">

                            	    		</div>


                            	    		

                            	    	</form>


                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection