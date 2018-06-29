@php( $categories = \Modules\Customer\Entities\Category::where('status', 1)
    ->where('level', 1)->get() )
@php($subCount = 0) 

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        @foreach($categories as $category)
        @php($subCount = 0) 
        <li class="dropdown menu-item">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon fa {{$category->icon}}" aria-hidden="true"></i>
                {{ strtoupper($category->name) }}
            </a>
            <ul class="dropdown-menu mega-menu">
                <li class="yamm-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <ul class="links list-unstyled">
                                
                                @php($subCategories = \Modules\Customer\Entities\Category::where('depends_on',
                                    $category->id)->where('status', 1)->get())
                                
                                @foreach($subCategories as $subCategory)
                                    @php($subCount++)
<!--                                    @if($subCount != 1)<br/>@endif-->
                                    <h2 class="title">
                                        <a href="{{url('/shop/category/'.$subCategory->id)}}" style="padding:0px;">{{$subCategory->name}}</a>
                                    </h2>

                                    @php($miniCategories = \Modules\Customer\Entities\Category::where('depends_on', 
                                        $subCategory->id)->where('status', 1)->get())
                                    @foreach($miniCategories as $miniCategory)
                                    
                                        <li>                                        
                                            <a href="{{url('/shop/category/'.$miniCategory->id)}}">{{$miniCategory->name}}</a>
                                        </li>
                                        @php($subCount++)
                                        @if($subCount == 8)
                                            </ul>
                                            </div><!-- /.col -->
                                            <div class="col-sm-12 col-md-3">
                                            <ul class="links list-unstyled">
                                            @php($subCount=0)
                                        @endif
                                    @endforeach
                                @endforeach
                            </ul>
                        </div><!-- /.col -->
                        
                        <div class="dropdown-banner-holder">
                            <a href="#"><img alt="" src="{{url('assets/images/banners/categories/'.$category->cover_photo)}}" /></a>
                        </div>
                    </div><!-- /.row -->
                </li><!-- /.yamm-content -->                    
            </ul><!-- /.dropdown-menu -->            
        </li><!-- /.menu-item -->
        
        @endforeach

    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->
