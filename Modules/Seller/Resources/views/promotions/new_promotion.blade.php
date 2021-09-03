@extends('seller::layouts.master')
@section('content')

<script type="text/javascript">
    
    $(document).ready(function(){

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
                <!-- <div class="page-title">
                    <div class="container">
                        <h3>  New product </h3>
                    </div>
                </div> -->
                <div id="main-wrapper" class="container" >

                	<div  class="row">
                     
   <div class="col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading clearfix">
                                        <h3 class="panel-title">New  product</h3>
                                    </div>
                                    <?php  $product= new App\Product; ?>

                                   @include('seller::products.product_form',compact('product'))
                                </div> 
                              </div>

                    </div>

</div>
                </div>

  @endsection              