@extends('customer::layouts.master')

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{url('/shop')}}">Home</a></li>
                <li class='active'>Return & Refunds Policy</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 1.8em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">Return & Refunds Policy</div>

                    <div>
                        <h3>What I am allowed to return?</h3>
                        <div>
                            You can return any product purchased from DIL.AFRICA subject to the following conditions
                            <ol>
                                <li>A wrong product was delivered to you. In this case the product seal should not be broken unless this is an item that cannot be recognized visually without having to break the seal</li>
                                <li>The product did not meet the quality expectations, for instance, it is damaged</li>
                                <li>The product is defective and does not work according to the specifications.</li>
                                <li>Some parts are missing.</li>
                                <li>For Fashion and Clothing, if it does not fit you and need to changed. In this case, DIL.AFRICA will replace your product with one that fits you. In this case, the product must be returned while in the New Condition</li>
                            </ol>

                            Please note for certain items, you cannot return them solely on the basis of changing your mind. All electronics for instance cannot be returned on this basis.
                        </div>
                        <h3>What is the procedure to return an item?</h3>
                        <div>
                            To return an item to us, please get in touch with the customer care on 0797 522522or email us at info@dil.africa
                        </div>
                        <h3>How many days do I have to return a product?</h3>
                        <div>
                            Items must be returned within 7 days from the date of purchase. Please note that you can either drop off the item at our pickup stations or as may be advised by our customer service. For damaged products, please also note that they must be returned within 7 days and we do not accept any returns after the 7 day period. In such cases, we advise our customers to get in touch with the manufacturer to execute the warranty where applicable.
                        </div>
                        <h3>How do I know of the status of my returns?</h3>
                        <div>
                            We will regularly update you on call, email and SMS on the status of your return
                        </div>
                        <h3>Am I required to return the whole order?</h3>
                        <div>
                             Not at all, you can simply return the item that has a problem
                        </div>                                     
                    </div>
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop