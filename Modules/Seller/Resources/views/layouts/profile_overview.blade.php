<?php $user=  App\User::find(Auth::user()->id) ?>
<li class="dropdown">
        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
            <span class="user-name">{{Auth::user()->first_name}}<i class="fa fa-angle-down"></i></span>
        @if($user->seller_id > 0 && !empty($user->seller->logo))
<img class="img-circle avatar" src="{{url($user->seller->logo)}}" width="50" height="30" alt="">
@endif

</a>
<ul class="dropdown-menu dropdown-list" role="menu">
    <li role="presentation"><a href="{{url('seller/profile')}}"><i class="fa fa-user"></i>Profile</a></li>
   

    <li role="presentation"><a href="{{url('logout')}}"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
</ul>
</li>