 <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?php echo e(Auth::user()->first_name); ?><i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="//www.gravatar.com/avatar/<?php echo e(md5(Auth::user()->email)); ?> ?s=64" width="30" height="30" alt="">
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="<?php echo e(url('backend/profile')); ?>"><i class="fa fa-user"></i>Profile</a></li>
                                      <!--  <li role="presentation"><a href="calendar.html"><i class="fa fa-calendar"></i>Calendar</a></li>
                                        <li role="presentation"><a href="inbox.html"><i class="fa fa-envelope"></i>Inbox<span class="badge badge-success pull-right">4</span></a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a></li>-->
                                        <li role="presentation"><a href="<?php echo e(url('logout')); ?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>

                                    </ul>
                                </li>