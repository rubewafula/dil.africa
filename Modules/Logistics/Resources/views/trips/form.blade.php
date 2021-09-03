<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Trip Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $trip->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
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

<div class="form-group {{ $errors->has('active') ? 'has-error' : ''}}">
    <label for="active" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">
        <?php $status = ['1' => 'Active', '2' => 'Inactive']; ?>
        {{Form::select('active', $status, $trip->active, ['class'=>'form-control'])}}
        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>