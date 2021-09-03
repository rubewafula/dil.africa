@extends('accounts::layouts.master')
@section('content')

<script type="text/javascript">
    
  $(document).ready(function(){


   $("#subcat").hide();
   $(".go").hide();



   $("#category_id").change(function(){

    var category_id = $("#category_id").val();
   $(".sub").empty();

    $(".sub").show();

   
    load_subs(category_id,0);
    
   });



  function  load_subs(category_id,level)

  {
    if(category_id === undefined)
    {

       var category_id=  $("#category_id").val();
    }

     $.ajax({
        url:"{{url('accounts/load_subcategories')}}",
        type:"GET",
        data:{category_id:category_id,level:level},
        success:function(data){
 
      // console.log(data['html']);

       $(".sub").append(data['html']);
                   
       $(".sub").show();

       //alert($(".sub").html());


           // console.log(data);
            //return;
          

      
        }


      });


  }

function check_child(category_id,level)
{
  
  $.ajax({
        url:"{{url('accounts/check_child')}}",
        type:"GET",
        data:{category_id:category_id},
        success:function(output){
         
         // return;
         //alert(output);
        // return;

          if(output.status == 'TRUE')
         {

          $(".go").hide();

          load_subs(category_id,level);

         } else{
        
         $("#named_category").val(category_id);
          $(".go").show();
         }

        },
        error:function (){
          return "ERROR";
        }
      });

}



$(document).on("change",".subcat",function(e){

//alert("sub  cat");
  e.preventDefault();
  var category_id = $(this).val();

  var level=  $(this).attr("level");

  var new_level= level;
   new_level++;
  var new_class= 'level_'+ new_level;
//  alert(new_class);
// return;
  $("."+ new_class).empty();
  check_child(category_id,level);

  // alert(check);

  // if(check_child(category_id) === 'TRUE')
  // {
  // //  alert('');
  //  // load_subs(category_id);


  // } else{



  // }




});




$(document).on("load",".subcat",function(){

  // alert("sub  cat");


});


  
 //   function  load_subcategories(category_id)
 //   {

 //    if(category_id === undefined)
 //    {

 //       var category_id=  $("#category_id").val();
 //    }

 //    $(".sub_select").change(function(){
 //     // alert("");
 //    //  return;
    

 //    alert(category_id);


 //    });
  

 // $.ajax({
 //        url:"{{url('seller/load_subcategories')}}",
 //        type:"GET",
 //        data:{category_id:category_id},
 //        success:function(data){

 //           // console.log(data);
 //            //return;
 //            $("#subcat").show();

 //            $("#subcategory_id").empty();


 //             if(data.length > 0)
 //             {
 //         $.each(data,function(index){

 //          if(data[index].child > 0)
 //          {
 //  $("#subcategory_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +' >  </option'); 

 //          } else{

 //         $("#subcategory_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option'); 

 //          }

         


                     
 //          });
     

 //             }else{
 //                  $("#subcategory_id").append('<option  value=""> There  are no  options  for this  category </option');  

 //             }

      
 //        }


 //      });
  

 //   }


  //  $("#subcategory_id").change(function(){
        
  //       var subcategory_id = $("#subcategory_id").val();

  //     $.ajax({
  //       url:"{{url('seller/load_subcategories')}}",
  //       type:"GET",
  //       data:{category_id:subcategory_id},
  //       success:function(data){

  //          // console.log(data);
  //           //return;
  //           $("#subcat").show();

  //           $("#subcategory_id").empty();


  //            if(data.length > 0)
  //            {
  //        $.each(data,function(index){

  //         if(data[index].child > 0)
  //         {
  // $("#subcategory_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +' >  </option'); 

  //         } else{

  //        $("#subcategory_id").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option'); 

  //         }

         


                     
  //         });
     

  //            }else{
  //                 $("#subcategory_id").append('<option  value=""> There  are no  options  for this  category </option');  

  //            }

      
  //       }


  //     });
 
  //       //var category_id=  $(this).attr("parent_id");



  //       // if(subcategory_id >  0)
  //       // {
  //       //     $(".go").show();

  //       // } else{

  //       //     $(".go").hide();


  //       // }


  //  });



  });   
   </script>
</script>

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <span style="font-size: 18px;color: #0f7dc2;"> New  productt </span>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-white">
                            	                                <div class="panel-body">
                         <p>Please  select  the  primary  category of  your  product</p>

                            <div id="subcat_panel">
                              <div class="row">
                                <div  class="col-md-4">
                                    <div class="form-group">
                                        <label> Select  category</label>

                                        <select  name="category_id" id="category_id"  class="form-control">
                                          <option value=""> Select</option>
                                    <?php $categories= App\Category::where('level',1)->get(); ?>
                                    @foreach($categories  as $category)

                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach




                                         </select>

                                    </div>

                                </div>  

              <form method="POST" id="subca"  action="{{ url('accounts/start_product')}}">
                                      {{csrf_field()}}

                                      <input type="hidden" name="seller_id" value="{{$seller_id}}">

    <div class="sub">
   
    </div>
<div   class="row">
      <div  class="col-md-4">
</div>
    <div  class="col-md-4"></div>

    <div  class="col-md-4">
      <input type="hidden" name="category" id="named_category"/>

         <div class="form-group go" style="margin-top:20px ">
    <input  type="submit"  class="btn btn-success btn-sm"  value="Begin">
</div> 
</div>
</div>                               
</form>

               </div>  


                              </div>

                              </div>



                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection