  @extends('seller::layouts.master')
  @section('content')
  <script type="text/javascript">
      
      $(document).ready(function(){

        $('#timepicker1').timepicker();
        $('#timepicker2').timepicker();

        var  base_url ="<?php echo  url('/'); ?>";

        populate_models();

        $('#business_type').change(function(){

         populate_models();
        });


    $('#pin_number').focusout(function(){

      var pin_number = $('#pin_number').val();

      if(pin_number.length > 0){

        var kraRGEX = /^[A-Za-z]{1}[0-9]{9}[A-Za-z]{1}$/;

        var result = kraRGEX.test(pin_number);
        if(!result){

           alert("Invalid KRA PIN Number. KRA PIN numbers have 11 characters, start and end with letters and all the other characters are numbers. Please verify");
        }

      }
    });

    function populate_models()
    {

       var business_model= $("#business_type").val();
       $(".personal_store").hide();
        $(".business").hide();

       if(business_model =='personal_store')
       {
          $(".personal_store").show();
       }

       if(business_model ==='business')
       {
                $(".business").show();
       }


    }

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
      <div  class="container">
           
             <div class="page-breadcrumb" >
                      {{ Breadcrumbs::render('seller') }}

                  </div>
                  <div class="page-title">
                      <div class="container">
                          <h3> Update  profile </h3>
                      </div>
                  </div>
                  <div id="main-wrapper"  >
                      <div class="row">
                          <div class="col-md-12">

                              <div class="panel panel-white">
                               <div class="panel-body">

   @if(Auth::user()->seller_id > 0)

          <?php $seller= \App\Seller::find(Auth::user()->seller_id) ?>

       @else

       <?php  $seller=   new \App\Seller; ?>

       @endif


        {!! Form::model($seller, [
                              'method' => 'POST',
                              'url' => ['/seller/update_account'],
                              'id'=>'seller_form',
                              'files' => true
                          ]) !!}


         <input  type="hidden" name="seller_id" value="{{Auth::user()->seller_id}}">

             {{csrf_field()}}

      <div  class="row">
          <div  class="col-md-4">


              <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
      {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
          {!! Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>

          </div>
        <div  class="col-md-4">
          @if(!empty($seller->logo))

           <img  src="{{$seller->logo}}" width="100px"/>

          @else
            <div class="form-group {{ $errors->has('logo') ? 'has-error' : ''}}">
      {!! Form::label('logo', 'Logo', ['class' => ' control-label']) !!}
      
          {!! Form::file('logo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
      
       </div>

       @endif

        </div>

        <div  class="col-md-4">
            <div class="form-group {{ $errors->has('pin_number') ? 'has-error' : ''}}">
      {!! Form::label('pin_number', 'Pin Number', ['class' => ' control-label']) !!}
      
          {!! Form::text('pin_number', null, ('' == 'required') ? ['class' => 'form-control', 'id' => 'pin_number'] : ['class' => 'form-control']) !!}
          {!! $errors->first('pin_number', '<p class="help-block">:message</p>') !!}
      
  </div>

        </div>

      </div>
   <div  class="row">
          <div  class="col-md-12">
              
              <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
      {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
          {!! Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
      
  </div>
          </div>

      </div> 


       <div  class="row">
          <div  class="col-md-4">
               <div class="form-group {{ $errors->has('business_type') ? 'has-error' : ''}}">
                  <label class="control-label">  Type  of  Business</label>

                  <?php $biz_types= [''=>'Select','personal_store'=>'Personal  Store','business'=>'Company/ Business ']; ?>
    {{Form::select('business_type',$biz_types,null,['class'=>'form-control','id'=>'business_type'])}}
                
               </div>
          </div>
        <div  class="col-md-4">
        <div class="form-group {{ $errors->has('business_model') ? 'has-error' : ''}}">
              
              <label class="control-label">  Business  Model</label>
          <?php $models= [''=>'Select','retailer'=>'Retailer','wholesaler'=>'Wholesaler ','wholesale_retail'=>'Wholesaler and  Retailer']; ?>

          {{Form::select('business_model',$models,null,['class'=>'form-control'])}}
    
              
          
           </div>
        </div>
    <div  class="col-md-4">
        
        <div  class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
          <label> Main  Category of  your  Products</label>

          <?php $categories= App\Category::where(['level'=>1])->pluck('name','id')->prepend('Select',''); ?>

          {{Form::select('category_id',$categories,null,['class'=>'form-control'])}}

        </div>

      </div>


      </div>

      <div  class="row personal_store" style="background:#f9f9f9">
          <div  class="col-md-4">
      <div class="form-group {{ $errors->has('id_number') ? 'has-error' : ''}}">
          <label> ID number/Passport Number</label>
          {{ Form::text('id_number',null,['class'=>'form-control'])}}
       </div>


      </div>

      <div  class="col-md-4 ">
        
        <div  class="form-group {{ $errors->has('id_front') ? 'has-error' : ''}}">
          <label> ID  FRONT side</label>

  {!! Form::file('id_front', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('id_front', '<p class="help-block">:message</p>') !!}

      </div>
       
      </div>
      <div  class="col-md-4">
        <div  class="form-group {{ $errors->has('id_back') ? 'has-error' : ''}}">
          <label> ID  Back side</label>

  {!! Form::file('id_back', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('id_back', '<p class="help-block">:message</p>') !!}

      </div>

      </div>
    </div>

    <div  class="row business" style="background:#f9f9f9">
          <div  class="col-md-4">
      <div class="form-group {{ $errors->has('registration_number') ? 'has-error' : ''}}">
          <label> Registration  Number</label>
          {{ Form::text('registration_number',null,['class'=>'form-control'])}}
                  {!! $errors->first('registration_number', '<p class="help-block">:message</p>') !!}

       </div>


      </div>

      <div  class="col-md-4 ">
        
        <div  class="form-group {{ $errors->has('id_front') ? 'has-error' : ''}}">
          <label> Business  Permit/Licence</label>

  {!! Form::file('licence', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('id_front', '<p class="help-block">:message</p>') !!}

      </div>
       
      </div>

     
     
    </div>

        <div  class="row">
          <div  class="col-md-4">
              
              <div class="form-group {{ $errors->has('opening_hours') ? 'has-error' : ''}}">
      {!! Form::label('opening_hours', 'Opening Hours', ['class' => 'control-label']) !!}
           <div class="input-group input-append bootstrap-timepicker">
                                                      <input id="timepicker1" name="opening_hours" value="{{ $seller->opening_hours or ''}}" type="text" class="form-control">
                                                      <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                  </div>
          {!! $errors->first('opening_hours', '<p class="help-block">:message</p>') !!}
      
  </div>
          </div>
        <div  class="col-md-4">
            <div class="form-group {{ $errors->has('closing_hours') ? 'has-error' : ''}}">
      {!! Form::label('closing_hours', 'Closing Hours', ['class' => 'control-label']) !!}
          <div class="input-group input-append bootstrap-timepicker">
            <input id="timepicker2" name="closing_hours" value="{{ $seller->closing_hours or ''}}" type="text" class="form-control">
                                                      <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                  </div>
          {!! $errors->first('closing_hours', '<p class="help-block">:message</p>') !!}
      
  </div>

        </div>

      </div>

  <div class="row">
      
      <div class="col-md-4">

          <div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
      {!! Form::label('country_id', 'Country ', ['class' => 'control-label']) !!}
          <?php  $countries= App\Country::pluck('name','id') ?>

          {!! Form::select('country_id',$countries, null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','id'=>'country_id'] : ['class' => 'form-control']) !!}
          {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
      
  </div>
          

      </div>

      <div class="col-md-4">
          <div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
      {!! Form::label('city_id', 'City ', ['class' => 'control-label']) !!}
         <?php $cities= App\City::pluck('name','id');?>

          {!! Form::select('city_id',$cities, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
      
  </div>
          
      </div>
      <div class="col-md-4">
         <div class="form-group {{ $errors->has('area_id') ? 'has-error' : ''}}">
      {!! Form::label('area_id', 'Area ', ['class' => 'control-label']) !!}

          <?php $areas = App\Area::pluck('name','id') ?>
          {!! Form::select('area_id',$areas,null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('area_id', '<p class="help-block">:message</p>') !!}
      
  </div> 

      </div>

  </div>

  <div class="row">
      
      

  </div>
  <div class="row">
      <div class="col-md-4">
          <div class="form-group {{ $errors->has('physical_location') ? 'has-error' : ''}}">
      {!! Form::label('physical_location', 'Physical Location', ['class' => ' control-label']) !!}
      
          {!! Form::text('physical_location', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('physical_location', '<p class="help-block">:message</p>') !!}
      
  </div>
          
      </div>
      <div class="col-md-4">
          <div class="form-group {{ $errors->has('email_address') ? 'has-error' : ''}}">
      {!! Form::label('email_address', 'Email Address', ['class' => 'control-label']) !!}
      
          {!! Form::text('email_address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('email_address', '<p class="help-block">:message</p>') !!}
      
  </div>

      </div>

      <div class="col-md-4">
          <div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
      {!! Form::label('telephone', 'Telephone', ['class' => 'control-label']) !!}
          {!! Form::text('telephone', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
      
  </div>
          
      </div>

  </div>



  <div class="row">
      
      <div class="col-md-4">
          
          <div class="form-group {{ $errors->has('other_telephone') ? 'has-error' : ''}}">
      {!! Form::label('other_telephone', 'Other Telephone', ['class' => 'control-label']) !!}
      
          {!! Form::text('other_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('other_telephone', '<p class="help-block">:message</p>') !!}
      
  </div>
      </div>
      <div class="col-md-4">
          <div class="form-group {{ $errors->has('contact_person') ? 'has-error' : ''}}">
      {!! Form::label('contact_person', 'Contact Person', ['class' => 'control-label']) !!}
      
          {!! Form::text('contact_person', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('contact_person', '<p class="help-block">:message</p>') !!}
      
  </div>
          
      </div>
      <div class="col-md-4">
          <div class="form-group {{ $errors->has('contact_telephone') ? 'has-error' : ''}}">
      {!! Form::label('contact_telephone', 'Contact Telephone', ['class' => ' control-label']) !!}
          {!! Form::text('contact_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('contact_telephone', '<p class="help-block">:message</p>') !!}

  </div>

      </div>

  </div>

  <div class="row">
      
      

  </div>

  <div class="row">
      <div class="col-md-4">
          <div class="form-group {{ $errors->has('contact_email_address') ? 'has-error' : ''}}">
      {!! Form::label('contact_email_address', 'Contact Email Address', ['class' => 'control-label']) !!}
      
          {!! Form::text('contact_email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('contact_email_address', '<p class="help-block">:message</p>') !!}
      
  </div>
          
      </div>
      <div class="col-md-6">
         
          
      </div>

  </div>
  <fieldset>
    <legend> Banking  Details</legend>

   <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : ''}}">
      {!! Form::label('bank_name', 'Bank Name', ['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-6">
          {!! Form::text('bank_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('bank_name', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
  <br>
  <br>
  <div class="form-group {{ $errors->has('account_name') ? 'has-error' : ''}}">
      {!! Form::label('account_name', 'Account Name', ['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-6">
          {!! Form::text('account_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('account_name', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
  <br>
  <br>
  <div class="form-group {{ $errors->has('account_number') ? 'has-error' : ''}}">
      {!! Form::label('account_number', 'Account Number', ['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-6">
          {!! Form::text('account_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('account_number', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
  <br>
  <br>
  <div class="form-group {{ $errors->has('swift_code') ? 'has-error' : ''}}">
      {!! Form::label('swift_code', 'Swift Code', ['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-6">
          {!! Form::text('swift_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('swift_code', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
  <br>
  <br>
  <div class="form-group {{ $errors->has('bank_code') ? 'has-error' : ''}}">
      {!! Form::label('bank_code', 'Bank Code', ['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-6">
          {!! Form::text('bank_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
          {!! $errors->first('bank_code', '<p class="help-block">:message</p>') !!}
      </div>
  </div>

  <div class="form-group">
      <div class="col-md-offset-4 col-md-4">
          {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Save Details', ['class' => 'btn btn-primary btn-lg', 'style' => 'margin-top:10px;background:#0f7dc2;']) !!}
      </div>
          
      </div>
      
  </fieldset>

                                  </div>

                              </div>
                          </div>
                      </div>
              <div>  

  @endsection