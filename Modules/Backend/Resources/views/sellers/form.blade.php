<script type="text/javascript">
    
    $(document).ready(function(){

            $('#timepicker1').timepicker();
            $('#timepicker2').timepicker();

// $("img").click(function(){    
//         $("img").animate({height: "350px";});
//     });


  var  base_url ="<?php echo  url('/'); ?>";

 //alert ("dfd");
  //   load_cities();
 $("#country_id").change(function(){
    

   // alert("");
    load_cities();

 });

      function  load_cities()
      {
    
       // return;

      var  country_id= $('#country_id').val();
       // alert(country_id);


       $.ajax({
        url:"{{url('backend/load_cities')}}",
        data:{country_id:country_id},
        type: "GET",
        success:function(data){


        }
        
       });

      }
        

    });


</script>


<fieldset>
    <legend> Business  Details</legend>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">

        <?php $statuses= [''=>'Select','ACTIVE'=>'ACTIVE','CLOSED'=>'CLOSED','SUSPENDED'=>'SUSPENDED'] ?>
        {!! Form::select('status',$statuses,null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@if(!empty($seller->licence))
<div class="form-group">
    <label class="col-md-4 control-label">Licence</label>
        <div class="col-md-6">

   <p>  <a  href="{{url($seller->licence)}}" target="_BLANK"> <img src="{{url($seller->licence)}}" width="130px" /> </a>
           <a href="{{url('backend/remove_licence/'.$seller->id)}}" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

@else
       
<div class="form-group {{ $errors->has('licence') ? 'has-error' : ''}}">
    {!! Form::label('licence', 'Licence', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::file('licence', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('licence', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@endif


@if(!empty($seller->id_front))
<div class="form-group">
    <label class="col-md-4 control-label">Front ID</label>
        <div class="col-md-6">

   <p> <a  href="{{url($seller->id_front)}}" target="_BLANK"> <img src="{{url($seller->id_front)}}" width="130px" />  </a>
           <a href="{{url('backend/remove_front_id/'.$seller->id)}}" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

@else
       
<div class="form-group {{ $errors->has('id_front') ? 'has-error' : ''}}">
    {!! Form::label('id_front', 'Front  ID', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::file('id_front', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('id_front', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@endif

@if(!empty($seller->id_back))
<div class="form-group">
    <label class="col-md-4 control-label">ID Back</label>
        <div class="col-md-6">

   <p> <a  href="{{url($seller->id_back)}}" target="_BLANK"> <img src="{{url($seller->id_back)}}" width="130px" />  </a>
           <a href="{{url('backend/remove_back_id/'.$seller->id)}}" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

@else
       
<div class="form-group {{ $errors->has('id_back') ? 'has-error' : ''}}">
    {!! Form::label('id_back', 'Back ID', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::file('id_back', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('id_back', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@endif





@if(!empty($seller->logo))
<div class="form-group">
    <label class="col-md-4 control-label">Logo</label>
        <div class="col-md-6">

   <p> <img src="{{url($seller->logo)}}" width="130px" /> 
           <a href="{{url('backend/remove_seller_logo/'.$seller->id)}}" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

@else
       
<div class="form-group {{ $errors->has('logo') ? 'has-error' : ''}}">
    {!! Form::label('logo', 'Logo', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::file('logo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@endif

<div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
    {!! Form::label('category_id', 'Category ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <?php  $categories= App\Category::where('level',1)->pluck('name','id')->prepend('Select','') ?>

        {!! Form::select('category_id',$categories, null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','id'=>'category_id'] : ['class' => 'form-control']) !!}
        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('registration_number') ? 'has-error' : ''}}">
    {!! Form::label('registration_number', 'Registration No', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('registration_number', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('registration_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('opening_hours') ? 'has-error' : ''}}">
    {!! Form::label('opening_hours', 'Opening Hours', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
         <div class="input-group input-append bootstrap-timepicker">
                                                    <input id="timepicker1" name="opening_hours" value="{{ $seller->opening_hours or ''}}" type="text" class="form-control">
                                                    <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                </div>
        {!! $errors->first('opening_hours', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('closing_hours') ? 'has-error' : ''}}">
    {!! Form::label('closing_hours', 'Closing Hours', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group input-append bootstrap-timepicker">
          <input id="timepicker2" name="closing_hours" value="{{ $seller->closing_hours or ''}}" type="text" class="form-control">
                                                    <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                </div>
        {!! $errors->first('closing_hours', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
    {!! Form::label('country_id', 'Country ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <?php  $countries= App\Country::pluck('name','id')->prepend('Select','') ?>

        {!! Form::select('country_id',$countries, null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','id'=>'country_id'] : ['class' => 'form-control']) !!}
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
    {!! Form::label('city_id', 'City ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       <?php $cities= App\City::pluck('name','id')->prepend('select','');?>

        {!! Form::select('city_id',$cities, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('area_id') ? 'has-error' : ''}}">
    {!! Form::label('area_id', 'Area ', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">

        <?php $areas = App\Area::pluck('name','id')->prepend('select','') ?>
        {!! Form::select('area_id',$areas,null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('area_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('physical_location') ? 'has-error' : ''}}">
    {!! Form::label('physical_location', 'Physical Location', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('physical_location', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('physical_location', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}">
    {!! Form::label('email_address', 'Email Address', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('email_address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
    {!! Form::label('telephone', 'Telephone', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('telephone', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('other_telephone') ? 'has-error' : ''}}">
    {!! Form::label('other_telephone', 'Other Telephone', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('other_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('other_telephone', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</fieldset>
<fieldset><legend> Contact  Person  details </legend>
<div class="form-group {{ $errors->has('contact_person') ? 'has-error' : ''}}">
    {!! Form::label('contact_person', 'Contact Person', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('contact_person', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('contact_person', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('contact_telephone') ? 'has-error' : ''}}">
    {!! Form::label('contact_telephone', 'Contact Telephone', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('contact_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('contact_telephone', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('contact_email_address') ? 'has-error' : ''}}">
    {!! Form::label('contact_email_address', 'Contact Email Address', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('contact_email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('contact_email_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</fieldset>

<div class="form-group {{ $errors->has('warehouse_id') ? 'has-error' : ''}}">
    {!! Form::label('warehouse_id', 'Warehouse', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <?php $warehouses= App\Warehouse::pluck('name','id')->prepend('select',''); ?>
        {!! Form::select('warehouse_id',$warehouses, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('warehouse_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<fieldset><legend> Banking  details</legend>

<div class="form-group {{ $errors->has('bank_name') ? 'has-error' : ''}}">
    {!! Form::label('bank_name', 'Bank Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('bank_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('account_name') ? 'has-error' : ''}}">
    {!! Form::label('account_name', 'Account Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('account_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('account_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('account_number') ? 'has-error' : ''}}">
    {!! Form::label('account_number', 'Account Number', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('account_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('account_number', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('swift_code') ? 'has-error' : ''}}">
    {!! Form::label('swift_code', 'Swift Code', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('swift_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('swift_code', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('bank_code') ? 'has-error' : ''}}">
    {!! Form::label('bank_code', 'Bank Code', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('bank_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
        {!! $errors->first('bank_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</fieldset>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
