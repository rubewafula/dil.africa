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
                <li class='active'>Become our Sales Agent</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 1.8em;">
                    
                        <div class="col-md-12" style="background: linear-gradient(#0f7dc2, #eee);height: 300px;border-radius: 5px;margin-bottom: 15px;">
                            <div class="col-md-12" style="margin:100px 0px;text-align: center;">
                                
                                <button class="btn" style="background: #fff;padding: 10px 50px;color: #F89530;font-size: 26px;font-weight: bold;font-family: serif;">
                                    Become a DIL.AFRICA Sales Agent
                                </button>
                                <span style="font-weight: normal;font-family: serif;font-style: italic;color: #fff;text-align: center;padding-top: 15px;font-size: 16px;">Earn commissions to as much as 10% on orders that you successfully place on behalf of the customers</span>
                                <!-- <div style="font-weight: normal;font-family: serif;color: #cc0000;text-align: center;padding-top: 15px;font-size: 16px;">NB: This window is currently closed. Please check with us later! Thank you</div> -->

                                <div style="font-weight: bold;font-family: serif;text-align: center;padding-top: 15px;font-size: 16px;">
                                    <a style="color: #FFA200;" href="{{url('/shop/agent/register')}}">Register as a DIL.Africa Sales Agent (DASA)</a> 
                                </div>


                            </div>
                        </div>
                        <div>
                            <span style="font-size: 18px;color: #0f7dc2;">How it Works</span>

                            <ol style="margin-top: 15px;">
                                 <li>Register with DIL.AFRICA as a Sales Agent</li>
                                 <li>Once approved, promote products from DIL.AFRICA and help customers to successfully place their orders.</li>
                                 <li>That's it, you earn your commission on each successful order that you do on behalf of our customers.</li>
                             </ol>
                        </div>                       
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
@stop