<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="col-md-4 control-label"><?php echo e('Trip Name'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="<?php echo e(isset($trip->name) ? $trip->name : ''); ?>" >
        <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('departure_date') ? 'has-error' : ''); ?>">
    <label for="departure_date" class="col-md-4 control-label"><?php echo e('Departure Date'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="departure_date" type="text" id="departure_date" value="<?php echo e(isset($trip->departure_date) ? $trip->departure_date : ''); ?>" >
        <?php echo $errors->first('departure_date', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('departure_time') ? 'has-error' : ''); ?>">
    <label for="departure_time" class="col-md-4 control-label"><?php echo e('Departure Time'); ?></label>
    <div class="col-md-6">
        <input class="form-control" name="departure_time" type="text" id="departure_time" value="<?php echo e(isset($trip->departure_time) ? $trip->departure_time : ''); ?>" >
        <?php echo $errors->first('departure_time', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<div class="form-group <?php echo e($errors->has('vehicle_id') ? 'has-error' : ''); ?>">
    <label for="vehicle_id" class="col-md-4 control-label"><?php echo e('Bike / Vehicle'); ?></label>
    <div class="col-md-6">

        <?php $vehicles = \App\Vehicle::pluck('registration_no', 'id')->prepend('Select Bike / Vehicle', ''); ?>
        <?php echo e(Form::select('vehicle_id', $vehicles, $trip->vehicle_id, ['class'=>'form-control'])); ?>

        <?php echo $errors->first('vehicle_id', '<p class="help-block">:message</p>'); ?>

    </div>   
</div>

<div class="form-group <?php echo e($errors->has('active') ? 'has-error' : ''); ?>">
    <label for="active" class="col-md-4 control-label"><?php echo e('Status'); ?></label>
    <div class="col-md-6">
        <?php $status = ['1' => 'Active', '2' => 'Inactive']; ?>
        <?php echo e(Form::select('active', $status, $trip->active, ['class'=>'form-control'])); ?>

        <?php echo $errors->first('active', '<p class="help-block">:message</p>'); ?>

    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="<?php echo e(isset($submitButtonText) ? $submitButtonText : 'Create'); ?>">
    </div>
</div>