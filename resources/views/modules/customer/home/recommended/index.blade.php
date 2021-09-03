<div class="more-info-tab clearfix">
    <h3 class="new-product-title pull-left">Recomended For You</h3>
    <ul class="nav nav-tabs nav-tab-line pull-right hidden-xs hidden-sm" id="new-products-1">
        <li class="active"><a style="font-size: 15px;color: #ffa200;" data-transition-type="backSlide" href="#all" data-toggle="tab">Most Popular</a></li>
        @php($popular_categories = \Modules\Customer\Entities\Category::where('is_popular',1)->orderBy('id', 'DESC')->limit(3)->get())
        
        @foreach($popular_categories as $category)
        <li><a style="font-size: 15px;color: #ffa200;" data-transition-type="backSlide" href="#{{$category->id}}" data-toggle="tab">Top In {{$category->name}}</a></li>
        @endforeach
    </ul><!-- /.nav-tabs -->
</div>

<div class="tab-content outer-top-xs">
    <div class="tab-pane in active" id="all">			
        @include('customer::home.recommended.popular')
    </div><!-- /.tab-pane -->
    
    @foreach($popular_categories as $category)
    <div class="tab-pane  hidden-xs hidden-sm" id="{{$category->id}}">
        @include('customer::home.recommended.popular_category')
    </div><!-- /.tab-pane -->
    @endforeach

</div><!-- /.tab-content -->