    <!-- ================================== TOP NAVIGATION ================================== -->
    <!-- /.side-menu -->
    <!-- ================================== TOP NAVIGATION : END ================================== -->	            <div class="sidebar-module-container">

        <div class="sidebar-filter">
            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
            <div class="sidebar-widget wow fadeInUp">
                <h3 class="section-title">shop by</h3>
                <div class="widget-header">
                    <h4 class="widget-title"> {{isset($category)?$category->name:"Categories"}} </h4>
                </div>
                <div class="sidebar-widget-body">
                    <div class="accordion">
                        @if(isset($category))
                        @php( $childcategories = $category->getSubCategories() )
                        @else
                        @php( $childcategories = \Modules\Customer\Entities\Category::where('status', 1)
                                ->where('level', 1)->get() )
                        @endif 
                        @php($count=0) 
                        @foreach($childcategories as $child)
                        @php($count++)
                        @php($sub_categories = $child->getSubCategories())
                        @if(count($sub_categories) > 0)
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a href="#collapse{{$count}}" data-toggle="collapse" class="accordion-toggle collapsed">
                                    {{$child->name}}
                                </a>
                            </div><!-- /.accordion-heading -->
                            
                            <div class="accordion-body collapse" id="collapse{{$count}}" style="height: 0px;">
                                <div class="accordion-inner">
                                    <ul>
                                        @foreach($sub_categories as $sub_cat)
                                        <li><a href="{{url('/shop/category/'.$sub_cat->slug)}}">{{$sub_cat->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- /.accordion-inner -->
                            </div><!-- /.accordion-body -->
                        </div><!-- /.accordion-group -->
                        @else
                        <div style="padding: 2px 7px;"> 
                            - <a style="color: #666666;" href="{{url('/shop/category/'.$child->slug)}}">{{$child->name}}</a>
                        </div>

                        @endif
                        @endforeach

                    </div><!-- /.accordion -->
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->

            <!-- ============================================== PRICE SILDER============================================== -->
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Price Slider</h4>
                </div>
                <div class="sidebar-widget-body m-t-10">
                    <div class="price-range-holder">
                        <span class="min-max">
                            <span class="pull-left">KES {{ $minimum_price}}</span>
                            <span class="pull-right">KES {{ $maximum_price}}</span>
                        </span>
                        <input type="text" id="amount" style="border:0; color:#666666; font-weight:bold;text-align:center;"/>

                        <input type="text" id="price-slider-id" class="price-slider" value="" >

                    </div><!-- /.price-range-holder -->
                    <button id="show_now" class="lnk btn btn-primary">Show Now</button>
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            <!-- ============================================== PRICE SILDER : END ============================================== -->
            <!-- ============================================== MANUFACTURES============================================== -->
            @if(count($brands) > 0)
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Brands</h4>
                </div>
                <div class="sidebar-widget-body">
                    <ul class="list">
                        @php($brands_array = [])
                        @foreach($brands as $brand)
                        @if(!in_array($brand->brand_name, $brands_array))
                        <li>
                            <a href="{{url('/shop/brand/'.$brand->brand_slug)}}">{{ ucfirst($brand->brand_name) }}</a>
                        </li>
                        @php(array_push($brands_array, $brand->brand_name))
                        @endif
                        @endforeach
                    </ul>
                    <!--<a href="#" class="lnk btn btn-primary">Show Now</a>-->
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            @endif
            
            <!-- ============================================== MANUFACTURES: END ============================================== -->
            <!-- ============================================== COLOR============================================== -->
            @if(count($colors) > 0)
            <div class="sidebar-widget wow fadeInUp">
                <div class="widget-header">
                    <h4 class="widget-title">Colors</h4>
                </div>
                <div class="sidebar-widget-body">
                    <ul class="list">
                        @php($colors_array = [])
                        @foreach($colors as $color)
                        @if(!in_array(strtoupper(trim($color->color)), $colors_array))
                        <li>
                            @if(isset($category))
                            <a href="{{url('/shop/category/search/color/'.$category->slug.'/'.$color->id)}}">{{ ucwords(strtolower($color->color)) }}</a>
                            @else
                            <a href="{{url('/shop/category/search/color/custom-search/'.$color->id)}}">{{ ucwords(strtolower($color->color)) }}</a>
                            @endif
                        </li>
                        @php(array_push($colors_array, strtoupper(trim($color->color))))
                        @endif
                        @endforeach
                    </ul>
                </div><!-- /.sidebar-widget-body -->
            </div><!-- /.sidebar-widget -->
            @endif
            <!-- ============================================== COLOR: END ============================================== -->
            <!-- ============================================== COMPARE============================================== -->
<!--            <div class="sidebar-widget wow fadeInUp outer-top-vs">
                <h3 class="section-title">Compare products</h3>
                <div class="sidebar-widget-body">
                    <div class="compare-report">
                        <p>You have no <span>item(s)</span> to compare</p>
                    </div> /.compare-report 
                </div> /.sidebar-widget-body 
            </div> /.sidebar-widget -->


        </div><!-- /.sidebar-filter -->

    </div>