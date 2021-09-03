
<div class="form-group {{ $errors->has('main_category') ? 'has-error' : ''}}">
  <label class="col-md-4 control-label">  Parent Category </label>
  <div class="col-md-6">
    @php($all_categories = \App\Category::pluck('name', 'id'))
    {{Form::select('main_category',$all_categories ,$featured_category->main_category, ['class'=>'form-control','id'=>'main_category'])}}

  </div>
</div>
<div  class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
    <label class="col-md-4 control-label">  Category </label>
    <div class="col-md-6">
      {{Form::select('category_id',$all_categories ,$featured_category->category_id, ['class'=>'form-control','id'=>'category_id'])}}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>