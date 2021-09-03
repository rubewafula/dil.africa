@extends('qc::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                   {{ Breadcrumbs::render() }}

                </div>


                <div class="page-title">
                    <div class="container">
                        <h3>Sellers Profiles</h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                     <h4 class="panel-title"></h4> 
                                </div>
                                <div class="panel-body">

                                    
                                   <div class="table-responsive">

                                     <div  class="row">
                                        <div  class="col-md-8 col-sm-12">
                        <form method="GET" action="{{ url('/qc/seller-profiles') }}" accept-charset="UTF-8" class="form-inline " role="search">
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

                                    </div>
                                    <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                            <tr>
                                               <tr>
                                        <th>#</th><th>Shop Name</th><th>User Name</th><th>Telephone</th><th>Email  Address</th><th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach($sellers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        @php($user = App\User::where('seller_id', $item->id)->first())
                                        <td>{{ ($user != null)?$user->first_name.' '.$user->last_name:"" }}</td>
                                        <td>{{ $item->telephone }}</td>
                                        <td>{{ $item->email_address}}</td>
                                        <td>
                                              <a href="{{ url('/qc/sellers/manage/' . $item->id) }}" title="Edit Seller"><button class="btn btn-success btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Manage</button></a>


                                            <a href="{{ url('/qc/sellers/' . $item->id . '/edit') }}" title="Edit Seller"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

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
                        <p class="no-s"><?php echo date('Y') ?>&copy; </p>
                    </div>
                </div>
       

 @endsection