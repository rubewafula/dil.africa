<div class="form-group {{ $errors->has('display_name') ? 'has-error' : ''}}">
    <label for="display_name" class="col-md-4 control-label">{{ 'Display Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="display_name" type="text" id="display_name" value="{{ $role->display_name or ''}}" >
        {!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
