<div class="form-group <?php echo e($errors->has('registration_no') ? 'has-error' : ''); ?>">
    <label for="registration_no" class="col-md-4 control-label"><?php echo e('Registration Number'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="registration_no" type="text" id="registration_no" value="<?php echo e(isset($vehicle->registration_no) ? $vehicle->registration_no : ''); ?>" >
        <?php echo $errors->first('registration_no', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('vehicle_type') ? 'has-error' : ''); ?>">
    <label for="vehicle_type" class="col-md-4 control-label"><?php echo e('Type of Vehicle'); ?></label>
    <div class="col-md-6">

        <?php $vehicle_types = ['' => 'Select Type of Vehicle', 'LORRY' => 'Lorry', 
            'MOTOR BIKE' => 'Motor Bike', 'PICK UP' => 'Pick Up', 'TRUCK' => 'Truck', 'VAN' => 'Van']; ?>
        <?php echo e(Form::select('vehicle_type', $vehicle_types, $vehicle->vehicle_type, ['class'=>'form-control'])); ?>

        <?php echo $errors->first('vehicle_type', '<p class="help-block">:message</p>'); ?>

    </div>   
</div>
<div class="form-group <?php echo e($errors->has('capacity') ? 'has-error' : ''); ?>">
    <label for="capacity" class="col-md-4 control-label"><?php echo e('Capacity (Kgs)'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="capacity" type="text" id="capacity" value="<?php echo e(isset($vehicle->capacity) ? $vehicle->capacity : ''); ?>" />
        <?php echo $errors->first('capacity', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('owner_name') ? 'has-error' : ''); ?>">
    <label for="owner_name" class="col-md-4 control-label"><?php echo e('Owner\'s Name'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="owner_name" type="text" id="owner_name" value="<?php echo e(isset($vehicle->owner_name) ? $vehicle->owner_name : ''); ?>" />
        <?php echo $errors->first('owner_name', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('owner_contacts') ? 'has-error' : ''); ?>">
    <label for="owner_contacts" class="col-md-4 control-label"><?php echo e('Owner\'s Contacts'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="owner_contacts" type="text" id="owner_contacts" value="<?php echo e(isset($vehicle->owner_contacts) ? $vehicle->owner_contacts : ''); ?>" />
        <?php echo $errors->first('owner_contacts', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('owner_address') ? 'has-error' : ''); ?>">
    <label for="owner_address" class="col-md-4 control-label"><?php echo e('Owner\'s Address'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="owner_address" type="text" id="owner_address" value="<?php echo e(isset($vehicle->owner_address) ? $vehicle->owner_address : ''); ?>" />
        <?php echo $errors->first('owner_address', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group <?php echo e($errors->has('active') ? 'has-error' : ''); ?>">
    <label for="active" class="col-md-4 control-label"><?php echo e('Status'); ?></label>
    <div class="col-md-6">
        <?php $status = ['1' => 'Active', '0' => 'Inactive']; ?>
        <?php echo e(Form::select('active', $status, $vehicle->active or '',['class'=>'form-control'])); ?>

        <?php echo $errors->first('active', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="<?php echo e(isset($submitButtonText) ? $submitButtonText : 'Create'); ?>">
    </div>
</div>