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

        $('#expires_on').datepicker({
          format: 'yyyy-mm-dd'       
        });   

        $('#active_from').datepicker({
          format: 'yyyy-mm-dd'       
        });

        $('#expires_at').timepicker(); 

        $('#active_at').timepicker(); 

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

            <br/>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr><td> Flash Sale Products </td></tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <form method="POST" action="{{url('backend/flash-sale')}}">
        {{csrf_field()}}
        <div class="col-md-4">

          <div class="form-group">
            <label> Product SKU </label>
            <input type="text" name="product_code"  id="product_code" class="form-control" />

          </div>

          <div class="form-group">
            <label> Product Name </label>
            <input type="text" name="product_name"  id="product_name" class="form-control" disabled="disabled" />

          </div>

          <div class="form-group">
            <label> Standard Price </label>
            <input type="text" name="price_before"  id="price_before" class="form-control" />
          </div>

          <div class="form-group">
            <label> Discount </label>
            <input type="text" name="discount"  id="discount" class="form-control" required="required" />
          </div>
        </div>

        <div class="col-md-4">

        <div class="form-group">
          <label> Offer Price </label>
          <input type="text" name="offer_price"  id="offer_price" class="form-control" />
        </div>

        <div class="form-group">
          <label> Initial Stock </label>
          <input type="text" name="initial_stock"  id="initial_stock" class="form-control" />
        </div>

      <div class="form-group">
          <label> Active From </label>
          <input type="text" name="active_from"  id="active_from" class="form-control" />
        </div>

        <div class="form-group">
          <label> At (Time From) </label>
          <input type="text" name="active_at"  id="active_at" class="form-control" />
        </div>

      </div>

      <div class="col-md-4">

        <div  class="form-group">
          <label> Expires On </label>
          <input type="text" name="expires_on"  id="expires_on" class="form-control" />
        </div>

        <div class="form-group">
          <label> At (Time To) </label>
          <input type="text" name="expires_at"  id="expires_at" class="form-control" />
        </div>

        <div class="form-group">
          <label style="height: 37px;"></label>
          <input type="submit" class="btn  btn-success"  value="Save">
        </div>
      </div>

    </form>
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

            <div  class="col-md-12 col-sm-12">

              <div class="page-title">
                <div class="blue-text" style="font-size: 18px;text-align: center;">
                  Products in <span style="color: #0F7DC2;">Flash Sale </span>
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
              @foreach($products as $item)
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

                  <form method="POST" action="{{ url('/backend/flash-sale/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm" title="Remove from Flash Sale" onclick="return confirm(&quot;Are you sure you want to remove this product from flash sale?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i>  Remove from Flash Sale </button>
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