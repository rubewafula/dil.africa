<div class="form-group {{ $errors->has('zone_id') ? 'has-error' : ''}}">
    <label for="zone_id" class="col-md-4 control-label">{{ 'Zone ' }}</label>
    <div class="col-md-6">

    	<?php $zones= App\Zone::pluck('name','id')->prepend('Please Select',''); ?>
    	{{Form::select('zone_id',$zones,$special_shipping_rate->zone_id or '',['class'=>'form-control','id'=>'zone_id'])}}

        {!! $errors->first('zone_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('item_size_id') ? 'has-error' : ''}}">
    <label for="item_size_id" class="col-md-4 control-label">{{ 'Item Size ' }}</label>
    <div class="col-md-6">
       <?php $items= App\Item_size::pluck('name','id')->prepend(null,''); ?>
    	{{Form::select('item_size_id',$items,$special_shipping_rate->item_size_id or '',['class'=>'form-control'])}}
        {!! $errors->first('item_size_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('order_amount') ? 'has-error' : ''}}">
    <label for="order_amount" class="col-md-4 control-label">{{ 'Order Amount' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="order_amount" type="number" id="order_amount" value="{{ $special_shipping_rate->order_amount or ''}}" >
        {!! $errors->first('order_amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('amount_charged') ? 'has-error' : ''}}">
    <label for="amount_charged" class="col-md-4 control-label">{{ 'Amount Charged' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="amount_charged" type="number" id="amount_charged" value="{{ $special_shipping_rate->amount_charged or ''}}" >
        {!! $errors->first('amount_charged', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">

        <?php $statuses = ['0' => 'Inactive', '1' => 'Active']; ?>
        {{Form::select('status',$statuses, $special_shipping_rate->status or '',['class'=>'form-control'])}}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>