@extends('qc::layouts.master')
@section('content')

<script type="text/javascript">
    
    $(document).ready(function(){

      $('#category_id').select2();
      $('#brand_id').select2();

      $("#publish_button").removeAttr('disabled');

     $("#brands").keyup(function(){

        var  brand = $(this).val();

        $.ajax({
        url:"{{url('qc/load_brands')}}",
        type:"GET",
        data:{brand:brand},
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
                    <div class="container" style="padding-top: 10px;">
                      <div class="col-md-5">
                        <h3 style="padding-bottom: 5px;">  
                          Update:  {{$product->name}}, Product  Code: {{$product->product_code}}
                        </h3>
                      </div>

                      <div class="col-md-3">
                        
                        <span style="font-size: 16px;">
                           STATUS: <span class="blue-color">{{$product->status}}</span>
                          </span>
                      </div>
                      <div class="col-md-2">
                        
                        <span class="pull-right">
                           <form  method="POST"  action="{{url('qc/publish_product')}}">
                              {{csrf_field()}}
                              <input type="hidden"  name="product_id" value="{{$product->id}}">

                              <div  class="form-group" style="margin-bottom: 10px;">
                                
                              @if($product->publish_status ==  5)

                              <a  href="{{url('qc/rejected/undo/'.$product->id)}}"  class="btn  btn-warning"> Undo Rejection</a>

                              @else

                              <!-- <button class="btn btn-warning btn-lg" id="publish_button"> Publish </button> -->

                              <input type="submit" class="btn btn-warning orange-button" value="Publish"/>

                              @endif
                            </div>
                          </form>
                          </span>
                      </div>

                      @if($product->publish_status ==  4)
                      <div class="col-md-2">

                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reject{{$product->id}}">Reject</button>

                          <div id="reject{{$product->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Quality Review Failed </h4>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="{{url('qc/quality_failed')}}">
                                  {{csrf_field()}}
                                  <input type="hidden" name="product_id"  value="{{$product->id}}">

                                  <div  class="form-group">
                                    <label> Comments </label>
                                    <textarea name="quality_comments"  class="form-control" 
                                    ></textarea>

                                  </div>

                                  <div  class="form-group pull-right">
                                    <input type="submit" class="btn  btn-danger"  value="Save">

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
                    @endif
                </div>
                <div class="container" >
                  <div class="panel panel-white">

                	<div  class="row">
                     
                    <div class="col-md-12">
                      <div class="panel-heading clearfix">
                        <div class="row"> 

                          <div class="col-md-6">
                              <h3 class="panel-title"> Products
                              </h3>
                          </div>
                          <div class="col-md-6">
                             
                          </div>

                        </div>

                    </div>

                      </div>

                     @include('qc::products.product_form',compact('product'))
                  </div> 
                </div>

            </div>

          </div>
      </div>

  @endsection              