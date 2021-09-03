@extends('accounts::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Manage : {{$seller->name}} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-white">
                            	   <div class="panel-body">


                                        <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                                                           
                                                <li role="presentation" class=" active"><a href="#seller" role="tab" data-toggle="tab" > Seller details</a></li>
                                                 <li role="presentation"><a href="#users" role="tab" data-toggle="tab">Users  </a></li>
                                                <li role="presentation"><a href="#products" role="tab" data-toggle="tab">Products </a></li>

                                                <li role="presentation"><a href="#orders" role="tab" data-toggle="tab">Orders</a></li>

                                            </ul>
                                        </div>

                                           <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="seller">

                                                	  <!--   <form method="POST" action="{{ url('/backend/sellers/' . $seller->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"> -->

                                                        {!! Form::model($seller, [
                            'method' => 'PATCH',
                            'url' => ['/accounts/sellers', $seller->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}


                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('accounts::sellers.form', ['submitButtonText' => 'Update'])

                        </form>

                                                </div>

                                                <div role="tabpanel" class="tab-pane" id="users"> 
                                                    <div  class="col-md-4 col-sm-12">
                                                     <span  class="pull-left"> <a href="" class="btn btn-success btn-sm" title="Add New " target="_BLANK" data-toggle="modal" data-target="#newuser" >
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>    
                                                                                </div>


                                                                                <!-- Modal -->
<div class="modal fade" id="newuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Add  User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
  <form method="POST" action="{{ url('/accounts/create_users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

    <input type="hidden" name="seller_id"  value="{{$seller->id}}">

                            {{ csrf_field() }}

                           <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
    <label for="first_name" class="col-md-4 control-label">{{ 'First Name *' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="first_name" type="text" id="first_name" value="" >
    </div>
</div>

<div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
    <label for="last_name" class="col-md-4 control-label">{{ 'Last Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="last_name" type="text" id="last_name" value="{{ $user->last_name or ''}}" >
        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="col-md-4 control-label">{{ 'Email *' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="text" id="email" value="{{ $user->email or ''}}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone" class="col-md-4 control-label">{{ 'phone' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ $user->phone or ''}}" >
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}">
    <label for="role_id" class="col-md-4 control-label">{{ 'Role' }}</label>
    <div class="col-md-6">
        <select name="role_id" class="form-control">
        <?php $roles= App\Role::where('id',10)->orwhere('id',11)->orwhere('id',18)->get(); ?>
            @foreach($roles as $role)
           <option value="{{$role->id}}">{{$role->display_name}}</option>
           
            @endforeach
        </select>
        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-danger" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>


                        </form>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



                                                  <?php $users=  App\User::where('seller_id',$seller->id)->get(); ?>

                                                   <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                          <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">

                                            <tr>
                                               <tr>
                                        <th>#</th><th>First Name</th><th>Last Name</th><th>Email</th>
                                        <th> Role</th>
                                                      <th>Status</th>

                                        <th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                      
                                       <tbody>
                                        @if($users->count() >0 )
                                            @foreach($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>  
                                          @foreach($item->roles as  $role)
                                          {{$role->name}} <br/>

                                          @endforeach

                                        </td>
                                        <td>{{$item->status}}</td>


                                        <td>
                                            
                                            <a href="{{ url('/accounts/users/' . $item->id . '/edit') }}" target="_BLANK" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/accounts/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @else
                                <tr>
                                  <td colspan="4">  You have  not  added  any  users</td>
                                </tr>

                                @endif
                                          
                                        
                                        </tbody>
                                       </table>  


                                                 </div>

                                                 <div role="tabpanel" class="tab-pane" id="products"> 
                                               <a  href="{{ url('accounts/new_product/'.$seller->id)}}" target="_BLANK" class="btn btn-primary"> New  Product</a>
                                                   <div  class="row">  
                                                    <div  class="col-md-12"> 


                                                    </div>
                                                  </div>

                                                 	<div  class="row">  

                                                 		<div  class="col-md-12"> 

                                                 			  <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Name </th>
      <th> Category</th>
      <th> Status</th>
      <th> Actions</th>

     </tr>
  </thead>
  <tbody>

    @if(count($seller->products) > 0)
@foreach($seller->products  as $product)
<tr>
    <td>{{$product->name}}</td>
    <td>  

    @if(App\Category::where('id',$product->category_id)->exists())

      {{$product->category->name}}

    @endif

     </td>
     <td>
        {{$product->status}} 

     </td>
    

     <td>
      
      &nbsp;&nbsp;&nbsp;&nbsp;
<a  href="{{ url('accounts/product/'.$product->slug)}}" target="_BLANK" class="btn-warning btn-sm">  
   Manage <span class="glyphicon glyphicon-signal" aria-hidden="true"></span></a>
      &nbsp;&nbsp;&nbsp;&nbsp;

      <a  href="{{ url('accounts/delete_product/'.$product->id)}}" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>



     </td>

</tr>


@endforeach

@else

<tr>
  <td colspan="5"> No  Products</td>
</tr>

@endif

  </tbody>
</table>
                                                 		</div>

                                                 	</div>
                                                

                                                 </div>

                                                     <div role="tabpanel" class="tab-pane" id="orders"> 
                                                        <h3>  Supplier  Orders</h3>
                                                          <div  class="row">
                                                              <div  class="col-md-12">
                                                                  
    <table class="table table-bordered">
  <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
    <tr>
      <th> Order  reference </th>
      <th> Date</th>
      <th> Amount</th>
      <th> Status</th>
      <th> Action</th>
     </tr>
  </thead>

  @if($seller->orders->count() > 0)

  @foreach($seller->orders  as $order)
<tr>
    <td>{{$order->order_reference}}</td>
    <td>{{$order->order_date}}</td>
    <td> {{$order->order_detail->price}}</td>
    <td>
      {{$order->order_status}}

    </td>
    <td> 

     </td>

</tr>
@endforeach

@else

<tr>
    <td colspan="4"> No  Orders</td>
</tr>
@endif
  <tbody>
  </tbody>
</table>

                                                              </div>

                                                          </div>   
                                                 


                                                 </div>

                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection