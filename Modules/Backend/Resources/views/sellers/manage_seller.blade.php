  @extends('backend::layouts.master')
  @section('content')

  <div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

  </div>
  <div class="page-title">
    <div class="container">
      <h3>  Manage : {{$seller->name}} </h3>
    </div>
  </div>
  <div id="main-wrapper" class="container" >
    <div class="row">
      <div class="col-md-12">

        <div class="panel panel-white">
          <div class="panel-body">


            <div role="tabpanel">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class=" active"><a href="#seller" role="tab" data-toggle="tab" > Seller details</a></li>
                <li role="presentation"><a href="#users" role="tab" data-toggle="tab">Users  </a></li>
                <li role="presentation"><a href="#products" role="tab" data-toggle="tab">Products </a></li>

                <li role="presentation"><a href="#orders" role="tab" data-toggle="tab">Orders</a></li>

              </ul>
            </div>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="seller">

               <!--   <form method="POST" action="{{ url('/backend/sellers/' . $seller->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"> -->

                {!! Form::model($seller, [
                  'method' => 'PATCH',
                  'url' => ['/backend/sellers', $seller->id],
                  'class' => 'form-horizontal',
                  'files' => true
                  ]) !!}


                  {{ method_field('PATCH') }}
                  {{ csrf_field() }}

                  @include ('backend::sellers.form', ['submitButtonText' => 'Update'])

                </form>

              </div>

              <div role="tabpanel" class="tab-pane" id="users"> 
                <div  class="col-md-4 col-sm-12">
                 <span  class="pull-left"> <a href="{{ url('backend/sellers/manage/'.$seller->id.'/new_user') }}" class="btn btn-success btn-sm" title="Add New " target="_BLANK">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a> </span>                                

              </div>

              <?php $users=  App\User::where('seller_id',$seller->id)->get(); ?>

              <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">

                  <tr>
                   <tr>
                    <th>#</th><th>First Name</th><th>Last Name</th><th>Email</th>
                    <th>Status</th>

                    <th>Actions</th>
                  </tr>
                </tr>
              </thead>

              <tbody>
                @if($users->count() >0 )
                @foreach($users as $item)
                <tr>
                  <td>{{ $loop->iteration or $item->id }}</td>
                  <td>{{ $item->first_name }}</td>
                  <td>{{ $item->last_name }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{$item->status}}</td>


                  <td>

                    <a href="{{ url('/backend/users/' . $item->id . '/edit') }}" target="_BLANK" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                    <form method="POST" action="{{ url('/backend/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach

                @else
                <tr>
                  <td colspan="4">  You have  not  added  any  users</td>
                </tr>

                @endif


              </tbody>
            </table>  


          </div>

          <div role="tabpanel" class="tab-pane" id="products"> 
            <div  class="row">  

             <div  class="col-md-12"> 

              <table class="table table-bordered">
                <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
                  <tr>
                    <th> Name </th>
                    <th> Category</th>
                    <th> Status</th>
                    <th> Brand</th>
                    <th> Actions</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($seller->products  as $product)
                  <tr>
                    <td>{{$product->name}}</td>
                    <td>  

                      @if(App\Category::where('id',$product->category_id)->exists())

                      {{$product->category->name}}

                      @endif

                    </td>
                    <td>
                      {{$product->status}} 

                    </td>
                    <td>
                     @if(App\Brand::where('id',$product->brand_id)->exists())

                     {{$product->brand->name}}

                     @endif
                   </td>

                   <td>

                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a  href="{{ url('backend/product/'.$product->slug)}}" class="btn-warning btn-sm">  
                     Manage <span class="glyphicon glyphicon-signal" aria-hidden="true"></span></a>
                     &nbsp;&nbsp;&nbsp;&nbsp;

                     <a  href="{{ url('backend/delete_product/'.$product->id)}}" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>

                   </td>

                 </tr>

                 @endforeach

               </tbody>
             </table>
           </div>

         </div>


       </div>

       <div role="tabpanel" class="tab-pane" id="orders"> 
        <h3>  Supplier  Orders</h3>
        <div  class="row">
          <div  class="col-md-12">

            <table class="table table-bordered">
              <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
                <tr>
                  <th> Order  reference </th>
                  <th> Date</th>
                  <th> Amount</th>
                  <th> Status</th>
                </tr>
              </thead>

              @if($seller->orders->count() > 0)

              @foreach($seller->orders  as $order)
              <tr>
                <td>{{$order->order_reference}}</td>
                <td>{{$order->order_date}}</td>
                <td> {{$order->order_detail->price}}</td>
                <td>
                  {{$order->order_status}}

                </td>

              </tr>
              @endforeach

              @else

              <tr>
                <td colspan="4"> No Orders</td>
              </tr>
              @endif
              <tbody>
              </tbody>
            </table>

          </div>

        </div>   

      </div>

    </div>
  </div>

</div>
</div>
</div>

@endsection