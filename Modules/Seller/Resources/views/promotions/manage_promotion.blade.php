@extends('seller::layouts.master')
@section('content')
<script src="{{url('assets/js/jquery-1.11.1.min.js')}}"></script>
<script type="text/javascript">
    
    $(document).ready(function(){

      $("#publish_button").removeAttr('disabled');

     $("#brands").keyup(function(){

        var  brand = $(this).val();

        $.ajax({
        url:"{{url('seller/load_brands')}}",
        type:"GET",
        data:{brand:categbrandory_id},
        success:function(output){
 
        console.log(output);

        },
        error:function (){
          return "ERROR";
        }
      });
      //alert("brand");

     });

    });
</script>

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                      <div class="col-md-6">
                        <h3>  Update:  {{$product->name}} 
                          <span class="pull-right">
                           STATUS: {{$product->status}}

                          </span>
                        </h3>
                        <p> Product  Code: {{$product->product_code}}</p>
                      </div>
                      <div class="col-md-6">
                        
                        <span class="pull-right">
                           <form  method="POST"  action="{{url('seller/publish_product')}}">
                            {{csrf_field()}}
                        <input type="hidden"  name="product_id" value="{{$product->id}}">

                        <div  class="form-group">
                          
                        @if($product->publish_status ==  1)

                        <a  href="{{url('seller/unpublish/'.$product->id)}}"  class="btn  btn-danger"> Unpublish</a>

                        @else

                        <!-- <button class="btn btn-warning btn-lg" id="publish_button"> Publish </button> -->

                        <input type="submit" class="btn btn-warning btn-lg" value="Publish"/>


                        @endif
                      </div>
                    </form>

                          </span>
                      </div>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                                <div class="panel panel-white">

                	<div  class="row">
                     
   <div class="col-md-12">
                                    <div class="panel-heading clearfix">
                                        <h3 class="panel-title">Products

                                        </h3>


                     </div>

                                    </div>

                                   @include('seller::products.product_form',compact('product'))
                                </div> 
                              </div>

                    </div>

</div>
                </div>

  @endsection              