  @extends('backend::layouts.master')
  @section('content')

  <div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

  </div>
  <div class="page-title">
    <div class="container">
      <h3> Orders  </h3>
    </div>
  </div>
  <div id="main-wrapper" class="container" >
    <div class="row">
      <div class="col-md-12">
        <div class="panel-heading clearfix"> Realtime  Orders  </div>

        <div class="panel panel-white">
          <div class="panel-body">
           <div  class="row">
            <div class="col-md-12">

              <table class="table table-bordered">
                <thead class="thead-dark" style="background-color:#FFA200;color:#fff">
                  <tr>
                    <th> Order Ref </th>
                    <th> Customer</th>
                    <th> Phone Number</th>
                    <th> Amount</th>
                    <th> Order  Date </th>
                    <th> Status  </th>
                    <th> Actions</th>

                  </tr>
                </thead>
                <tbody>

                  <form method="GET"  action="{{url('backend/orders')}}">
                    <input type="hidden" name="search"  value="1">
                    <td>
                      <input type="text" name="order_reference">

                    </td>
                    <td> 
                     <input type="text" name="customer">
                   </td>
                   <td></td>
                   <td></td>
                   <td> 
                    <select name="order_status" class="form-control" >
                      <option  value="-1">Select</option>
                      <option  value="">NEW</option>
                      <option  value="DELIVERED">DELIVERED</option>
                      <option  value="DISPATCHED">DISPATCHED</option>
                      <option  value="READY">READY</option>
                      <option  value="REFUNDED">REFUNDED</option>
                    </select>
                  </td>
                  <td>
                   <input  type="submit"  class="btn-warning" value="Filter">

                 </td>


               </form>


               @foreach($orders  as $order)
               @if(count($order->order_details()->get()) > 0)
               <tr>
                <td>{{$order->order_reference}}</td>
                <td>  
                 @if(App\User::where('id',$order->user_id)->exists())
                 {{ ucwords($order->user->full_name) }} ({{$order->user->email}})
                 @endif
               </td>
               <td>{{ $order->user->phone }}</td>
               <td>{{ number_format($order->total_value)}}</td>

               <td>{{$order->created_at->format('d/m/Y H:i')}} ({{$order->created_at->DiffForHumans()}})</td>
               <td>

                @if($order->order_status !== NULL)

                {{$order->order_status}}
                @else
                NEW

                @endif
              </td>
              <td> 
                <a  href="{{url('backend/customer/order/'.$order->id)}}" class="btn  btn-primary"> Manage </a> 


              </td>

            </tr>

            @endif
            @endforeach


          </tbody>
        </table>

      </div>

    </div>

  </div>
</div>

</div>
</div>
</div>


@endsection