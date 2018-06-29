<div class="sidebar-widget-body outer-top-xs">
    <form role="form" method="POST" action="<?php echo e(url('/shop/subscribe/newsletter')); ?>">
        <div class="form-group">
            <label style="font-weight: normal;" for="email">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Subscribe to our newsletter">
        </div>
        <button class="btn btn-primary" type="submit">Subscribe</button>
    </form>
</div><!-- /.sidebar-widget-body -->