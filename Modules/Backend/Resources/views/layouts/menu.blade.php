<div class=" horizontal-bar" >
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu" style="margin-top:-55px">
            <li class="nav-heading"><span>Navigation</span></li>
            <li class="active"><a href="{{url('backend')}}"><span class="menu-icon icon-speedometer"></span><p style="text-transform: uppercase;">Dashboard</p></a></li>
            <li><a href="{{url('backend/orders')}}"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Orders</p></a></li>
            <li><a href="{{url('backend/customer-searches')}}">
                <span class="menu-icon icon-users"></span>
                <p style="text-transform: uppercase;">Searches</p></a></li>

            <li class="droplink"><a href="#"><span class="menu-icon icon-envelope-open"></span><p style="text-transform: uppercase;">Administration</p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    <li><a href="{{url('backend/customers')}}">Customers</a></li>
                    <li> <a href="{{url('backend/products')}}"> Products</a></li>
                    <li><a href="{{url('backend/campaign')}}">Weekly Campaign</a></li>
                    <li><a href="{{url('backend/campaign-groups')}}">SMS Campaign Groups</a></li>
                    <li><a href="{{url('backend/hot-deals')}}">Hot Deals</a></li>
                    <li><a href="{{url('backend/flash-sale')}}">Flash Sale</a></li>
                    <li><a href="{{url('backend/special-offers')}}">Special Offers</a></li>
                    <li><a href="{{url('backend/featured-categories')}}">Featured Categories</a></li>
                    <li><a href="{{ url('backend/product_reviews')}}">Product Reviews</a></li>
                    <li><a href="{{url('backend/sellers')}}">Sellers Management</a></li>
                    <li><a href="{{ url('backend/agents')}}">Agents Management</a></li>
                </ul>
            </li>
            <li class="nav-heading"><span>Inquiries </span></li>
            <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p style="text-transform: uppercase;">Setup </p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    <li><a href="{{url('backend/brands')}}">Brands</a></li>
                    <li><a href="{{url('backend/categories')}}">Categories</a></li>
                    <li><a href="{{url('backend/countries')}}">Countries</a></li>
                    <li><a href="{{url('backend/locations')}}">Locations Management</a></li>
                    <li><a href="{{url('backend/warehouses')}}"> Warehouse Management</a></li>
                    <li><a href="{{url('backend/roles')}}">Roles Administration</a></li>
                    <li><a href="{{url('backend/suspension_reasons')}}"> Suspension Reasons</a></li>
                    <li><a href="{{url('backend/shipping_prices')}}"> Shipping Prices</a></li>
                    <li><a href="{{url('backend/feature_types')}}"> Feature Types</a></li>
                    <li><a href="{{url('backend/cancellation_reasons')}}">Cancellation  Reasons</a></li> 

                    <li><a href="{{url('backend/quality_issues')}}">Quality  Issues</a></li>

                    <li><a href="{{url('backend/quality_issues')}}">Pickup Stations</a></li>
                    <li><a href="{{url('backend/special-shipping')}}"> Special Shipping Rates</a></li>
                    
                </ul>
            </li>

        <li><a href="{{url('backend/users')}}"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Users  Management</p></a></li>

        <li  class="droplink"><a href="{{url('backend/logistics')}}"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Logistics</p> <span class="arrow"></span></a>
        <ul class="sub-menu">
            <li><a href="{{url('backend/riders')}}">Riders</a></li>
            <li><a href="{{url('backend/vehicles')}}">Vehicles</a></li>
        </ul>

        </li>
        <li><a href="{{url('backend/promotion-banners')}}"><span class="menu-icon icon-user"></span><p style="text-transform: uppercase;">Promotional Banners</p></a></li>
           
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->