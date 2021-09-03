  @extends('qc::layouts.master')
  @section('content')

             <div class="page-breadcrumb" >
                      {{ Breadcrumbs::render() }}

                  </div>
                  <div class="page-title">
                      <div class="container">
                          <h3>  Repository Product Listings Pending QC</h3>
                      </div>
                  </div>
                  <div class="panel panel-white">

                    <div id="main-wrapper">

                      <div class="row">
                          
                          <div class="col-md-12">

  <table class="table table-bordered">
    <thead class="thead-dark" style="background-color:#f5f5f5;color:#888;">
      <tr>
        <th> Product Code</th>
        <th> Name </th>
        <th> Category</th>
        <th> Brand</th>
        <th> Submitted By</th>
        <th> Actions </th>

       </tr>
    </thead>
    <tbody>
    	   <form method="GET" action="{{ url('qc/products')}}" >
            <input type="hidden" name="search"  value="1">
            <tr>
              <td>
                <input type="text" name="product_code" >
              </td>
                 
                  <td>
              <input type="text" name="name">

              </td>
                 <td>

                 	<!-- <select  name="publish_status" class="form-control">
                 		<option value=""> Select</option>
                 		<option value="0">DRAFT</option>
                 		<option value="1">PUBLISHED</option>
                 		<option  value="2">SUSPENDED</option>
                 		<option  value="3">UNPUBLISHED</option>
                    <option  value="4">SUBMITTED FOR QC</option>
                </select> -->
              </td>
              <td>
              	
              </td>
              <td>
                
              </td>
              <td>
                
                <input type="submit" class="btn-success orange-button"  value="Filter">
                </form>
                <a href="{{url('qc/rejected')}}">
                  <input type="submit" class="btn-success blue-button"  value="Refresh">
                </a>
              </td>

            </tr>
                                           
  @if(count($products) > 0)
  @foreach($products  as $product)
  <tr style="border-top: 1px solid #eee;">
  	<td>{{$product->product_code}}</td>
      <td style="max-width:250px;">{{$product->name}}</td>
      <td>  

      @if(App\Category::where('id',$product->category_id)->exists())

        {{$product->category->name}}

      @endif

       </td>
       <td>
           @if(App\Brand::where('id',$product->brand_id)->exists())

           {{$product->brand->name}}

           @endif
       </td>

       <td style="max-width:150px;">
        @php( $submitted_by = $product->submitted_by)

        @if($submitted_by != null)
        @php( $user = App\User::findorfail($submitted_by))
        @php( $name = "<span style='color: #0f7dc2;'>" .$user->first_name." ".$user->last_name." </span>")
          {!! $name !!} 
          @endif
       </td>

      <td>
        <a href="{{ url('qc/repo/product/'.$product->slug)}}" class="btn-warning btn-sm">Raw View</a>
        <a href="{{ url('qc/repository/customer-view/'.$product->slug)}}" target="_blank" class="btn-success btn-sm">Customer View</a>
      </td>

  </tr>


  @endforeach

  @else
  <tr>
    <td  colspan="6"> No pending products listings from the repository</td>

  </tr>
  @endif

    </tbody>
  </table>
   </div>
  </div>

  </div>


</div>

@endsection              