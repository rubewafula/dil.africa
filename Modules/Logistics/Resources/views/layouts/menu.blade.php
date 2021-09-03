   <div class=" horizontal-bar" >
      <div class="page-sidebar-inner">
          <ul class="menu accordion-menu" style="margin-top:-55px">
              
              <li class="nav-heading"><span>Navigation</span></li>
              
              <li class="active"><a href="{{url('logistics')}}"><span class="menu-icon icon-speedometer"></span><p style="text-transform: uppercase;">Dashboard</p></a></li>

              <li class="droplink"><a href="#"><span class="menu-icon icon-user-open"></span>
                  <p style="text-transform: uppercase;"> Customer Orders</p><span class="arrow"></span></a>
                  
                  <ul class="sub-menu">
                    <li> <a href="{{ url('logistics/customer/confirmed-orders')}}"> Confirmed Orders </a></li>
                    <li> <a href="{{ url('logistics/customer/orders')}}"> Quality Passed Orders(READY) </a></li>
                    <li> <a href="{{ url('logistics/customer/orders/failed')}}"> Quality Failed Orders </a></li>
                    <li> <a href="{{ url('logistics/customer/orders/direct-shipment')}}"> Direct Shipment Orders</a></li>
                    <li> <a href="{{ url('logistics/customer/orders/scheduled')}}"> Scheduled Orders</a></li>
                    <li> <a href="{{ url('logistics/customer/orders/dispatched')}}"> Dispatched Orders</a></li>
                    <li> <a href="{{ url('logistics/customer/orders/delivered')}}"> Delivered Orders </a></li>
                    <li> <a href="{{ url('logistics/customer/orders/returned')}}"> Returned Orders </a></li>
                    <li> <a href="{{ url('logistics/customer/orders/partially-returned')}}"> Partially Returned Orders </a></li>
                  </ul>
              </li>

              <li class="droplink">
                <a href="#"><span class="menu-icon icon-envelope-open"></span>
                  <p style="text-transform: uppercase;"> Seller Orders</p><span class="arrow"></span>
                </a>
                  <ul class="sub-menu">

                    <li>
                      <a href="{{url('logistics/orders')}}"> Staged  Orders</a>
                    </li>
                    <li>
                      <a href="{{ url('logistics/incoming_orders')}}"> Incoming Orders </a>
                    </li>
                    <li>
                      <a href="{{ url('logistics/received_orders')}}"> Received  Orders </a>
                    </li>
                    <li>
                      <a href="{{ url('logistics/quality_passed_orders')}}">Quality  Passed orders </a>
                    </li>
                    <li>
                      <a href="{{ url('logistics/quality_failed_orders')}}"> Quality  Failed orders </a>
                    </li>
                    <li>
                      <a href="{{ url('logistics/rejected_orders')}}"> Rejected  Orders </a>
                    </li>

                  </ul>
              </li>
              
             <li>
                <a href="{{url('logistics/riders')}}">
                  <span class="menu-icon icon-user"></span>
                  <p style="text-transform: uppercase;">Riders Management</p></a>
             </li>

             <li>
                <a href="{{url('logistics/trips')}}">
                  <span class="menu-icon icon-user"></span>
                  <p style="text-transform: uppercase;">Trips  Management</p>
                </a>
             </li>

             <li class="droplink">
                <a href="#"><span class="menu-icon icon-speedometer">
                  
                </span><p style="text-transform: uppercase;">Setup </p></a>
                <ul class="sub-menu">
                  
                  <li>
                    <a href="{{ url('logistics/vehicles')}}">Vehicles </a>
                  </li>
                  <li>
                    <a href="{{ url('logistics/riders')}}">Riders </a>
                  </li>
                </ul>
            </li>          
             
        </ul>

    </div><!-- Page Sidebar Inner -->

</div><!-- Page Sidebar -->