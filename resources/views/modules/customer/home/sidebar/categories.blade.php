@php( $categories = \Modules\Customer\Utilities\Utilities::getMainCategoriesAll() )
@php($subCount = 0) 

<nav class="yamm megamenu-horizontal" role="navigation">
    <ul class="nav">
        @foreach($categories as $category)
        @if($category->getNoOfProducts() < 3)
        @continue;
        @endif
        @php($subCount = 0) 
        <li class="dropdown menu-item">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon fa {{$category->icon}}" aria-hidden="true"></i>
                {{ (strlen($category->name) > 20)?substr(strtoupper($category->name),0, 20).'..':strtoupper($category->name) }}
            </a>
            <ul class="dropdown-menu mega-menu">
                <li class="yamm-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <ul class="links list-unstyled">
                                
                                @php($subCategories = $category->getSubCategories())
                                
                                @foreach($subCategories as $subCategory)
                                @if($subCategory->getNoOfProducts() < 3)
                                @continue;
                                @endif
                                    @php($subCount++)
                                    @if($subCount == 8)
                                            </ul>
                                            </div><!-- /.col -->
                                            <div class="col-sm-12 col-md-3">
                                            <ul class="links list-unstyled">
                                            @php($subCount=0)
                                        @endif
                                    <h2 class="title">
                                        <a href="{{url('/shop/category/'.$subCategory->slug)}}" style="padding:10px 0px 0px 0px;font-weight: normal;">{{strtoupper($subCategory->name)}}</a>
                                    </h2>

                                    @php($miniCategories = $subCategory->getSubCategories())
                                    
                                    @foreach($miniCategories as $miniCategory)
                                        @if($miniCategory->getNoOfProducts() < 3)
                                        @continue;
                                        @endif
                                        <li style="padding-left: 7px;">                                        
                                            <a href="{{url('/shop/category/'.$miniCategory->slug)}}">{{ucwords($miniCategory->name)}}</a>
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
                        
                        <!-- <div class="dropdown-banner-holder">
                            <a href="#"><img alt="" src="{{url('assets/images/banners/categories/'.$category->cover_photo)}}" /></a>
                        </div> -->
                    </div><!-- /.row -->
                </li><!-- /.yamm-content -->                    
            </ul><!-- /.dropdown-menu -->            
        </li><!-- /.menu-item -->
        
        @endforeach

    </ul><!-- /.nav -->
</nav><!-- /.megamenu-horizontal -->
