<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Full Names' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $rider->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone" class="col-md-4 control-label">{{ 'Phone Number' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ $rider->phone or ''}}" >
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="col-md-4 control-label">{{ 'Email Address' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="email" id="email" value="{{ $rider->email or ''}}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
    <label for="gender" class="col-md-4 control-label">{{ 'Gender ' }}</label>
    <div class="col-md-6">

    	<?php $genders = ['' => 'Select Gender', 'MALE' => 'Male', 'FEMALE' => 'Female', 'NOT DISCLOSED' => 'Not Disclosed']; ?>
    	{{Form::select('gender', $genders, $rider->gender or '',['class'=>'form-control'])}}

        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('id_number') ? 'has-error' : ''}}">
    <label for="id_number" class="col-md-4 control-label">{{ 'ID Number' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_number" type="text" id="id_number" value="{{ $rider->id_number or ''}}" >
        {!! $errors->first('id_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('vehicle_id') ? 'has-error' : ''}}">
    <label for="vehicle_id" class="col-md-4 control-label">{{ 'Vehicle' }}</label>
    <div class="col-md-6">
       <?php $vehicles= App\Vehicle::pluck('registration_no','id')->prepend('select',''); ?>
    	{{Form::select('vehicle_id',$vehicles, $rider->vehicle_id or '',['class'=>'form-control'])}}
        {!! $errors->first('vehicle_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>