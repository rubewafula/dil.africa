<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="col-md-4 control-label"><?php echo e('Full Names'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="<?php echo e(isset($rider->name) ? $rider->name : ''); ?>" >
        <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
    <label for="phone" class="col-md-4 control-label"><?php echo e('Phone Number'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="phone" type="text" id="phone" value="<?php echo e(isset($rider->phone) ? $rider->phone : ''); ?>" >
        <?php echo $errors->first('phone', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <label for="email" class="col-md-4 control-label"><?php echo e('Email Address'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="email" id="email" value="<?php echo e(isset($rider->email) ? $rider->email : ''); ?>" >
        <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
    <label for="gender" class="col-md-4 control-label"><?php echo e('Gender '); ?></label>
    <div class="col-md-6">

    	<?php $genders = ['' => 'Select Gender', 'MALE' => 'Male', 'FEMALE' => 'Female', 'NOT DISCLOSED' => 'Not Disclosed']; ?>
    	<?php echo e(Form::select('gender', $genders, $rider->gender or '',['class'=>'form-control'])); ?>


        <?php echo $errors->first('gender', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('id_number') ? 'has-error' : ''); ?>">
    <label for="id_number" class="col-md-4 control-label"><?php echo e('ID Number'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="id_number" type="text" id="id_number" value="<?php echo e(isset($rider->id_number) ? $rider->id_number : ''); ?>" >
        <?php echo $errors->first('id_number', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('vehicle_id') ? 'has-error' : ''); ?>">
    <label for="vehicle_id" class="col-md-4 control-label"><?php echo e('Vehicle'); ?></label>
    <div class="col-md-6">
       <?php $vehicles= App\Vehicle::pluck('registration_no','id')->prepend('select',''); ?>
    	<?php echo e(Form::select('vehicle_id',$vehicles, $rider->vehicle_id or '',['class'=>'form-control'])); ?>

        <?php echo $errors->first('vehicle_id', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="<?php echo e(isset($submitButtonText) ? $submitButtonText : 'Create'); ?>">
    </div>
</div>