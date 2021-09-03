@extends('customer::layouts.category_master')

@section('content')

<script>
  fbq('track', 'Search');
</script>


<script>

$(document).ready(function(){
    
    $("#options_list").click(function(){
        
        var selected = $("#options_list").val();
        
    });
    
    // $("#search_resultstable").dataTable();

    /*===================================================================================*/
    /* PRICE SLIDER
    /*===================================================================================*/

    
    var start = {{$minimum_price}};
    var end = {{$maximum_price}};

    var active_start = {{ isset($active_minprice)?$active_minprice:0 }}
    var active_end = {{ isset($active_maxprice)?$active_maxprice:0 }}

    if(active_start == 0){

        active_start = start;
    }

    if(active_end == 0){

        active_end = end;
    }

    // Price Slider

    if ($('.price-slider').length > 0) {
        $('.price-slider').slider({
            min: start,
            max: end,
            step: 10,
            value: [active_start, active_end],
            handle: "square"
        });

    }

    $('#show_now').click(function() {

        var range = $('#price-slider-id').val();

        @if(isset($category))
        var slug = "{{$category->slug}}";
        @else
        var slug = "custom-search";
        @endif

        var from = range.split(",")[0];
        var to = range.split(",")[1];

        var BASE_URL = "{{url('/shop/')}}";

        window.location.replace(BASE_URL+"/category/"+slug+"/"+from+"/"+to);

    });
   
});

</script>

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row'>
            <div class='col-md-3 sidebar hidden-sm hidden-xs'>
                @include('customer::category.sidebar')
            </div>
            
            <div class='col-md-9'>
                <!-- ========================================== SECTION – HERO ========================================= -->

                <div id="category" class="category-carousel hidden-xs">

                </div>

                @if(count($products) > 0)

                <!-- ========================================= SECTION – HERO : END ========================================= -->
                <div class="clearfix filters-container hidden-xs hidden-sm">
                    <div class="row">

                        <div class="col col-sm-6 col-md-2">
                            <div class="filter-tabs">
                                <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                    <li class="active">
                                        <a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th-large"></i>Grid</a>
                                    </li>
                                    <li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i>List</a></li>
                                </ul>
                            </div><!-- /.filter-tabs -->
                        </div><!-- /.col -->
                            <div class="col col-sm-6 col-md-6 no-padding">
                                <div class="lbl-cnt">
                                    <span class="lbl">Sort byy</span>
                                    <div class="fld inline">
                                        <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                            <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                {{ isset($search_mode)?$search_mode:"Default"}} <span class="caret"></span>
                                            </button>

                                            <ul role="menu" class="dropdown-menu" id="options_list">
                                                @if(isset($category))
                                                <li role="presentation"><a href="{{url('shop/search/lowest/'.$category->slug)}}">Price:Lowest first</a></li>
                                                <li role="presentation"><a href="{{url('shop/search/highest/'.$category->slug)}}">Price:Highest first</a></li>
                                                <li role="presentation"><a href="{{url('shop/search/name/'.$category->slug)}}">Product Name:A to Z</a></li>
                                                @else
                                                <li role="presentation"><a href="{{url('shop/search/lowest/custom-search')}}">Price:Lowest first</a></li>
                                                <li role="presentation"><a href="{{url('shop/search/highest/custom-search')}}">Price:Highest first</a></li>
                                                <li role="presentation"><a href="{{url('shop/search/name/custom-search')}}">Product Name:A to Z</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- /.fld -->
                                </div><!-- /.lbl-cnt -->
                            </div><!-- /.col -->

                            <div class="col col-sm-6 col-md-4  text-right">
                                
                                <!-- Pagination Here -->

                                                       
                            </div>
                        
                    </div><!-- /.row -->
                </div>

                @endif

                <div class="search-result-container ">
                    <div id="myTabContent" class="tab-content category-list" style="padding: 0px 20px;">
                        <div class="tab-pane active" id="grid-container">
                            <div class="category-product hidden-sm hidden-xs">									

                                @include('customer::category.single_grid_product')
                                
                            </div><!-- /.category-product -->
                            <div class="category-product hidden-md hidden-lg">                                  

                                @include('customer::category.single_grid_product_xs')
                                
                            </div><!-- /.category-product -->

                        </div><!-- /.tab-pane -->

                        <div class="tab-pane hidden-xs hidden-sm"  id="list-container">
                            <div class="category-product">
                                @include('customer::category.single_list_product')
                            </div><!-- /.category-product -->
                        </div><!-- /.tab-pane #list-container -->
                    </div><!-- /.tab-content -->
                    
                    <!-- Pagination Here -->

                </div><!-- /.search-result-container -->

            </div><!-- /.col -->

            <div class='col-md-3 sidebar hidden-md hidden-lg'>
                @include('customer::category.sidebar_xs')
            </div>

        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->

    </div><!-- /.body-content -->
    @stop