<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('zone_id') ? 'has-error' : ''}}">
    {!! Form::label('zone_id', 'Zone', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
<?php $zones= App\Zone::pluck('name','id'); ?>

        {!! Form::select('zone_id',$zones, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('zone_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
    {!! Form::label('city_id', 'City', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
<?php $cities= App\City::pluck('name','id'); ?>

        {!! Form::select('city_id',$cities, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
