<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $area->name or ''}}" required>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('zone_id') ? 'has-error' : ''}}">
    <label for="zone_id" class="col-md-4 control-label">{{ 'Zone Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="zone_id" type="number" id="zone_id" value="{{ $area->zone_id or ''}}" required>
        {!! $errors->first('zone_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
    <label for="city_id" class="col-md-4 control-label">{{ 'City Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="city_id" type="number" id="city_id" value="{{ $area->city_id or ''}}" required>
        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
