@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb" style="margin: 5px 0px;">
    <div class="container">
        <div class="col-md-8">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class='active'><a href="{{url('shop/profile')}}">Profile</a></li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div>
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="panel-group checkout-steps">

                        <div class="panel panel-default checkout-step-02" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>Personal Details
                                    </a>
                                </h4>
                            </div>

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">	
                                        <form method="POST" action="{{url('/shop/update-profile')}}">
                                            <div class="col-md-3 col-sm-12 already-registered-login">                                           

                                                <div class="form-group">
                                                    <label class="info-title">First Name: </label>
                                                    {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12 already-registered-login">                                           

                                                <div class="form-group">
                                                    <label class="info-title">Last Name: </label>
                                                    {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title">Phone Number: </label>
                                                    {!! Form::text('phone', $user->phone, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-8 already-registered-login">
                                                <div class="form-group">
                                                    <label class="info-title">Email Address: </label>
                                                    {!! Form::text('email', $user->email, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-4 already-registered-login">
                                                <div class="form-group">
                                                    <button class='btn btn-warning'>
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                            </form>
                                    </div>

                                </div>			
                            </div>
                            <!-- panel-body  -->

                        </div><!-- row -->

                        <div class="panel panel-default checkout-step-03" style="padding: 10px;">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>2</span>My Address Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                
                                <div class="panel-body"  style="border: 1px solid #ddd;">

                                    <div class="row" style="padding-top: 15px;line-height: 1.8em;background: #f5f5f5;margin: 0px;">

                                        <div class="col-md-8 col-sm-8">  
                                            My Addresses
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            {!! Form::open(['method' => 'GET', 'url' => '/shop/delivery', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin-top:0px;'])  !!}
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                    @if(isset($addresses))
                                    @if(count($addresses)  > 0)
                                    <div class="row hidden-xs" style="background:#ddd;color:#337AB7;padding: 10px 0px;margin: 0px;font-weight: bold;">
                                        <div class="col-md-2 col-xs-12 col-sm-12">Building</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">Floor</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">Street</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">Area</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12">City</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12">Country</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12"></div>                    
                                    </div>

                                    @foreach($addresses as $address)

                                    <div class="row" style="background:#fff;padding: 10px 0px;">
                                        <div class="col-md-2 col-xs-12 col-sm-12">{{$address->building}}</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">{{$address->floor}}</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">{{$address->street}}</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">{{($address->area != null)?$address->area->name:""}}</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12">{{($address->city != null)?$address->city->name:""}}</div>
                                        <div class="col-md-1 col-xs-12 col-sm-12">{{($address->country != null)?$address->country->name:""}}</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12">
                                            
                                            @if($address->default != 1)
                                            <form method="POST" action="{{url('shop/address/makedefault')}}">

                                                <input type="hidden" value="{{$address->id}}" name="address" />
                                                <button data-toggle="tooltip" class="btn btn-primary" type="submit" title="Make Default Address">
                                                    Make Default                                                
                                                </button>
                                            </form>
                                            @else 
                                            <span style="color: #0F7DC2;font-weight: bold;">Default Address</span>
                                            @endif
                                            <a href="{{url('/shop/address/edit/'.$address->id)}}">
                                                <button data-toggle="tooltip" style='color:#FFF;background:#FFA200;border:none;height: 25px;' type="submit" title="Update Address">
                                                    Update                                             
                                                </button>
                                            </a>
                                        </div>                    
                                    </div>
        
                                    @endforeach
                                    @endif
                                    @endif

                                </div>			
                            </div>                           
                            <!-- panel-body  -->
                        </div><!-- row -->
                        
                    </div>
                </div>

            </div><!-- /.row -->

        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop