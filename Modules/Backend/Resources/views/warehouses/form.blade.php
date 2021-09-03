<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('area_id') ? 'has-error' : ''}}">
    {!! Form::label('area_id', 'Area ', ['class' => 'col-md-4 control-label']) !!}
        <?php $areas=  App\Area::pluck('name','id')->prepend('Select',''); ?>
    <div class="col-md-6">
        {!! Form::select('area_id',$areas, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('area_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('capacity') ? 'has-error' : ''}}">
    {!! Form::label('capacity', 'Capacity', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('capacity', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('capacity', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
