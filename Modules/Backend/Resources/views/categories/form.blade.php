<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $category->name or ''}}" required>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="col-md-4 control-label">{{ 'Slug' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="slug" type="text" id="slug" value="{{ $category->slug or ''}}" >
        {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('cover_photo') ? 'has-error' : ''}}">
    <label for="cover_photo" class="col-md-4 control-label">{{ 'Cover Photo' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="cover_photo" type="text" id="cover_photo" value="{{ $category->cover_photo or ''}}" required>
        {!! $errors->first('cover_photo', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ $category->description or ''}}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
