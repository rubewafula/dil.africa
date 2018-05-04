<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $country->name or ''}}" required>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('country_iso') ? 'has-error' : ''}}">
    <label for="country_iso" class="col-md-4 control-label">{{ 'Country Iso' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="country_iso" type="text" id="country_iso" value="{{ $country->country_iso or ''}}" >
        {!! $errors->first('country_iso', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
