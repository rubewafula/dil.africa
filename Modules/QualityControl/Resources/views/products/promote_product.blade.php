@extends('qc::layouts.master')
@section('content')

<script type="text/javascript">

    $('#start_date').datepicker({
    	format: 'yyyy-dd-dd'       
    })
</script>

<div class="page-breadcrumb" >
                      {{ Breadcrumbs::render() }}

                  </div>
                  <div class="page-title">
                      <div class="container">
                          <h3> Offer Promotion on Price </h3>
                      </div>
                  </div>
                  <div class="panel panel-white">

                    <div id="main-wrapper">

                      <div class="row">
                          
                          <div class="col-md-12" style="padding: 5px 30px;">

                          	<form method="POST" action="{{url('/qc/promote_product')}}">
                          		{{ csrf_field() }}
                          		<input type="hidden" name="product_price" id="product_price" value="{{$product_price->id}}" />
                          		<input type="hidden" name="standard_price" id="standard_price" value="{{$product_price->standard_price}}" />
                          		<div class="row">
                          			
                          			<div class="col-md-12">
                          				
                          				<label for="offer_price">Your Offer Price</label>
                          				{{Form::number('offer_price', null, ['class'=>'form-control', 'min' => '0'])}}
                          			</div>

                          			<div class="col-md-12" style="padding-top: 20px;">
                          				
                          				<label for="start_date">Valid From</label>
                          				{{Form::text('start_date', null, ['class'=>'form-control', 'id' => 'start_date'])}}
                          			</div>

                          			<div class="col-md-12" style="padding-top: 20px;">
                          				
                          				<label for="end_date">Valid To</label>
                          				{{Form::text('end_date', null, ['class'=>'form-control', 'id' => 'end_date'])}}
                          			</div>

                          			<div class="col-md-12">
                          				
                          				<input type="submit" class="btn blue-button" style="margin-top: 15px;" name="" value="Save"/>
                          			</div>

                          		</div>

                          	</form>
                          </div>

                      </div>

                  </div>

              </div>

@endsection 