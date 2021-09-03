      @extends('seller::layouts.master')

      <script type="text/javascript">
                
        $(document).ready(function(){
   
         $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');

         $('#category_id').select2();
         $('#brand_id').select2();

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
         // alert("submit");

        var datastring = $("#update_features").serialize();
        $.ajax({
            type: "POST",
            url: "{{url('seller/  ')}}",
            data: datastring,
           // dataType: "json",
            success: function(data) {

            },
            error: function() {
                alert('error handing here');
            }
          });

        });


        $("#addfeature").submit(function(e){

          e.PreventDefault();

          alert("fdf");


        });

      $('.start_date').datepicker({
        format: 'yyyy-mm-dd'
      
      });
              $('.end_date').datepicker({
              format: 'yyyy-mm-dd'
      });

              function  check_offer_price()
              {
                var  offer_price= $("#offer_price").val();

               var  standard_price= $("#standard_price").val();

                if(offer_price >= standard_price)
               {
                $(".error-show").text(" The offer price should  be  less  than your price");
       
              } else{

                  $(".error-show").empty();
              }

              }

              $(document).on('keyup','#offer_price',function(){

                  check_offer_price();     
              });
              
                $("#offer_price").keyup(function(){
         
                check_offer_price();
              });
                 $("#offer_price").keydown(function(){
         
                check_offer_price();
                 });
              
                $("#offer_price").keydown(function(){
         
                check_offer_price();
              });

        });

    </script>
      @section('content')

                 <div class="page-breadcrumb" >
                          {{ Breadcrumbs::render() }}

                      </div>
                      <div class="page-title">
                          <div class="container">
                              <h3>  Products </h3>
                          </div>
                      </div>
                      <div class="panel panel-white">

                        <div id="main-wrapper">

                          <div class="row">
                              
                              <div class="col-md-12">

                                  <a href="{{url('seller/product/classify')}}" class="btn btn-primary blue-button" style="margin: 0px 0px 10px 10px;"> Add a Product </a>
                                  

                                      <table class="table table-bordered">
        <thead class="thead-dark" style="background-color:#f5f5f5;color:#888;">
          <tr>
            <th> Product  Code</th>
            <th> Name </th>
            <th> Category</th>
            <th> Status</th>
            <th> Brand</th>
            <th> Actions</th>

           </tr>
        </thead>
        <tbody>
        	   <form method="GET" action="{{ url('seller/products')}}" >
                  <input type="hidden" name="search"  value="1">
                  <tr>
                    <td>
                      <input type="text" name="product_code" >
                    </td>
                       
                        <td>
                      <input type="text" name="name">

                    </td>
                    <td></td>
                       <td>
                       	<select  name="publish_status" class="form-control">
                       		<option value=""> Select</option>
                       		<option value="0">DRAFT</option>
                       		<option value="1">PUBLISHED</option>
                       		<option  value="2">SUSPENDED</option>
                       		<option  value="3">UNPUBLISHED</option>
                 
                      </select>
                    </td>
                    <td>
                    	
                    </td>
                    <td>
                      
                      <input type="submit" class="btn-success orange-button"  value="Filter">
                      </form>
                      <a href="{{url('seller/products')}}">
                        <input type="submit" class="btn-success blue-button"  value="Refresh">
                      </a>
                    </td>

                  </tr>
                                               
      @if(count($products) > 0)
      @foreach($products  as $product)
      <tr style="border-top: 1px solid #eee;">
      	<td>{{$product->product_code}}</td>
          <td style="max-width:400px;">{{$product->name}}</td>
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
          <a href="{{ url('seller/product/'.$product->slug)}}" class="btn-warning btn-sm">Manage</a>

          <a style="margin-right: -14px;" href="{{ url('seller/delete_product/'.$product->id)}}" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  delete ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>

           </td>

      </tr>


      @endforeach

      @else
      <tr>
        <td  colspan="6"> You have  not added any  products</td>

      </tr>
      @endif

        </tbody>
      </table>
                              </div>
      </div>

                          </div>

                      	
                      </div>

        @endsection              