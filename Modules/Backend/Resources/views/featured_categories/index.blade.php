    @extends('backend::layouts.master')

    @section('content')

    <script type="text/javascript">
    
      $(document).ready(function(){

        $('#category_id').select2();
        $('#main_category').select2();

      });
   </script>

    <div class="page-breadcrumb" >
       {{ Breadcrumbs::render() }}

    </div>

    <div class="page-title">
        <div class="container">
            <h3>Featured Categories</h3>
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
                              <a href="{{ url('/backend/featured-categories/create') }}" class="btn btn-success btn-sm" title="Add New">
                              <i class="fa fa-plus" aria-hidden="true"></i> New Featured Category
                              </a> 
                            </span>
                          </div>

                        </div>

                         
                        <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Parent  Category</th>
                            <th>Actions</th></tr>
                            </thead>
                            <tbody>
                                @foreach($featured_categories as $item)
                        <tr>
                            <td>{{ $loop->iteration or $item->id }}</td>
                           

                            <td>{{ $item->category->name }}</td>
                            <?php $ancestor = App\Category::find($item->main_category) ?>
                            <td>{{ ($ancestor != null)?$ancestor->name:""  }} </td>
                            <td>
                                      
    <a href="{{ url('/backend/featured-categories/' . $item->id . '/edit') }}" title="Edit Category"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

    <form method="POST" action="{{ url('/backend/featured-categories' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger btn-sm" title="Delete Featured Category" onclick="return confirm(&quot;Confirm Delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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