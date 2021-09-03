@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>Contact</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="contact-page">
            <div class="row">

                <div class="col-md-12 contact-map outer-bottom-vs">
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7484481716833!2d36.850505713959656!3d-1.3268954990322162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f11ec971ed07b%3A0x794da7f7b0b4e7e6!2sVision+Plaza%2C+Mombasa+Road%2C+Nairobi!5e0!3m2!1sen!2ske!4v1532612282942" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="col-md-9 contact-form">
                    <div class="col-md-12 contact-title">
                        <h4>Contact Form</h4>
                    </div>
                    <div class="col-md-4 ">
                        <form class="register-form" role="form">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputName">Your Name <span>*</span></label>
                                <input type="email" class="form-control unicase-form-control text-input" id="exampleInputName" placeholder="">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form class="register-form" role="form">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                                <input type="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" placeholder="">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form class="register-form" role="form">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputTitle">Title <span>*</span></label>
                                <input type="email" class="form-control unicase-form-control text-input" id="exampleInputTitle" placeholder="Title">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <form class="register-form" role="form">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputComments">Your Comments <span>*</span></label>
                                <textarea class="form-control unicase-form-control" id="exampleInputComments"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 outer-bottom-small m-t-20">
                        <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Send Message</button>
                    </div>
                </div>
                <div class="col-md-3 contact-info">
                    <div class="contact-title">
                        <h4>Our Address Information</h4>
                    </div>
                    <div class="clearfix address">
                        <span class="contact-i"><i class="fa fa-map-marker"></i></span>
                        <span class="contact-span">Vision Plaza, Mombasa Road , 3rd Floor, Suite 23 - Nairobi, Kenya</span>
                    </div>
                    <div class="clearfix phone-no">
                        <span class="contact-i"><i class="fa fa-mobile"></i></span>
                        <span class="contact-span">+(254) 797 522522</span>
                    </div>
                    <div class="clearfix email">
                        <span class="contact-i"><i class="fa fa-envelope"></i></span>
                        <span class="contact-span"><a href="#">info@dil.africa</a></span>
                    </div>
                </div>			
            </div><!-- /.contact-page -->
        </div><!-- /.row -->
    </div><!-- /.container -->
    @stop