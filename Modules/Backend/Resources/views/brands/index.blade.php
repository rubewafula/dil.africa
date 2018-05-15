@extends('backend::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                   {{ Breadcrumbs::render() }}

                </div>


                <div class="page-title">
                    <div class="container">
                        <h3>Brands</h3>
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
                        <form method="GET" action="{{ url('/backend/brands') }}" accept-charset="UTF-8" class="form-inline " role="search">
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
                                                     <span  class="pull-right"> <a href="{{ url('backend/brands/create') }}" class="btn btn-success btn-sm" title="Add New ">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a> </span>                                

                                                                                </div>

                                    </div>
                                    <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                            <tr>
                                               <tr>
                                        <th>#</th><th>Name</th><th>Cover Photo</th><th>Actions</th>
                                    </tr>
                                            </tr>
                                        </thead>
                                        <tfoot style="background: #000;color:#fff;opacity: 0.7">
                                            <tr>
                                                      <th>#</th><th>Cover Photo</th><th>Name</th><th>Actions</th>

                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($brands as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                         <td>

                                            <?php

                                                //$file = File::get($item->cover_photo);

                                                // echo  $file;

                                                echo  $item->cover_photo;

                                             ?>
                                            <img src="<?php echo  url($item->cover_photo) ?>" />
                                            </td>

                                        <td>{{ $item->name }}</td><td>{{ $item->slug }}</td>
                                        <td>
                                            
                                            <a href="{{ url('/backend/brands/' . $item->id . '/edit') }}" title="Edit Brand"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/backend/brands' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Brand" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                          
                                        
                                        </tbody>
                                       </table>  
                                                                   <div class="pagination-wrapper"> {!! $brands->appends(['search' => Request::get('search')])->render() !!} </div>

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