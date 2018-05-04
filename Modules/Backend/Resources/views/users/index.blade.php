@extends('backend::layouts.master')


@section('content')
    <div class="page-breadcrumb">
                    <ol class="breadcrumb container">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Tables</a></li>
                        <li class="active">Datatables</li>
                    </ol>
                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>Datatables</h3>
                    </div>
                </div>
                
   <div id="main-wrapper" class="container">
                    <div class="row">
                                                    <div class="panel panel-white">

                        <div class="col-md-12">
                         <div class="table-responsive">
                            <table class="table">
                                <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                         <th>Last Name</th>
                                         <th>Gender</th>
                                         <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background: #fff">
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->first_name }}</td>
                                        <td>{{ $item->last_name }}</td>

                                        <td>{{ $item->gender }}</td>
                                        <td>
                                            <a href="{{ url('/backend/users/' . $item->id) }}" title="View User"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/backend/users/' . $item->id . '/edit') }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/backend/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
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

@endsection
