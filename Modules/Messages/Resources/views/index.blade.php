@extends('messages::layouts.message_master')

@section('content')
<!-- <div  class="row">
        <div class="col-md-6">
                                    <h2>Inbox</h2>
                                </div>
                                <div class="col-md-4">
                                    <form action="#" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control input-search" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </form>
                               </div>

</div> -->


             <div class="col-md-10">
                 <div  class="row">
        <div class="col-md-6">
                                    <h2>Inbox</h2>
                                </div>
                                <div class="col-md-4">
                                    <form action="#" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control input-search" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </form>
                               </div>

</div>
                            <div class="mailbox-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="1" class="hidden-xs">
                                            <span><input type="checkbox" class="check-mail-all"></span>
                                        </th>
                                        <th class="text-right" colspan="5">
                                          <!--   <span class="text-muted m-r-sm">Showing 20 of 346 </span> -->
                                         
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($threads  as $thread)

   <?php $class = $thread->isUnread(Auth::id()) ? 'unread' : 'read'; ?>

                                  <tr class="{{$class}}">
                                        <td class="hidden-xs">
                                            <span><input type="checkbox" class="checkbox-mail"></span>
                                        </td>
                                        <td class="hidden-xs">
                                            <i class="fa fa-star icon-state-warning"></i>
                                        </td>
                                        <td class="hidden-xs">
                                            {{ $thread->participantsString(Auth::id(),['first_name','last_name']) }}
                                        </td>
                                        <td>
                                            {{ $thread->subject }}
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            {{ $thread->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            
                    <a href="{{url('messages/'. $thread->id)}}" class="btn-default btn-sm">
                                                 
                                    View 
                                             </a>
                                        </td>
                                    </tr>  

                                    @endforeach
                          

                                    <!-- <tr class="unread">
                                        <td class="hidden-xs">
                                            <span><input type="checkbox" class="checkbox-mail"></span>
                                        </td>
                                        <td class="hidden-xs">
                                            <i class="fa fa-star icon-state-warning"></i>
                                        </td>
                                        <td class="hidden-xs">
                                            Google
                                        </td>
                                        <td>
                                            Nullam quis risus eget urna mollis ornare vel eu leo
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            21 march
                                        </td>
                                    </tr> -->
                                    
                                </tbody>
                            </table>
                            </div>
                        </div>
@stop
