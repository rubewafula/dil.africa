<div class="row">
    <div class="col-sm-3">
        <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
            <li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
            <li><a data-toggle="tab" href="#review">REVIEW</a></li>
        </ul><!-- /.nav-tabs #product-tabs -->
    </div>
    <div class="col-sm-9">

        <div class="tab-content">

            <div id="description" class="tab-pane in active">
                <div class="product-tab">
                    {!!  $product->product_description !!}
                </div>	
            </div><!-- /.tab-pane -->

            <div id="review" class="tab-pane">
                <div class="product-tab">
                    @php($review = $product->getLatestReview())
                    @if($review != null)
                    <div class="product-reviews">
                        <h4 class="title">Customer Reviews</h4>                     
                        @php($utilities = new \Modules\Customer\Utilities\Utilities())
                        @php($days = $utilities->getTimeDifferenceInDays($review->created_at, date('Y-m-d H:i:s')))
                        <div class="reviews">
                            <div class="review">
                                <div class="review-title"><span class="summary">{{ $review->rating }} Stars</span><span class="date">
                                        <i class="fa fa-calendar"></i><span>{{$days}} days ago</span></span></div>
                                <div class="text">"{{$review->comment }}"</div>
                            </div>
                        </div><!-- /.reviews -->
                    </div><!-- /.product-reviews -->
                    @else
                    <div class="product-reviews">                       
                        <h4 class="title">No Customers Reviews Yet</h4> 
                    </div>
                    @endif

                    <form role="form" method="POST" action="{{url('/shop/review')}}" class="cnt-form">
                        <input type="hidden" name="product_id" value="{{$product->id}}"/>
                        <div class="product-add-review">
                            <h4 class="title">Write your own review</h4>
                            <div class="review-table">
                                <div class="table-responsive">
                                    <table class="table">	
                                        <thead>
                                            <tr>
                                                <th class="cell-label">&nbsp;</th>
                                                <th>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                </th>
                                                <th>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                </th>
                                                <th>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                </th>
                                                <th>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                </th>
                                                <th>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                    <img src="{{url('assets/images/star-on.png')}}"/>
                                                </th>
                                            </tr>
                                        </thead>	
                                        <tbody>
                                            <tr>
                                                <td class="cell-label">Quality</td>
                                                <td><input type="radio" name="quality" class="radio" value="1"></td>
                                                <td><input type="radio" name="quality" class="radio" value="2"></td>
                                                <td><input type="radio" name="quality" class="radio" value="3"></td>
                                                <td><input type="radio" name="quality" class="radio" value="4"></td>
                                                <td><input type="radio" name="quality" class="radio" value="5"></td>
                                            </tr>
                                            <tr>
                                                <td class="cell-label">Price</td>
                                                <td><input type="radio" name="price" class="radio" value="1"></td>
                                                <td><input type="radio" name="price" class="radio" value="2"></td>
                                                <td><input type="radio" name="price" class="radio" value="3"></td>
                                                <td><input type="radio" name="price" class="radio" value="4"></td>
                                                <td><input type="radio" name="price" class="radio" value="5"></td>
                                            </tr>
                                            <tr>
                                                <td class="cell-label">Value</td>
                                                <td><input type="radio" name="value" class="radio" value="1"></td>
                                                <td><input type="radio" name="value" class="radio" value="2"></td>
                                                <td><input type="radio" name="value" class="radio" value="3"></td>
                                                <td><input type="radio" name="value" class="radio" value="4"></td>
                                                <td><input type="radio" name="value" class="radio" value="5"></td>
                                            </tr>
                                        </tbody>
                                    </table><!-- /.table .table-bordered -->
                                </div><!-- /.table-responsive -->
                            </div><!-- /.review-table -->

                            <div class="review-form">
                                <div class="form-container">                               

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="name">Your Name <span class="astk">*</span></label>
                                                    <input type="text" class="form-control txt" id="name" name="name" placeholder="">
                                                </div><!-- /.form-group -->
                                                <div class="form-group">
                                                    <label for="summary">Summary <span class="astk">*</span></label>
                                                    <input type="text" class="form-control txt" id="summary" name="summary" placeholder="">
                                                </div><!-- /.form-group -->
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="review">Review <span class="astk"></span></label>
                                                    <textarea class="form-control txt txt-review" id="review" name="review" rows="4" placeholder=""></textarea>
                                                </div><!-- /.form-group -->
                                            </div>
                                        </div><!-- /.row -->

                                        <div class="action text-right">
                                            <button class="btn btn-primary btn-upper">SUBMIT REVIEW</button>
                                        </div><!-- /.action -->

                                </div><!-- /.form-container -->
                            </div><!-- /.review-form -->                      
                        </div><!-- /.product-add-review -->	
                    </form><!-- /.cnt-form -->

                </div><!-- /.product-tab -->
            </div><!-- /.tab-pane -->


        </div><!-- /.tab-content -->
    </div><!-- /.col -->
</div><!-- /.row -->