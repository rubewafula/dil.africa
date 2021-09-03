@extends('backend::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Update  profile </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> Header</div>

                            <div class="panel panel-white">
                            	                                <div class="panel-body">

                                	<form method="POST"  action="{{url('backend/profile')}}">

                                		<div class="form-group">
                                            <label for="first_name"> First Name</label>
                                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder=" First Name" value="{{Auth::user()->first_name}}">
                                        </div>

                                        	<div class="form-group">
                                            <label for="first_name"> Last Name</label>
                                            <input type="text" name="last_name" class="form-control" id="last_name" placeholder=" Last Name"  value="{{Auth::user()->last_name}}">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="email" value="{{Auth::user()->email}}">
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" autocomplete="off">
                                        </div>
                                       
                                        <button type="submit" class="btn btn-primary">Update</button>

                                        {{csrf_field()}}
                                    </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection