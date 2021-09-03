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
        url:"<?php echo e(url('backend/load_cities')); ?>",
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
<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <?php echo Form::label('name', 'Name', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('name', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

    <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
    <?php echo Form::label('status', 'Status', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">

        <?php $statuses= [''=>'Select','ACTIVE'=>'ACTIVE','CLOSED'=>'CLOSED','SUSPENDED'=>'SUSPENDED'] ?>
        <?php echo Form::select('status',$statuses,null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('status', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<?php if(!empty($seller->licence)): ?>
<div class="form-group">
    <label class="col-md-4 control-label">Licence</label>
        <div class="col-md-6">

   <p>  <a  href="<?php echo e(url($seller->licence)); ?>" target="_BLANK"> <img src="<?php echo e(url($seller->licence)); ?>" width="130px" /> </a>
           <a href="<?php echo e(url('backend/remove_licence/'.$seller->id)); ?>" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

<?php else: ?>
       
<div class="form-group <?php echo e($errors->has('licence') ? 'has-error' : ''); ?>">
    <?php echo Form::label('licence', 'Licence', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::file('licence', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('licence', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<?php endif; ?>


<?php if(!empty($seller->id_front)): ?>
<div class="form-group">
    <label class="col-md-4 control-label">Front ID</label>
        <div class="col-md-6">

   <p> <a  href="<?php echo e(url($seller->id_front)); ?>" target="_BLANK"> <img src="<?php echo e(url($seller->id_front)); ?>" width="130px" />  </a>
           <a href="<?php echo e(url('backend/remove_front_id/'.$seller->id)); ?>" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

<?php else: ?>
       
<div class="form-group <?php echo e($errors->has('id_front') ? 'has-error' : ''); ?>">
    <?php echo Form::label('id_front', 'Front  ID', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::file('id_front', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('id_front', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<?php endif; ?>

<?php if(!empty($seller->id_back)): ?>
<div class="form-group">
    <label class="col-md-4 control-label">ID Back</label>
        <div class="col-md-6">

   <p> <a  href="<?php echo e(url($seller->id_back)); ?>" target="_BLANK"> <img src="<?php echo e(url($seller->id_back)); ?>" width="130px" />  </a>
           <a href="<?php echo e(url('backend/remove_back_id/'.$seller->id)); ?>" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

<?php else: ?>
       
<div class="form-group <?php echo e($errors->has('id_back') ? 'has-error' : ''); ?>">
    <?php echo Form::label('id_back', 'Back ID', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::file('id_back', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('id_back', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<?php endif; ?>





<?php if(!empty($seller->logo)): ?>
<div class="form-group">
    <label class="col-md-4 control-label">Logo</label>
        <div class="col-md-6">

   <p> <img src="<?php echo e(url($seller->logo)); ?>" width="130px" /> 
           <a href="<?php echo e(url('backend/remove_seller_logo/'.$seller->id)); ?>" onclick="return  confirm('Are  you  sure?')" class="btn btn-danger">  Remove</a>
   </p>
</div>
</div>

<?php else: ?>
       
<div class="form-group <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
    <?php echo Form::label('logo', 'Logo', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::file('logo', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('logo', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<?php endif; ?>

<div class="form-group <?php echo e($errors->has('category_id') ? 'has-error' : ''); ?>">
    <?php echo Form::label('category_id', 'Category ', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php  $categories= App\Category::where('level',1)->pluck('name','id')->prepend('Select','') ?>

        <?php echo Form::select('category_id',$categories, null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','id'=>'category_id'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('category_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('registration_number') ? 'has-error' : ''); ?>">
    <?php echo Form::label('registration_number', 'Registration No', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('registration_number', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('registration_number', '<p class="help-block">:message</p>'); ?>

    </div>
</div>


<div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
    <?php echo Form::label('description', 'Description', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('description', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('opening_hours') ? 'has-error' : ''); ?>">
    <?php echo Form::label('opening_hours', 'Opening Hours', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
         <div class="input-group input-append bootstrap-timepicker">
                                                    <input id="timepicker1" name="opening_hours" value="<?php echo e(isset($seller->opening_hours) ? $seller->opening_hours : ''); ?>" type="text" class="form-control">
                                                    <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                </div>
        <?php echo $errors->first('opening_hours', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('closing_hours') ? 'has-error' : ''); ?>">
    <?php echo Form::label('closing_hours', 'Closing Hours', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <div class="input-group input-append bootstrap-timepicker">
          <input id="timepicker2" name="closing_hours" value="<?php echo e(isset($seller->closing_hours) ? $seller->closing_hours : ''); ?>" type="text" class="form-control">
                                                    <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                                </div>
        <?php echo $errors->first('closing_hours', '<p class="help-block">:message</p>'); ?>

    </div>
</div>


<div class="form-group <?php echo e($errors->has('country_id') ? 'has-error' : ''); ?>">
    <?php echo Form::label('country_id', 'Country ', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php  $countries= App\Country::pluck('name','id')->prepend('Select','') ?>

        <?php echo Form::select('country_id',$countries, null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required','id'=>'country_id'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('country_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('city_id') ? 'has-error' : ''); ?>">
    <?php echo Form::label('city_id', 'City ', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
       <?php $cities= App\City::pluck('name','id')->prepend('select','');?>

        <?php echo Form::select('city_id',$cities, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('city_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('area_id') ? 'has-error' : ''); ?>">
    <?php echo Form::label('area_id', 'Area ', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">

        <?php $areas = App\Area::pluck('name','id')->prepend('select','') ?>
        <?php echo Form::select('area_id',$areas,null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('area_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('physical_location') ? 'has-error' : ''); ?>">
    <?php echo Form::label('physical_location', 'Physical Location', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('physical_location', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('physical_location', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('email_address') ? 'has-error' : ''); ?>">
    <?php echo Form::label('email_address', 'Email Address', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('email_address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('email_address', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('telephone') ? 'has-error' : ''); ?>">
    <?php echo Form::label('telephone', 'Telephone', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('telephone', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('telephone', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('other_telephone') ? 'has-error' : ''); ?>">
    <?php echo Form::label('other_telephone', 'Other Telephone', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('other_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('other_telephone', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
</fieldset>
<fieldset><legend> Contact  Person  details </legend>
<div class="form-group <?php echo e($errors->has('contact_person') ? 'has-error' : ''); ?>">
    <?php echo Form::label('contact_person', 'Contact Person', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('contact_person', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('contact_person', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('contact_telephone') ? 'has-error' : ''); ?>">
    <?php echo Form::label('contact_telephone', 'Contact Telephone', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('contact_telephone', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('contact_telephone', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('contact_email_address') ? 'has-error' : ''); ?>">
    <?php echo Form::label('contact_email_address', 'Contact Email Address', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('contact_email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('contact_email_address', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
</fieldset>

<div class="form-group <?php echo e($errors->has('warehouse_id') ? 'has-error' : ''); ?>">
    <?php echo Form::label('warehouse_id', 'Warehouse', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php $warehouses= App\Warehouse::pluck('name','id')->prepend('select',''); ?>
        <?php echo Form::select('warehouse_id',$warehouses, null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('warehouse_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<fieldset><legend> Banking  details</legend>

<div class="form-group <?php echo e($errors->has('bank_name') ? 'has-error' : ''); ?>">
    <?php echo Form::label('bank_name', 'Bank Name', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('bank_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('bank_name', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('account_name') ? 'has-error' : ''); ?>">
    <?php echo Form::label('account_name', 'Account Name', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('account_name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('account_name', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('account_number') ? 'has-error' : ''); ?>">
    <?php echo Form::label('account_number', 'Account Number', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('account_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('account_number', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('swift_code') ? 'has-error' : ''); ?>">
    <?php echo Form::label('swift_code', 'Swift Code', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('swift_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('swift_code', '<p class="help-block">:message</p>'); ?>

    </div>
</div><div class="form-group <?php echo e($errors->has('bank_code') ? 'has-error' : ''); ?>">
    <?php echo Form::label('bank_code', 'Bank Code', ['class' => 'col-md-4 control-label']); ?>

    <div class="col-md-6">
        <?php echo Form::text('bank_code', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']); ?>

        <?php echo $errors->first('bank_code', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
</fieldset>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <?php echo Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']); ?>

    </div>
</div>
