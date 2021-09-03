<div class="form-group {{ $errors->has('level_2_category') ? 'has-error' : ''}}">
    <label for="level_2_category" class="col-md-4 control-label">{{ 'Category ' }}</label>
    <div class="col-md-6">
<?php $categories= App\Category::where('level',2)->pluck('name','id')->prepend('Select',''); ?>
    
    {{Form::select('level_2_category',$categories,null,['class'=>'form-control','id'=>'level_2_category'])}}

      
        {!! $errors->first('level_2_category', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $feature_type->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
