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

                                    <table id="wishlist_table" class="table table-striped table-bordered" style="width:100%;">
                                        <thead>
                                            <tr style="background:#fff;color:#337AB7;">
                                                <th>Date</th>
                                                <th>Product Name</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Category</th>
                                                <th style="background: #FFA200;border: 1px solid #FFA200;color: #FFF;">Add to Cart</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($wishlists as $wishlist)

                                            <tr>
                                                <td>{{$wishlist->created_at}}</td>
                                                <td>{{$wishlist->product->name}}</td>
                                                <td>{{$wishlist->product_price->color}}</td>
                                                <td>{{$wishlist->product_price->size}}</td>
                                                <td>{{$wishlist->product->category->name}}</td>
                                                <td>
                                                    <form method="POST" action="{{url('shop/add_to_cart')}}">
                                                        <div class="row">


                                                        <div class="col-sm-4">
                                                            <div>
                                                                <div class="quant-input">                                       
                                                                    <input type="number" step="1" name="quantity" placeholder="Qty" value="1" style="width:38px;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4" style="margin-left: 10px;">

                                                            <input type="hidden" value="{{$wishlist->product_price->id}}" name="product_ref" />
                                                            <button data-toggle="tooltip" class="btn btn-primary icon addtocart" style="height: 24px;padding: 0px 10px;" type="submit" title="Add Item to Cart">
                                                                <i class="fa fa-shopping-cart"></i>													
                                                            </button>

                                                        </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>						

                                            @endforeach
                                        </tbody>
                                    </table>

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