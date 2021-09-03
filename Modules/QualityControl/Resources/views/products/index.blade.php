  @extends('qc::layouts.master')
  @section('content')

  <script type="text/javascript">
              
      $(document).ready(function(){
       
       $('#category_id').select2();
       $('#brand_id').select2();

       $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');

       $('textarea').ckeditor();

        $("#collate").click(function(){

          var  attribute=  $("#attribute").val();
          var  desc = $("#desc").val();

          if(attribute =='' && desc =='')
          {

           alert("Please ensure you have added attribute and description");

          } else{

            attribute= '<solid>'+ attribute +'</solid>';

          var  trait= attribute + desc;
          var highlights=  $("#highlight").html();

           highlights = highlights + trait;

           $("#highlight").val(highlights);

          }
      });

      $("#update_features").submit(function(e){
        e.preventDefault();

      var datastring = $("#update_features").serialize();
      $.ajax({
          type: "POST",
          url: "{{url('qc/update_product_features')}}",
          data: datastring,

          success: function(data) {

          },
          error: function() {
              alert('error handing here');
          }
      });


      });

      });

  </script>

<div class="page-breadcrumb" >
  {{ Breadcrumbs::render() }}

</div>
<div class="page-title">
  <div class="container">

    <div class="col-md-3">
      <span class="blue-fg">Total Products Pending Review: </span> 
      {{$total_pending_review}}
    </div>
    <div class="col-md-2">
      <span class="blue-fg">Total Reviewed Today: </span>
      {{$total_reviewed_today}}
    </div>
    <div class="col-md-2">
      <span class="blue-fg">Total Reviewed Yesterday: </span>
      {{$total_reviewed_yesterday}}
    </div>
    <div class="col-md-2">
      <span class="blue-fg">Total Approved Today: </span>
      {{$total_approved_today}}
    </div>
    <div class="col-md-2">
      <span class="blue-fg">Total Rejected Today: </span>
      {{$total_rejected_today}}
    </div>
  </div>
</div>
<div class="panel panel-white">

<div id="main-wrapper">

  <div class="row">
      
      <div class="col-md-12">

  <table class="table table-bordered">
    <thead class="thead-dark" style="background-color:#f5f5f5;color:#888;">
      <tr>
        <th> Product  Code</th>
        <th> Name </th>
        <th> Category</th>
        <th> Brand</th>
        <th> Submitted By</th>
        <th> Actions</th>

       </tr>
    </thead>
    <tbody>
    	   <form method="GET" action="{{ url('qc/products')}}" >
            <input type="hidden" name="search"  value="1">
            <tr>
              <td>
                <input type="text" name="product_code" />
              </td>
                 
                  <td>
              <input type="text" name="name"/>
              </td>
              <td>
              </td>
              <td>
              	
              </td>
              <td>
                
              </td>
              <td>
                
                <input type="submit" class="btn-success orange-button"  value="Filter">
                </form>
                <a href="{{url('qc/products')}}">
                  <input type="submit" class="btn-success blue-button"  value="Refresh">
                </a>
              </td>

            </tr>
                                           
  @if(count($products) > 0)
  @foreach($products  as $product)
  <tr style="border-top: 1px solid #eee;">
  	<td>{{$product->product_code}}</td>
      <td style="max-width:300px;">{{$product->name}}</td>
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
        @php( $seller = App\Seller::findorfail($user->seller_id))
        @php( $name = "<span style='color: #0f7dc2;'>" .ucwords($user->first_name." ".$user->last_name)." </span> - ".ucwords($seller->name))
          {!! $name !!} 
          @endif
       </td>

      <td>
        <a href="{{ url('qc/product/'.$product->slug)}}" class="btn-warning btn-sm">Raw View</a>
        <a href="{{ url('qc/customer-view/'.$product->slug)}}" target="_blank" class="btn-success btn-sm">Customer View</a>
        <!-- <a style="margin-right: -14px;" href="{{ url('qc/delete_product/'.$product->id)}}" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete this product?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> -->
      </td>

  </tr>


  @endforeach

  @else
  <tr>
    <td  colspan="6"> No products require quality review</td>

  </tr>
  @endif

    </tbody>
  </table>
   </div>
  </div>

  </div>


</div>

@endsection              