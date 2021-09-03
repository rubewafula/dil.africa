<div id="advertisement" class="advertisement">
    <?php ($testimonial = new \Modules\Customer\Entities\Testimonial()); ?>
    <?php ($testimonials = $testimonial->getTestimonials()); ?>
    
    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="item">
        <div class="avatar"><img src="<?php echo e(url('assets/images/testimonials/'.$t->image_url)); ?>" alt="Image"></div>
        <div class="testimonials"><em>"</em> <?php echo e($t->message); ?> <em>"</em></div>
        <div class="clients_author"><?php echo e($t->name); ?>	
            <span><?php echo e($t->organization); ?></span>	
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>