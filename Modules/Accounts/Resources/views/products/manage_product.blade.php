@extends('accounts::layouts.master')
@section('content')

<script type="text/javascript">
    
    $(document).ready(function(){

      $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
      $('#category_id').select2();
      $('#brand_id').select2();

      $("#publish_button").removeAttr('disabled');

      $("#brands").keyup(function(){

          var  brand = $(this).val();

          $.ajax({
          url:"{{url('seller/load_brands')}}",
          type:"GET",
          data:{brand:brand},
          success:function(output){
   
          console.log(output);

          },
          error:function (){
            return "ERROR";
          }
      });

     });

    });
</script>
           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container" style="padding-top: 10px;">
                      <div class="col-md-6">
                        <h3 style="padding-bottom: 5px;">  
                          Update:  {{$product->name}}, Product  Code: {{$product->product_code}}
                        </h3>
                      </div>

                      <div class="col-md-3">
                        
                        <span style="font-size: 16px;">
                           STATUS: <span class="blue-color">{{$product->status}}</span>
                          </span>
                      </div>


                      <div class="col-md-3">
                        
                        <span class="pull-right">
                           <form  method="POST"  action="{{url('accounts/publish_product')}}">
                            {{csrf_field()}}
                        <input type="hidden"  name="product_id" value="{{$product->id}}">

                        <div  class="form-group" style="margin-bottom: 0px;">
                          
                        @if($product->publish_status ==  1)

                        <a  href="{{url('accounts/unpublish/'.$product->id)}}"  class="btn  btn-danger"> Unpublish</a>

                        @elseif($product->publish_status ==  4)

                        <a  href="#"  class="btn  btn-success"> Pending Approval </a>


                        @else

                        <!-- <button class="btn btn-warning btn-lg" id="publish_button"> Publish </button> -->
                        <input type="submit" class="btn btn-warning orange-button" value="Publish"/>

                        @endif
                      </div>
                    </form>

                          </span>
                       <br/>
                    

                      </div>
                    </div>
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

                                   @include('accounts::products.product_form',compact('product'))
                                </div> 
                              </div>

                    </div>



  @endsection              