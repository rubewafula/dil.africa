   <div class="page-sidebar sidebar horizontal-bar">
                <div class="page-sidebar-inner">
                    <ul class="menu accordion-menu" style="">
                        <li class="nav-heading"><span>Navigation</span></li>
                        <li class="active"><a href="{{url('seller')}}"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li>

                            <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p>Products </p><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li>
                                  <a href="{{url('seller/products')}}">Products</a></li>
                                <li>
                                  <a href="{{url('seller/product/classify')}}"> Add New  Product</a>
                                </li>
                              <!--   <li><a href="{{url('seller/import_products')}}">Import  Products</a></li> -->                                                    
                            </ul>
                        </li>
                             <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p>Orders </p><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li><a href="{{url('seller/orders')}}">Orders</a></li>
                                
                            </ul>
                        </li>

                                 <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p>Promotions </p><span class="arrow"></span></a>
                                <ul class="sub-menu">
                                    <li><a href="{{url('seller/my-promotions')}}">My Promotions</a></li>
                                                                
                                    
                                </ul>
                            </li>
                           @role('seller')
                                   <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p>Reports </p><span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li><a href="{{url('seller/sales_report')}}">Sales Report</a></li>
                                 <!-- <li><a href="{{url('seller/catalog')}}">Catalog Perfomance</a></li> -->
                                <li><a href="{{url('seller/sales_report')}}"> Account Statements</a></li>

                            </ul>
                        </li>

                        @endrole
               
          @role('seller')
                                                
    <li class="droplink"><a href="#"><span class="menu-icon icon-briefcase"></span><p>Settings </p><span class="arrow"></span></a>
                            <ul class="sub-menu">

                                <li><a href="{{url('seller/manage_profile')}}">Manage  Profile</a></li>
                                 <li><a href="{{url('seller/users')}}">Manage Users</a></li>
                                
                            </ul>
            </li>

                    @endrole

                    </ul>
                </div><!-- Page Sidebar Inner -->
            </div><!-- Page Sidebar -->