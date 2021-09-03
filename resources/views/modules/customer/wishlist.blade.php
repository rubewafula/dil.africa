@extends('customer::layouts.master')

@section('content')

<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            @include('customer::product.sidebar.index')
            <div class='col-md-9'>
                <div class="detail-block">
                    <div class="row  wow fadeInUp">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row" style="padding-top: 15px;line-height: 1.8em;background: #f5f5f5;">
                                        
                                        <div class="col-md-8 col-sm-8">
                                            Total: <span class="header-text"> {{ $total}}</span>                       
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            {!! Form::open(['method' => 'GET', 'url' => '/shop/wishlist', 'class' => 'navbar-form navbar-right', 'role' => 'search', 'style' => 'margin-top:0px;'])  !!}
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" placeholder="Search...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 user-header" style="margin-top: 10px;">
                                           Your Wishlist
                                        </div>
                                    </div>

                                    <style> 
                                        .col-padding{
                                            padding:  5px 15px;
                                        }
                                    </style>

                                    <div id="wishlist_table" class="row hidden-xs" style="background:#ddd;color:#337AB7;padding: 10px 0px;font-weight: bold;">
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Date</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Product Name</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Color</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Size</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Category</div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">Add to Cart</div>                    
                                    </div>

                                    @foreach($wishlists as $wishlist)
                                    @if($wishlist->product != null)
                                    <div class="row" style="background:#fff;padding: 10px 0px;border-bottom: 1px solid #ddd;">
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Date: </span>{{$wishlist->created_at}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Product Name: </span>{{$wishlist->product->name}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Color: </span> {{$wishlist->product_price->color}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Size: </span> {{$wishlist->product_price->size}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            <span class="hidden-lg hidden-md blue-text"> Category: </span> {{$wishlist->product->category->name}}
                                        </div>
                                        <div class="col-md-2 col-xs-12 col-sm-12 col-padding">
                                            
                                            <form method="POST" action="{{url('shop/add_to_cart')}}">
                                                <div class="row">
                                                    <div class="col-xs-4 hidden-lg hidden-md">
                                                        <span class="blue-text"> Add to Cart: </span>
                                                    </div>
                                                    <div class="col-sm-4 col-xs-1">
                                                        <div>
                                                            <div class="quant-input">                                       
                                                                <input type="number" step="1" name="quantity" placeholder="Qty" value="1" style="width:38px;">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 col-xs-2" style="margin-left: 10px;">

                                                        <input type="hidden" value="{{$wishlist->product_price->id}}" name="product_ref" />
                                                        <button data-toggle="tooltip" class="btn btn-primary icon addtocart" style="height: 24px;padding: 0px 10px;" type="submit" title="Add Item to Cart">
                                                            <i class="fa fa-shopping-cart"></i>                                                 
                                                        </button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>  
                                                    
                                    </div>
                                     @endif  

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div>

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">

                        @include('customer::home.recommended.index')
                    </div><!-- /.scroll-tabs -->
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop