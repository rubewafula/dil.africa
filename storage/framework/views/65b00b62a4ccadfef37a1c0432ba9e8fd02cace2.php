<div class=" horizontal-bar" >
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu" style="margin-top:-55px">
            <li class="nav-heading"><span>Navigation</span></li>
            <li class="active"><a href="<?php echo e(url('backend')); ?>"><span class="menu-icon icon-speedometer"></span><p style="text-transform: uppercase;">Dashboard</p></a></li>
            <li><a href="<?php echo e(url('backend/orders')); ?>"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Orders</p></a></li>
            <li><a href="<?php echo e(url('backend/customers')); ?>"><span class="menu-icon icon-users"></span><p style="text-transform: uppercase;">Customers</p></a></li>

            <li class="droplink"><a href="#"><span class="menu-icon icon-envelope-open"></span><p style="text-transform: uppercase;">Administration</p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    <li> <a href="<?php echo e(url('backend/products')); ?>"> Products</a></li>
                    <li><a href="<?php echo e(url('backend/sellers')); ?>">Seller  Management</a></li>
                    <li><a href="<?php echo e(url('backend/product_reviews')); ?>">Product  Reviews</a></li>
                    <li><a href="<?php echo e(url('backend/agents')); ?>">Agents  Management</a></li>
                </ul>
            </li>
            <li class="nav-heading"><span>Inquiries </span></li>
            <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p style="text-transform: uppercase;">Setup </p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    <li><a href="<?php echo e(url('backend/brands')); ?>">Brands</a></li>
                    <li><a href="<?php echo e(url('backend/categories')); ?>">Categories</a></li>
                    <li><a href="<?php echo e(url('backend/sub_categories')); ?>">Sub Categories</a></li>
                    <li><a href="<?php echo e(url('backend/countries')); ?>">Countries</a></li>
                    <li><a href="<?php echo e(url('backend/locations')); ?>">Locations Management</a></li>
                    <li><a href="<?php echo e(url('backend/warehouses')); ?>"> Warehouse  Management</a></li>
                    <li><a href="<?php echo e(url('backend/roles')); ?>">Roles  Administration</a></li>
                     <li><a href="<?php echo e(url('backend/suspension_reasons')); ?>"> Suspension  Reasons</a></li>
                     <li><a href="<?php echo e(url('backend/shipping_prices')); ?>"> Shipping  Prices</a></li>
                     <li><a href="<?php echo e(url('backend/feature_types')); ?>"> Feature  Types</a></li>
                       <li><a href="<?php echo e(url('backend/cancellation_reasons')); ?>">
                        Cancellation  Reasons</a></li> 

                        <li><a href="<?php echo e(url('backend/quality_issues')); ?>"> 
                        Quality  Issues</a></li>

                        <li><a href="<?php echo e(url('backend/quality_issues')); ?>"> 
                        Pickup Stations</a></li>
                        <li><a href="<?php echo e(url('backend/special-shipping')); ?>"> Special Shipping Rates</a></li>
                    
                </ul>
            </li>

        <li><a href="<?php echo e(url('backend/users')); ?>"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Users  Management</p></a></li>

        <li  class="droplink"><a href="<?php echo e(url('backend/logistics')); ?>"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Logistics</p> <span class="arrow"></span></a>
        <ul class="sub-menu">
            <li><a href="<?php echo e(url('backend/riders')); ?>">Riders</a></li>
            <li><a href="<?php echo e(url('backend/vehicles')); ?>">Vehicles</a></li>
        </ul>

        </li>
        <li><a href="<?php echo e(url('backend/promotion-banners')); ?>"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Promotional Banners</p></a></li>
           
               
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->