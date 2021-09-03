      @extends('backend::layouts.master')

      @section('content')
       <script type="text/javascript">
        $(document).ready(function(){

         $("#crud").DataTable();

         //alert("these");

         $("#subcat_panel").hide();
         $(".sub").hide();

         $("#subcategory").click(function(){
         $("#subcat_panel").toggle();

            load_categories();

         });

         $("#category_id").change(function(){

          var category_id=  $("#category_id").val();
          $(".sub").show();

          //load_subcategories(category_id);
          $("#cat_id").val(category_id);

         });


         function  load_categories()
         {
            $.ajax({
            	url:"{{url('backend/load_categories')}}",
            	type:"GET",
            	success:function(data){
                  $("#category_id").text();
            		$.each(data,function(index){

            		$("#category_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option');	
          		
                   
            		});
             
            	}

            });
         }

         function  load_subcategories(category_id)
         {
        
            $.ajax({
              url:"{{url('backend/load_subcategories')}}",
              type:"GET",
              data:{category_id:category_id},
              success:function(data){
                  $("#subcategory_id").text();
                $.each(data,function(index){

                $("#subcategory_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option');  
                
                });
              }
            });
         }
        });   
      </script>

      <div class="page-breadcrumb" >
         {{ Breadcrumbs::render() }}
      </div>

      <div class="page-title">
          <div class="container">
              <h3>Promotion Banners</h3>
          </div>
      </div>
      <div id="main-wrapper" class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="panel panel-white">
                      <div class="panel-heading clearfix">
                           <h4 class="panel-title"></h4> 
                      </div>
                      <div class="panel-body">

                         <div class="table-responsive">

                           <div  class="row">
                              <div  class="col-md-8 col-sm-12">
                                    
                              </div>
                            <div class="col-md-4 col-sm-12">
                              <span  class="pull-right"> 
                                <a href="{{ url('/backend/promotion-banners/create') }}" class="btn btn-success btn-sm" title="Add New ">
                                <i class="fa fa-plus" aria-hidden="true"></i> New Promotion Banner
                                </a> 
                              </span>
                            </div>

                          </div>
                           
                          <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                              <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                  <tr>
                                     <tr>
                              <th>Promotion Section</th><th>Active From</th><th>Active To</th><th> Image URL </th> <th> Category </th> <th> Product </th> <th>Actions</th>
                            </tr>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($promotion_banners as $item)
                          <tr>
                              <td>{{ ucwords(str_replace("_", " ", $item->promotion_section->name)) }}</td>
                              <td> 

                                 {{ $item->active_from }}

                            </td>
                             <td> 

                                 {{ $item->active_to }}

                            </td>

                             <td> 

                                <a href="{{url('/assets/images/banners/'.$item->url)}}" target="_blank"> Banner </a> 

                            </td>


                            <td>{{ ($item->category != null)?$item->category->name:""}} </td>

                            <td>{{ ($item->product != null)?$item->product->name:""}} </td>

                            <td>

      @if($item->status != 1)
        <a href="{{ url('/backend/promotion-banners/activate/' . $item->id) }}" title="Activate"><button class="btn btn-primary btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Activate </button></a>
      @else
      <a href="{{ url('/backend/promotion-banners/inactivate/' . $item->id ) }}" title="Inactivate"><button class="btn btn-primary btn-warning"><i class="fa fa-trash-o" aria-hidden="true"></i> Inactivate </button></a>
      @endif
                                        
      <a href="{{ url('/backend/promotion-banners/' . $item->id . '/edit') }}" title="Edit Promotion Banner"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

      <form method="POST" action="{{ url('/backend/promotion-banners' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
          {{ method_field('DELETE') }}
          {{ csrf_field() }}
          <button type="submit" class="btn btn-danger btn-sm" title="Delete Promotion Banner" onclick="return confirm(&quot;Confirm Delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
      </form>
    </td>

    </tr>
    @endforeach

    </tbody>
    </table>  
                           
    </div>
      </div>
    </div>

    </div>
    </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <div class="page-footer">
    <div class="container">
    <p class="no-s"><?php echo date('Y') ?>&copy; DIL.AFRICA</p>
    </div>
    </div>
    @endsection