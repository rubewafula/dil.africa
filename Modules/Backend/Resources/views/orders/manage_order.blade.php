    @extends('backend::layouts.master')
    @section('content')

    <div class="page-breadcrumb" >
        {{ Breadcrumbs::render() }}

    </div>
    <div class="page-title">
        <div class="container">
            <h3> Manage Order  &nbsp;&nbsp;&nbsp;&nbsp; Ref #{{$order->order_reference}}  <span class="pull-right">

               Status :   @if($order->order_status !== NULL)
               {{$order->order_status}}
               @else
               NEW
               @endif
           </span> </h3>
       </div>
   </div>
   <div id="main-wrapper" class="container" >
    <div class="row">
        <div class="col-md-12">
          <div class="panel-heading clearfix"> Header</div>

          <div class="panel panel-white">
           <div class="panel-body">


           </div>
       </div>

   </div>
</div>
</div>

@endsection