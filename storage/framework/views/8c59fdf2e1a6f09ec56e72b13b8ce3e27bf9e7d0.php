<?php $__env->startSection('content'); ?>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo e(url('/shop')); ?>">Home</a></li>
                <li class='active'>Terms & Conditions</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="terms-conditions-page">
            <div class="row">
                <div class="col-md-12 terms-conditions" style="line-height: 1.8em;">
                    <div class="col-md-12 heading-title" style="margin-bottom: 20px;">Frequently Asked Questions (FAQs)</div>

                    <div>
                        <h3>Which type of products does DIL.AFRICA deal in?</h3>
                        <div>
                            We deal in all types of products: from kitchen electronics, audio and audio-visuals electronics, phones, computers, tablets and accessories, Men’s and women’s fashion, hair care products, makeup and cosmetic products, perfumes,books etc. Please see our list of categories at the top of the page to have a full view of all the products that you can purchase from DIL.AFRICA.
                        </div>
                        <h3>Where are you located?</h3>
                        <div>
                            We are located at Visions Plaza along Mombasa Road, Nairobi Kenya 3rd floor, Suite 23. Please visit our contacts page for more details on our address and contact information.
                        </div>
                        <h3>How do you deliver to me?</h3>
                        <div>
                            DIL.AFRICA has invested heavily in transportation machinery to ensure that our customers receive their goods within 24 hrs. Depending on the customer's geographical location and /or how fragile the good is, we may deliver by road or by air. In all cases, we take the necessary steps to ensure that we stick to our SLA to our customers as implied 
                        </div>
                        <h3>At what time should I expect to receive my product after placing an order successfully?</h3>
                        <div>
                            For orders placed before 10AM (GMT+3), our customers can expect to receive their goods at around 4PM. Orders placed after 10 AM are delivered by 9AM the following day. In instances where this is not possible, DIL.AFRICA takes all the necessary actions to keep our customers informed of any challenges and the expected time of delivery. 
                        </div>
                        <h3>How can I start selling at DIL.AFRICA?</h3>
                        <div>
                             You can set up your business and start selling in 4 easy steps.
                             <ol>
                                 <li>Visit  <a href="https://dil.africa/start" target="_blank">https://dil.africa/start</a></li>
                                 <li>Create  your  account  and  confirm by  clicking  on  the  verification  link  on  your  email.</li>
                                 <li>Sign the agreement form.</li>
                                 <li>Log in via your email account.</li>
                                 <li>List your products and start selling.</li>
                             </ol>
                        </div>
                        <h3>What are your terms and conditions?</h3>
                        <div>
                            Please refer to our <a href="<?php echo e(url('shop/terms-conditions')); ?>">Terms and Conditions</a> for our comprehensive terms and conditions.
                        </div>
                        
                    </div>
                </div>			
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.container -->
</div><!-- /.body-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>