<div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
    <label for="url" class="col-md-4 control-label">{{ 'Campaign Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $campaign->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('Active From') ? 'has-error' : ''}}">
    <label for="active_from" class="col-md-4 control-label">{{ 'Active From' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="active_from" type="text" id="active_from" value="{{ $campaign->active_from or ''}}" >
        {!! $errors->first('active_from', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('Active To') ? 'has-error' : ''}}">
    <label for="active_to" class="col-md-4 control-label">{{ 'Active To' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="active_to" type="text" id="active_to" value="{{ $campaign->active_to or ''}}" >
        {!! $errors->first('active_to', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('campaign_description') ? 'has-error' : ''}}">
    <label for="campaign_description" class="col-md-4 control-label">{{ 'Campaign Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="campaign_description" type="textarea" id="campaign_description" >{{ $campaign->campaign_description or ''}}</textarea>
        {!! $errors->first('campaign_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div  class="form-group">
    <label class="col-md-4 control-label"> Level </label>
    <?php $levels=[''=>'','2'=>'Two','3'=>'Three']; ?>

    <div class="col-md-6">
      {{Form::select('level', $levels, null, ['class'=>'form-control', 'id'=>'level'])}}
    </div>
</div>

<div  class="form-group {{ $errors->has('depends_on') ? 'has-error' : ''}}">
        <label class="col-md-4 control-label"> Category </label>
                <div class="col-md-6">

 @php($all_categories = \App\Category::pluck('name', 'id')->prepend('', ''))
 {{Form::select('depends_on', $all_categories ,$campaign->category_id, ['class'=>'form-control', 'id'=>'depends_on'])}}

</div>

</div>

<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="col-md-4 control-label">{{ 'Product SKU' }}</label>
    <div class="col-md-6">
            <input class="form-control" name="product_id" type="text" id="product_id" value="{{ $campaign->product_id or ''}}" >
        {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>