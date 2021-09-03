@extends('seller::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix" style="font-weight: bold;color: #0F7DC2;"> Manage Users</div>

                            <div class="panel panel-white">
                            	     <div class="panel-body">
                            	     	 <div class="table-responsive">

                                     <div  class="row">
                                        <div  class="col-md-8 col-sm-12">
                        <form method="GET" action="{{ url('/backend/users') }}" accept-charset="UTF-8" class="form-inline " role="search">
                            <form class="form-inline">
  <div class="input-group">
  <div class="form-group mx-sm-12 mb-12">
    <input type="text" class="form-control"  name="search" value="{{ request('search') }}" placeholder="Search">
  </div>
                                  <span class="input-group-append">

    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
</form>
                         
                                        </div>

                                     <div  class="col-md-4 col-sm-12">
                                                     <span  class="pull-right"> <a href="{{ url('/seller/new_user') }}" class="btn btn-success btn-sm orange-button" title="Add New ">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>                                

                                                                                </div>

                                    </div>
                                    <table id="crud" class="display table" style="width: 100%;border: 1px solid #eee;margin-top: 10px;">
                                        <thead style="background: #f5f5f5;color:#888;">
                                            <tr>
                                              <th>#</th>
                                              <th>First Name</th>
                                              <th>Last Name</th>
                                              <th>Email</th>
                                              <th>Status</th>
                                              <th>Roles</th>
                                              <th>Actions</th>
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($users as $item)
                                       <tr style="border-top: 1px solid #eee;">
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{$item->status}}</td>
                                        <td> 
                                        	@foreach($item->roles   as $role)
                                        	{{$role->name}}
                                        	@endforeach

                                        </td>


                                        <td>
                                            
                                            <a href="{{ url('/seller/users/' . $item->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/seller/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                          
                                        
                                        </tbody>
                                       </table>  
                                                                   <div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>

                                    </div>
                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection