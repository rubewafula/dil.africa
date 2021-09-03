@extends('backend::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  New User </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                </div>
                                 <a href="{{ url('/backend/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                <div class="panel-body">

                                                            
                     

                        <form method="POST" action="{{ url('/backend/users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            <input  type="hidden" name="seller_id" value="{{$seller_id}}">
                            {{ csrf_field() }}

                           <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
    <label for="first_name" class="col-md-4 control-label">{{ 'First Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="first_name" type="text" id="first_name" value="{{ $user->first_name or ''}}" >
        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
    <label for="last_name" class="col-md-4 control-label">{{ 'Last Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="last_name" type="text" id="last_name" value="{{ $user->last_name or ''}}" >
        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="col-md-4 control-label">{{ 'Email' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="text" id="email" value="{{ $user->email or ''}}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="col-md-4 control-label">{{ 'password' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="password" type="password" id="password" >
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}">
    <label for="role_id" class="col-md-4 control-label">{{ 'Role' }}</label>
    <div class="col-md-6">
        <select name="role_id" class="form-control">
            <?php $roles= App\Role::where(['id'=>10])->orwhere('id',11)->get(); ?>

            @foreach($roles as $role)
           <option value="{{$role->id}}">{{$role->display_name}}</option>
           
            @endforeach
        </select>
        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>


                        </form>
                                  
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