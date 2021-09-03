@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>About Us</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 2em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">About Us</div>

                     <div>
                        DIL.AFRICA is a fast growing e-commerce platform that offers our customers an unmatched shopping experience through provision of high quality goods, a wide variety of products, a simplified return process and an umatched quick delivery timelines. Our mission is to provide the world’s best customer experience through continuos innovation and linkages.  We have  leveraged  on  technology  to  ensure  that  our  customers  get  high quality goods. We do this by subjecting the products to quality assurance measures. This coupled by our extensive logistics network throughout the country ensures that customers are always satisfied and goods are delivered to them when they need them without unnecessary delay. DIL.AFRICA is a platform where you can expand your market presence and boost sales. 
We do country wide delivery of products. In Nairobi, we do deliveries within 6hrs while outside Nairobi we deliver within 24 hours. 
We deal in a wide variety of products ranging from televisions, laptops and computers, phones and tablets, men’s and women’s fashion, hair care products, makeup and cosmetic products, perfumes, as well as books.
DIL.AFRICA seeks to solve some of the problems customers face when buying online such as;
<ul style="margin-left: 10px;">
    <li>- Long delivery times</li>
    <li>- Not receiving exactly what you ordered</li>
    <li>- Poor quality of goods</li>
</ul>
             
                    </div>
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop