@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class='active'><a href="{{url('shop/checkout')}}">Address Details</a></li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<style>
    .info-title {
        font-family: 'Open Sans', sans-serif, sans-serif;
        font-weight: normal;
        margin-bottom: 5px;
        font-size: 13px;
    }
</style>

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            
            <div class="row" id="home_delivery_div">
                <div class="col-md-12">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>Delivery Address Information
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <form class="address-form" role="form" method="POST" action="{{url('shop/address/update')}}">
                                            <input type="hidden" name="user_id" value="{{$userId}}"/>
                                            <input type="hidden" name="user_address_id" value="{{isset($user_address)?$user_address->id:""}}"/>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 already-registered-login">                                                                                     
                                                    <div class="form-group">
                                                        <label class="info-title" for="telephone">Your Phone Number <span>*</span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input" 
                                                               id="telephone" name="telephone" placeholder="" value="{{isset($user_address)?$user_address->telephone:""}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="country">Country <span></span></label>
                                                        @php($countries = \Modules\Customer\Entities\Country::pluck('name', 'id'))

                                                        {!! Form::select('country_id', $countries, isset($user_address)?$user_address->country_id:null, ['class' => 'form-control unicase-form-control text-input country-select', 
                                                        'id'=>'country_id', 'placeholder'=>'', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="city">City / Town <span></span></label>
                                                        @php($cities =  \Modules\Customer\Entities\City::pluck('name', 'id'))

                                                        {!! Form::select('city_id', $cities, isset($user_address)?$user_address->city_id:null, ['class' => 'form-control unicase-form-control text-input city-select', 
                                                        'id'=>'city', 'placeholder'=>'', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="area">Zone <span></span></label>
                                                        @php($zone_id = isset($user_address)?$user_address->zone_id:0)
                                                        @php($zones = \Modules\Customer\Entities\Zone::pluck('name', 'id'))

                                                        {!! Form::select('zone_id', $zones, isset($user_address)?$user_address->zone_id:null, ['class' => 'form-control unicase-form-control text-input zone-select', 
                                                        'id'=>'zone', 'placeholder'=>'', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="area">Area <span></span></label>
                                                        @php($area_id = isset($user_address)?$user_address->area_id:0)
                                                        @php($areas = \Modules\Customer\Entities\Area::pluck('name', 'id'))

                                                        {!! Form::select('area_id', $areas, isset($user_address)?$user_address->area_id:null, ['class' => 'form-control unicase-form-control text-input area-select', 
                                                        'id'=>'area', 'placeholder'=>'', 'required' => 'required']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="street">Street <span>*</span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input"
                                                               id="street" name="street" placeholder="" value="{{isset($user_address)?$user_address->street:""}}"/>
                                                    </div>                 
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="building">Building Name <span></span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input"
                                                               id="building" name="building" placeholder="" value="{{isset($user_address)?$user_address->building:""}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="floor">Floor <span></span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input"
                                                               id="floor" name="floor" placeholder="" value="{{isset($user_address)?$user_address->floor:""}}"/>
                                                    </div>
                                                </div>                                                                                       
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="landmark">Landmark <span></span></label>
                                                        <input type="text" class="form-control unicase-form-control text-input"
                                                               id="landmark" name="landmark" placeholder="" value="{{isset($user_address)?$user_address->landmark:""}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="landmark">Any Further Description? <span></span></label>
                                                        <textarea id="description" class="form-control unicase-form-control text-input" 
                                                                  name="description" placeholder="">{{isset($user_address)?$user_address->description:""}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <div class="form-group">
                                                        <label class="info-title" for="default">Is this your preferred address? </label>
                                                        @php($options = array('1' => 'Yes', '2' => 'No'))
                                                        {!! Form::select('default', $options, isset($user_address)?$user_address->default:null, ['class' => 'form-control unicase-form-control text-input', 
                                                            'id'=>'default', 'placeholder'=>'', 'required' => 'required']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-sm-6 already-registered-login">
                                                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button" style="margin-top: 25px;">Save</button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                        <!-- already-registered-login -->		

                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="panel panel-default">
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
                                                    <div class="row" style="background:#ddd;color:#337AB7;padding: 10px 0px;margin: 0px;font-weight: bold;">
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
                                                            <span style="color: #F89530;font-weight: bold;">Default Address</span>
                                                            @endif
                                                        </div>                    
                                                    </div>
						
                                                    @endforeach
                                                    @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </div>
                                <!-- panel-body  -->

                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>

            </div><!-- /.row -->
        </div><!-- /.checkout-box -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop