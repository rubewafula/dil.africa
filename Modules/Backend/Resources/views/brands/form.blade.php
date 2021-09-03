<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $brand->name or ''}}" required>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@if(!empty($brand->cover_photo))

<div  class="form-group">
    
    <label class="col-md-4 control-label"> Current  picture</label>
        <div class="col-md-6">
            <img src="{{asset($brand->cover_photo)}}" width="80px" /> <a href="{{  url('backend/remove_brand_pic/'.$brand->id)}}" onclick=" return  confirm('Are  you sure?')">Remove</a>
</div>

</div>

@endif

<div class="form-group {{ $errors->has('cover_photo') ? 'has-error' : ''}}">
    <label for="cover_photo" class="col-md-4 control-label">{{ 'Cover Photo' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="cover_photo" type="file" id="cover_photo" value="{{ $brand->cover_photo or ''}}" required>
        {!! $errors->first('cover_photo', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ $brand->description or ''}}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('mini_category_id') ? 'has-error' : ''}}">
    <label for="mini_category_id" class="col-md-4 control-label">{{ 'Mini Category ' }}</label>
    <div class="col-md-6">
          

        <input class="form-control" name="mini_category_id" type="number" id="mini_category_id" value="{{ $brand->mini_category_id or ''}}" >


        {!! $errors->first('mini_category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
