@extends('backend::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                   {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Edit  User #{{ $user->id }} </h3>
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

                                                            <form method="POST" action="{{ url('/backend/users/' . $user->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                          <p> The  current  roles of the user  are  : 

                           <ul>
                               @foreach($user->roles  as $role)
                               <li> {{$role->display_name}} <a  href="{{url('backend/remove_user_role/'.$user->id.'/'.$role->id)}}"> Remove</a></li>
                               @endforeach

                           </ul>
                          </p>

                          <div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}">
    <label for="role_id" class="col-md-4 control-label">{{ ' Add Role' }}</label>
    <div class="col-md-6">
        <select name="role_id" class="form-control">
            <?php $roles= App\Role::get(); ?>
            <option value="" selected>Select</option>

            @foreach($roles as $role)
           <option value="{{$role->id}}">{{$role->display_name}}</option>
           
            @endforeach
        </select>
        {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
                            <hr>

                            @include ('backend::users.form', ['submitButtonText' => 'Update'])

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