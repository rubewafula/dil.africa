@extends('customer::layouts.master')

@section('content')

<style>

    .body-content .terms-conditions-page .terms-conditions ol li {
        font-style: normal;
        font-size: 16px;
        color: #666;
        padding-bottom: 20px;
    }
</style>
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>Become a Seller</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 1.8em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">Selling at DIL.AFRICA</div>
                        <div>
                            <span style="font-size: 18px;color: #0f7dc2;">Becoming a seller at DIL.AFRICA is easy and straightforward. 4 simple steps and you are good to go.</span>

                            <ol style="margin-top: 15px;">
                                 <li>Visit  <a href="https://dil.africa/start" target="_blank">https://dil.africa/start</a></li>
                                 <li>Create  your  account  and  confirm by  clicking  on  the  verification  link sent to your email used during the registration process.</li>
                                 <li>Sign the agreement form.</li>
                                 <li>Log in via your email account.</li>
                                 <li>List your products and start selling.</li>
                             </ol>
                        </div>                       
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop