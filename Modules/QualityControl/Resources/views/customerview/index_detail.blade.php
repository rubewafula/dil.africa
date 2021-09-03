@extends('customer::layouts.master')

@section('content')
@php($category =  null)
@php($mini_category = $product->category)
@php($mini_category_name = $mini_category->name)
@php($sub_category = \Modules\Customer\Entities\Category::find($mini_category->depends_on))
@if($sub_category != null)
@php($category = \Modules\Customer\Entities\Category::find($sub_category->depends_on))
@endif

<div class="breadcrumb" style="margin-bottom: 0px;">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                @if($category != null)
                <li><a href="{{url('shop/category/'.$category->id)}}">{{$category->name}}</a></li>
                @endif
                @if($sub_category != null)
                <li><a href="{{url('shop/category/'.$sub_category->id)}}">{{$sub_category->name}}</a></li>
                @endif
                @if($mini_category != null)
                <li><a href="{{url('shop/category/'.$mini_category->id)}}">{{$mini_category_name}}</a></li>
                @endif
                <li class='active'>{{$product->name}}</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
    <div class='container'>
        <div class='row single-product'>
            @include('qc::customerview.sidebar.index')
            <div class='col-md-9'>
                @include('qc::customerview.price_detail')

                <div class="product-tabs inner-bottom-xs  wow fadeInUp">
                    @include('customer::product.desc_review')
                </div><!-- /.product-tabs -->

                <!-- ============================================== Related PRODUCTS ============================================== -->
                <section class="section featured-product wow fadeInUp">
                    <h3 class="section-title">People Who Viewed This Item Also Viewed</h3>
                    @include('qc::customerview.related_products')
                </section><!-- /.section -->
                <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->


    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop