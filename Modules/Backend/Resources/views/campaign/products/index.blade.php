  @extends('backend::layouts.master')

  @section('content')

  <script type="text/javascript">
    
    $(document).ready(function(){

        var BASE_URL = "{{url('/backend/')}}";


        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $("#product_code").focusout( function(){

            var product_code = $("#product_code").val();

            if(product_code.length > 0){

                var filedata = new FormData();
        
                filedata.append('product_code', product_code);
                $.ajax({
                    url: BASE_URL + "/load-product-name",
                    data: filedata,
                    cache: false,
                    processData: false, // Don't process the files
                    contentType: false,
                    type: 'post',
                    success: function (output) {

                        if (output.status == '1') {                   
                            
                            $("#product_name").val(output.product_name);   
                            $("#price_before").val(output.price_before);                
                        }else {
                            $("#product_name").val("Invalid Product");
                        }
                    }
                });
            }
        });
    });
  </script>

        <div class="page-breadcrumb" >
           {{ Breadcrumbs::render() }}

        </div>

        <div class="container">
          <div class="row">

            <div class="col-md-12">
                <div class="card">
      
                    <div class="card-body">

                        <a href="{{ url('/backend/campaign') }}" title="Back">
                          <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Campaign Name</th><td> {{ $campaign->name }} </td></tr>
                                    <tr><th> Active From </th><td> {{ $campaign->active_from }} </td></tr>
                                    <tr><th> Active To </th><td> {{ $campaign->active_to }} </td></tr>
                                    <tr><th> Category </th><td> {{ ($campaign->category_id != null)?$campaign->category->name:"" }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                         <h4 class="panel-title"></h4> 
                    </div>
                    <div class="panel-body">

                        
                       <div class="table-responsive">

                          <div  class="row">

                            <div  class="col-md-6 col-sm-6">
                              
                              <div class="page-title">
                                  <div class="blue-text" style="font-size: 18px;">
                                      Add / Remove Products to <span style="color: #0F7DC2;">{{ $campaign->name }} </span>
                                  </div>
                              </div>
                            </div>
                            <div  class="col-md-6 col-sm-6">
                              
                              <button class="btn btn-sm btn-success" style="float:right;background: #0F7DC2;" data-toggle="modal" data-target="#add_products_button">Add Product</button>
                            </div>

                            <div id="add_products_button" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Add Products to Campaign </h4>
                                </div>
                                <div class="modal-body">
                                  <form method="POST" action="{{url('backend/campaign/products/add-to-campaign')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="campaign_id"  value="{{$campaign->id}}">
                                    
                                    <div  class="form-group">
                                      <label> Product SKU </label>
                                      <input type="text" name="product_code"  id="product_code" class="form-control" />

                                    </div>

                                    <div  class="form-group">
                                      <label> Product Name </label>
                                      <input type="text" name="product_name"  id="product_name" class="form-control" disabled="disabled" />

                                    </div>

                                    <div  class="form-group">
                                      <label> Standard Price </label>
                                      <input type="text" name="price_before"  id="price_before" class="form-control" />
                                    </div>

                                    <div  class="form-group">
                                      <label> Discount </label>
                                      <input type="text" name="discount"  id="discount" class="form-control" />
                                    </div>

                                    <div  class="form-group">
                                      <label> Offer Price </label>
                                      <input type="text" name="offer_price"  id="offer_price" class="form-control" />
                                    </div>

                                    <div  class="form-group">
                                      <label> Initial Stock </label>
                                      <input type="text" name="initial_stock"  id="initial_stock" class="form-control" />
                                    </div>

                                    <div  class="form-group pull-right">
                                      <input type="submit" class="btn  btn-success"  value="Save">

                                    </div>

                                  </form>
                                </div>
                                <div class="modal-footer">
                          <!--         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           -->      </div>
                              </div>

                            </div>
                          </div>

                          </div>
                        <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                <tr>
                                  <th>Product Name</th>  
                                  <th>Discount</th> 
                                  <th>Standard Price</th>
                                  <th>Offer Price</th>
                                  <th>Initial Stock</th>
                                  <th>Remaining Stock</th>
                                  <th>Status</th>   
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($campaign_products as $item)
                            <tr>
                              <td>{{ ucwords( $item->product->name) }}</td>
                              <td>{{ $item->discount }}</td>
                              <td>{{ $item->price_before }} </td>
                              <td>
                                {{ $item->offer_price }} 
                              </td>
                              <td>{{ $item->initial_stock }} </td>
                              <td>{{ $item->remaining_stock }} </td>
                              <td>{{ ($item->status == 1)?"Active":"Inactive" }}</td>
                              <td> 

                                  <form method="POST" action="{{ url('/backend/campaign/products/remove-from-campaign/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                      {{ csrf_field() }}
                                      <button type="submit" class="btn btn-danger btn-sm" title="Remove from this Campaign" onclick="return confirm(&quot;Are you sure you want to remove this product from this campaign?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i>  Remove from Campaign </button>
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
            <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA</p>
        </div>
    </div>
         
   @endsection