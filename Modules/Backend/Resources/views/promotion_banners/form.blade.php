<div class="form-group">
  <div class="col-md-8 col-md-offset-2" style="text-align: center;line-height: 1.8em;">
    Banner Images Dimension: <span style="font-weight:bold;"> Main Banner </span> - <span class="blue-fg"> ( Between <span class="orange-fg">870 x 365</span> and <span class="orange-fg">880 x 370</span>)  </span>, 
    <span style="font-weight:bold;"> Side Banner </span> - <span class="blue-fg"> ( Between <span class="orange-fg">260 x 360</span> and <span class="orange-fg">270 x 370</span>)  </span>,
    <span style="font-weight:bold;"> Middle Banner </span> - <span class="blue-fg"> ( Between <span class="orange-fg">845 x 165</span> and <span class="orange-fg">850 x 170</span>)  </span>
  </div>
</div>

<div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
    <label for="url" class="col-md-4 control-label">{{ 'Banner Image' }}</label>
    <div class="col-md-6">
    
      <input type="file" class="form-control" name="file">
    </div>
</div>

<div class="form-group {{ $errors->has('promotion_section_id') ? 'has-error' : ''}}">
    <label for="promotion_section_id" class="col-md-4 control-label">{{ 'Promotion Section' }}</label>
    <div class="col-md-6">
        
        <?php $promotion_sections = ['1'=>'Upper Sidebar','2'=>'Main','3'=>'Middle Banner']; ?>

        {{Form::select('promotion_section_id', $promotion_sections,  $promotion_banner->promotion_section_id, ['class'=>'form-control', 'id'=>'promotion_section_id'])}}
        {!! $errors->first('promotion_section_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('Active From') ? 'has-error' : ''}}">
    <label for="active_from" class="col-md-4 control-label">{{ 'Active From' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="active_from" type="text" id="active_from" value="{{ $promotion_banner->active_from or ''}}" >
        {!! $errors->first('active_from', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('Active To') ? 'has-error' : ''}}">
    <label for="active_to" class="col-md-4 control-label">{{ 'Active To' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="active_to" type="text" id="active_to" value="{{ $promotion_banner->active_to or ''}}" >
        {!! $errors->first('active_to', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('campaign_description') ? 'has-error' : ''}}">
    <label for="campaign_description" class="col-md-4 control-label">{{ 'Campaign Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="campaign_description" type="textarea" id="campaign_description" >{{ $promotion_banner->campaign_description or ''}}</textarea>
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
 {{Form::select('depends_on', $all_categories ,$promotion_banner->category_id, ['class'=>'form-control', 'id'=>'depends_on'])}}

</div>

</div>

<div class="form-group {{ $errors->has('product_code') ? 'has-error' : ''}}">
    <label for="product_code" class="col-md-4 control-label">{{ 'Product SKU' }}</label>
    <div class="col-md-6">
            <input class="form-control" name="product_code" type="text" id="product_code" value="{{ $promotion_banner->product->product_code or ''}}" >
        {!! $errors->first('product_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>