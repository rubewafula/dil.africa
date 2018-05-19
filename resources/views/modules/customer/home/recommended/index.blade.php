<div class="more-info-tab clearfix ">
    <h3 class="new-product-title pull-left">Recomended For You</h3>
    <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
        <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">Most Popular</a></li>
        <li><a data-transition-type="backSlide" href="#smartphone" data-toggle="tab">Best Of Phones</a></li>
        <li><a data-transition-type="backSlide" href="#laptop" data-toggle="tab">Top in Fashion</a></li>
        <li><a data-transition-type="backSlide" href="#topinfashion" data-toggle="tab">Top in Books</a></li>
    </ul><!-- /.nav-tabs -->
</div>

<div class="tab-content outer-top-xs">
    <div class="tab-pane in active" id="all">			
        @include('customer::home.recommended.popular')
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="smartphone">
        @include('customer::home.recommended.phones')
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="laptop">
        @include('customer::home.recommended.fashion')
    </div><!-- /.tab-pane -->

    <div class="tab-pane" id="topinfashion">
        @include('customer::home.recommended.books')
    </div><!-- /.tab-pane -->

</div><!-- /.tab-content -->