 @extends('logistics::layouts.logistics_master')

@section('content')
                <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3 style="font-weight: bold;padding-top: 10px;">  Direct Shipment to Customer </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                </div>
                                 <a href="{{ url('/logistics/customer/confirmed-orders') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                <div class="panel-body">
                                           
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/logistics/direct_shipment') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                           @if(!isset($trip))  <?php $trip =  new  App\Trip; ?>  @endif

                            <input type="hidden" value="{{$order_id}}" name="order_id"/>
                            <div class="form-group {{ $errors->has('departure_date') ? 'has-error' : ''}}">
                                <label for="departure_date" class="col-md-4 control-label">{{ 'Departure Date' }}</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="departure_date" type="text" id="departure_date" value="{{ $trip->departure_date or ''}}" >
                                    {!! $errors->first('departure_date', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('departure_time') ? 'has-error' : ''}}">
                                <label for="departure_time" class="col-md-4 control-label">{{ 'Departure Time' }}</label>
                                <div class="col-md-6">
                                    <input class="form-control" name="departure_time" type="text" id="departure_time" value="{{ $trip->departure_time or ''}}" >
                                    {!! $errors->first('departure_time', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('vehicle_id') ? 'has-error' : ''}}">
                                <label for="vehicle_id" class="col-md-4 control-label">{{ 'Bike / Vehicle' }}</label>
                                <div class="col-md-6">

                                    <?php $vehicles = \App\Vehicle::pluck('registration_no', 'id')->prepend('Select Bike / Vehicle', ''); ?>
                                    {{Form::select('vehicle_id', $vehicles, $trip->vehicle_id, ['class'=>'form-control']) }}
                                    {!! $errors->first('vehicle_id', '<p class="help-block">:message</p>') !!}
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
                        <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA </p>
                    </div>
                </div>
       
 @endsection