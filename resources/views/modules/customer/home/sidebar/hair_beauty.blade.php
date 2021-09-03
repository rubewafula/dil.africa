@php($featured_category = new \App\Featured_category())
@php($elec_categories = $featured_category->getFeaturedBeautyCategories())

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        @foreach($elec_categories as $category)
        <li style="padding-left: 7px;">                                        
            <a href="{{url('/shop/category/'.$category->category->slug)}}" style="color: #565656;">{{ucwords($category->category->name)}}</a>
        </li>
        @endforeach
    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->