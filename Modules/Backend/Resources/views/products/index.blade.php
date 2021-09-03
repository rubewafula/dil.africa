  @extends('backend::layouts.master')
  @section('content')

  <div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

  </div>
  <div class="page-title">
    <div class="container">
      <h3> Products  </h3>
    </div>
  </div>
  <div id="main-wrapper" class="container" >
    <div class="row">
      <div class="col-md-12">
        <div class="panel-heading clearfix"> Total products :  </div>

        <div class="panel panel-white">
          <div class="panel-body">
           <div  class="row">
            <div class="col-md-12">
             


              <table class="table table-bordered">
                <thead class="thead-dark" style="background-color:#FFA200;color:#fff">
                  <tr>
                    <th> Product Code </th>
                    <th> Product </th>
                    <th> Seller</th>
                    <th> Status</th>
                    <th> Qty Sold </th>
                    <th> Qty Remaining </th>
                    <th> Actions</th>
                  </tr>
                </thead>
                <tbody>

                  <form method="GET"  action="{{url('backend/products')}}">
                    <input type="hidden" name="search"  value="1">
                    <td>
                      <input type="text" name="product_code">

                    </td>
                    <td> 
                     <input type="text" name="product">
                   </td>
                   <td></td>
                   <td> 
                    <select name="publish_status" class="form-control" >
                      <option  value="-1">Select</option>
                      <option  value="1">PUBLISHED</option>
                      <option  value="2">SUSPENDED</option>
                      <option  value="3">UNPUBLISHED</option>
                      
                    </select>
                  </td>
                  <td></td>

                  <td></td>
                  
                  <td>
                   <input  type="submit"  class="btn-warning" value="Filter">

                 </td>


               </form>


               @foreach($products  as $product)

               <tr>
                <td>{{$product->product_code}}</td>
                <td>  
                 {{$product->name}}
               </td>
               <td>
                @if(App\Seller::where('id',$product->seller_id)->exists())
                {{ $product->seller->name}}
                @endif
              </td>

              <td>

               {{$product->status}}
             </td>
             <td>

              {{count($product->order_details)}}
            </td>
            <td>
             
             {{$product->prices->sum('quantity')}}
           </td>
           <td> 
            <a  href="{{url('backend/product/'.$product->slug)}}" class="btn  btn-primary"> Manage </a> 

          </td>

        </tr>


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