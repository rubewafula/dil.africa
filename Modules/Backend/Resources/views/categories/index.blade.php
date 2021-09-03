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
            <h3>Categories</h3>
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
                         <div  class="col-md-4 col-sm-12">
                            <span  class="pull-right"> 
                              <a href="{{ url('/backend/categories/create') }}" class="btn btn-success btn-sm" title="Add New ">
                              <i class="fa fa-plus" aria-hidden="true"></i> New  Category
                              </a> 
                            </span>
                          </div>

                        </div>

                         
                        <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                <tr>
                                   <tr>
                            <th>#</th><th>Name</th><th>Level</th><th> Parent Category</th><th> Commission (%)</th> <th> Level Two category </th> <th>Actions</th>
                        </tr>
                                </tr>
                            </thead>
                            <tfoot style="background: #000;color:#fff;opacity: 0.7">
                               <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Parent  Category</th>
                            <th>Commission (%)</th>
                            <th>Level Two category </th>
                            <th>Actions</th>
                        </tr>
                            </tfoot>
                            <tbody>
                                @foreach($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration or $item->id }}</td>
                           

                            <td>{{ $item->name }}</td>
                            <td> 


                               {{ $item->level }}

                          </td>

                          <td>
                            @if(App\Category::where('id',$item->depends_on)->exists())

                            <?php
                             $cat= App\Category::find($item->depends_on); 
                             echo $cat->name;
                             ?>

                            
                            @endif


                          </td>
                          <td>{{$item->percent_commission}} </td>
                          <td>
                            {{$item->level_two($item->level_two_category)}}

                          </td>
                            <td>
                             @if($item->level  == 2)
                              <a     class="btn btn-success" data-toggle="modal" data-target="#modal_{{$item->id}}">
                                     Sizes </a>
                             <div class="modal fade" id="modal_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"> Sizes Configuration</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                                <div  class="row">
                                <form  class="form-horizontal" method="POST" action="{{url('backend/add_category_sizes')}}">
                                {{csrf_field()}}
                                <input  type="hidden" name="category_id" value="{{$item->id}}">
                                <input type="text" name="size" class="form-control">
                                <input type="submit" value="Add" class="btn btn-warning" >

                                </form>
                        </div>

  <div  class="row">

  <div  class="table">
  <table class="table">
  <thead>
    <tr>
      <th>
        Size
      </th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($item->sizes as  $size)
    <tr>
      <td> {{$size->size}} </td>
      <td>  <a  href="{{url('backend/remove_category_size/'.$size->id)}}" onclick="return  confirm('Are  you sure?')" class="btn btn-danger"> Delete</a></td>
    </tr>

    @endforeach
  </tbody>


  </table>
  </div>
  </div>

  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary">Save changes</button>
  </div>
  </div>
  </div>
  </div>
    @endif            
    <a href="{{ url('/backend/categories/' . $item->id . '/edit') }}" title="Edit Category"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

    <form method="POST" action="{{ url('/backend/categories' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger btn-sm" title="Delete Category" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
  <p class="no-s"><?php echo date('Y') ?>&copy; </p>
  </div>
  </div>
  @endsection