<div class="form-group {{ $errors->has('zone_id') ? 'has-error' : ''}}">
    <label for="zone_id" class="col-md-4 control-label">{{ 'Zone ' }}</label>
    <div class="col-md-6">

    	<?php $zones= App\Zone::pluck('name','id')->prepend('select',''); ?>
    	{{Form::select('zone_id',$zones,$shipping_price->zone_id or '',['class'=>'form-control'])}}
    


        {!! $errors->first('zone_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('shipping_type_id') ? 'has-error' : ''}}">
    <label for="shipping_type_id" class="col-md-4 control-label">{{ 'Shipping Type ' }}</label>
    <div class="col-md-6">
       <?php $shipping_types= App\Shipping_type::pluck('name','id')->prepend('select',''); ?>
    	{{Form::select('shipping_type_id',$shipping_types,$shipping_price->shipping_type_id or '',['class'=>'form-control'])}}
        {!! $errors->first('shipping_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('item_size_id') ? 'has-error' : ''}}">
    <label for="item_size_id" class="col-md-4 control-label">{{ 'Item Size ' }}</label>
    <div class="col-md-6">
       <?php $items= App\Item_size::pluck('name','id')->prepend('select',''); ?>
    	{{Form::select('item_size_id',$items,$shipping_price->item_size_id or '',['class'=>'form-control'])}}
        {!! $errors->first('item_size_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('price_one') ? 'has-error' : ''}}">
    <label for="price_one" class="col-md-4 control-label">{{ 'Price For One' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="price_one" type="number" id="price_one" value="{{ $shipping_price->price_one or ''}}" >
        {!! $errors->first('price_one', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('price_many') ? 'has-error' : ''}}">
    <label for="price_many" class="col-md-4 control-label">{{ 'Price for Many' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="price_many" type="number" id="price_many" value="{{ $shipping_price->price_many or ''}}" >
        {!! $errors->first('price_many', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
