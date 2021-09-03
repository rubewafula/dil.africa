     <?php  $user= App\User::find(Auth::user()->id); ?>
      <li class="dropdown">
                                    <!-- <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-success pull-right">
                                        {{count($user->notifications)}}

                                    </span></a> -->
                                    <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                                        <li><p class="drop-title">You have                                         {{count($user->notifications)}}
 notifications !</p></li>
                                        <li class="dropdown-menu-list slimscroll tasks">
                                            <ul class="list-unstyled">

                                                @foreach ($user->notifications as $notification) 
 <li>
                                                    <a href="#">
                                                        <div class="task-icon badge badge-success"><i class="icon-user"></i></div>
                                                        <span class="badge badge-roundless badge-default pull-right">{{$notification->created_at->DiffForHumans()}}</span>
                                                        <p class="task-details">
                                                        {{$notification->type}}</p>
                                                    </a>
                                                </li>

                                                @endforeach

                                               
                                              
                                            </ul>
                                        </li>
                                       <!-- <li class="drop-all"><a href="#" class="text-center">All Tasks</a></li>-->
                                    </ul>
                                </li>