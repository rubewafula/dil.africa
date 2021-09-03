          <script type="text/javascript">
              
      $(document).ready(function(){
       // load_features();
       $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');


       // $('#tabMenu a[href="#tab2"]').tab('show');

       $('textarea').ckeditor();

      $("#collate").click(function(){

          var  attribute=  $("#attribute").val();
          var  desc = $("#desc").val();

          if(attribute =='' && desc =='')
          {

           alert("Please   ensure you  have  added  attribute  and  description");

          } else{

            attribute= '<solid>'+ attribute +'</solid>';

          var  trait= attribute + desc;
          var highlights=  $("#highlight").html();

           highlights = highlights + trait;

           $("#highlight").val(highlights);

          }
      });

      $("#update_features").submit(function(e){
        e.preventDefault();
       // alert("submit");

       var datastring = $("#update_features").serialize();
      $.ajax({
          type: "POST",
          url: "{{url('qc/update_product_features')}}",
          data: datastring,
         // dataType: "json",
          success: function(data) {

        //    load_features();
          //  alert(data);
              //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
              // do what ever you want with the server response
          },
          error: function() {
              alert('error handing here');
          }
      });


      });

      });

  </script>

<div class="panel-body" style="padding: 15px;">
  <div role="tabpanel">
        <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="tabMenu">
              
            <li role="presentation"  class="active"  ><a href="#tab1" role="tab"   data-toggle="tab">Product  Information</a></li>
          @if($product->id > 0)
         <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">More  Product Details</a></li>
            <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Product  Variations (Prices)</a></li>
            <li role="presentation"><a href="#tab4" role="tab" data-toggle="tab">Images</a></li>

            @endif
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
                      

            <div role="tabpanel" class="tab-pane active "" id="tab1">
               <form  method="POST"  action="{{ url('qc/products/save')}}">
                {{csrf_field()}}

                <input  type="hidden" name="seller_id" value="{{ $product->seller_id}}">
                <input type="hidden" name="product_id"  value="{{$product->id}}">
                <input type="hidden" name="category_id" value="{{$category_id}}">
                <div class="row">
                    <div class="col-md-12">
                        <div  class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            <label> Product Name *</label>

     {{Form::text('name',$product->name,['class'=>'form-control'])}}
             {!! $errors->first('name', '<p class="help-block">:message</p>') !!}


                        </div>
                    </div>
                          
                </div>

                <div  class="row">
                  <div  class="col-md-12">
                        <div  class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                            <label> Product  Description </label>

{{Form::textarea('product_description',$product->product_description,['class'=>'form-control textarea',
     'id'=>'desc','rows'=>'20'])}}
             {!! $errors->first('product_description', '<p class="help-block">:message</p>') !!}

                    </div>

                  </div>

                </div>
                   <div class="row">
                                
                     <div class="col-md-6">
                       <div  class="form-group">
                              <label> Category</label>
                              <?php $categories = \App\Category::pluck('name', 'id'); ?>
                              @if(isset($type))
                              {{Form::select('category_id',$categories ,$category_id, ['class'=>'form-control required'])}} 
                              @else
                              {{Form::select('category_id',$categories ,$product->category_id, ['class'=>'form-control required'])}}                                                                        
                              @endif
                        </div>
                    </div>
                     <div class="col-md-6">
                       <div  class="form-group">
                            <label> Model</label>
                             {{Form::text('model',$product->model,['class'=>'form-control','id'=>'model'])}}
                        </div>
                    </div>
                  </div>
          
                  <div class="row">
                         
                    <div class="col-md-6">
                       <div  class="form-group">
                              <label> Tax  Class</label>
                              <?php $tax_classes=['0'=>'NoTax','16'=>'16 %']  ?>
                              {{Form::select('tax_class',$tax_classes,$product->tax_class,['class'=>'form-control required'])}}
                              
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div  class="form-group">
                            <label> Product  Warranty </label>

     {{Form::text('product_warranty',$product->product_warranty,['class'=>'form-control',
     'id'=>'brands'])}}

                        </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                            <input type="submit" class="btn btn-success blue-button" style="    margin-top: 23px;" value="Save">
                     </div>

                </div>

               </form>

               <div class="col-md-6">
                 
               </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="tab2">

              <div  class="row">
                <div  class="col-md-12">
<form  method="POST" id="update_featuress"  action="{{url('qc/update_product_features')}}">  
                    {{csrf_field()}}

                    <input type="hidden" id="" name="product_id" value="{{$product->id}}">
        @if($product->category_id > 0)
                     <div  class="form-group">
                       <label>  Select  Feature Type</label>

<?php


$feature_types= App\Feature_type::where('level_two_category',$product->category->level_two_category)->pluck('name','id')->prepend('General','0')->prepend('Pick  Feature','');
                   
?>
{{Form::select('feature_type_id',$feature_types,null,['class'=>'form-control','id'=>'feature_type_id'])}}
                     </div>

                     @endif

                        <div  class="form-group">
                       <label>Description</label>
                     
{{Form::text('value',null,['class'=>'form-control','id'=>'description'])}}
                     </div>
                         <div  class="form-group">
                     
                       <input type="submit" class="btn btn-primary"  value="Add Feature">
                     </div>

                </div>

              </div>

              <div  class="row">
                <div  class="col-md-12">
                  <table  class="table">
                    <thead class="orange-color" style="background: #eee;font-weight: bold;font-size: 14px;">
                      <tr>  
                        <td> Feature Type</td> 
                        <td> Description</td>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>
                      @if($product->features->count() > 0)
                      @foreach($product->features  as $feature)
                      <tr>
                        <td> {{($feature->feature_type != null)?$feature->feature_type->name:"General"}} 
                        </td>
                        <td>{{$feature->value}}</td>
                        <td> <a  href="{{url('qc/remove_product_feature/'.$feature->id)}}" class="btn btn-danger" onclick=" return  confirm('Are  you  sure?')">  Delete</a></td>
                      </tr>

                      @endforeach

                      @else
                      <tr>
                        <td colspan="4"> Please  add  any Key Features</td>
                      </tr>
                      @endif

                    </tbody>

                  </table>

                </div>

              </div>
            </form>

              <form  method="POST"  action="{{url('qc/update_product_details')}}">

                  {{csrf_field()}}

                <input  type="hidden" name="seller_id" value="{{ $product->seller_id}}">
                <input type="hidden" name="product_id"  value="{{$product->id}}">
                <input type="hidden" name="category_id" value="{{$category_id}}">

                    <div class="row">
                    <div class="col-md-6">
                        <div  class="form-group">
                            <label>Brand </label>
                            <?php $brands= App\Brand::pluck('name','id')->prepend('Select Brand',''); ?>
{{Form::select('brand_id',$brands,$product->brand_id,['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div  class="form-group {{ $errors->has('main_material') ? 'has-error' : ''}}">
                            <label> Main Material (Leave Blank if Not Applicable) </label>

     {{Form::text('main_material',$product->main_material,['class'=>'form-control'])}}

                        </div>
                    </div>

                    @if($product != null)
                    @if($product->id != null)
                    @php($ancestor = \App\Category::find($product->getAncestorCategory())->name)
                    
                    @if($ancestor == 'Books')
                     <div class="col-md-6">
                        <div  class="form-group">
                            <label> Author </label>
                                  {{Form::text('author',$product->author,['class'=>'form-control'])}}
                        </div>
                    </div>
                       <div class="col-md-6">
                        <div  class="form-group">
                            <label> Publisher </label>
                                  {{Form::text('author',$product->publisher,['class'=>'form-control'])}}
                        </div>
                    </div>
                    @endif
                    @endif
                    @endif
                    <div class="col-md-6">
                        <div  class="form-group">
                          
                            <input type="checkbox" style="margin-top:25px;" id="product_expiry_box" name="product_expiry" @if($product->product_expiry > 0) checked  @endif> Product Has an Expiration Date? (Tick if True) <br>

                        </div>
                    </div>

                    <div class="col-md-6 expiration">
                        <div  class="form-group">
                            <label> Expiration Date </label>
                            {{Form::text('product_expiry_date',$product->product_expiry_date,['class'=>'form-control', 'id' => 'product_expiry_date'])}}
                        </div>
                    </div>

                </div>

                <div class="row">
                  
                    <div class="col-md-6 expiration">
                        <div  class="form-group">
                            <input type="submit" class="btn btn-success blue-button" value="Save">
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab3">                                                    

                <div  id="new_product">
               <form method="POST"  action="{{url('qc/product/add_price')}}">

                {{csrf_field()}}

                <input  type="hidden"  name="product_id"  value="{{$product->id}}">

@if($product->id != null)
<?php $category_sizes= App\Category_size::where('category_id',$product->category->level_two_category)->pluck('size','id')->prepend('Select',''); ?>  

                @if(count($category_sizes) > 1)
               
                    <div  class="col-md-6">
                        <div  class="form-group">
                            <label> Size (Ignore if Not Applicable)</label>
                 @if($product->category_id > 0)
                   
                 {{Form::select('size',$category_sizes,null,['class'=>'form-control'])}}
                 @endif     
                           
                        </div>

                    </div>

                    @endif
                    @endif

                    <div class="col-md-6">
                        <div  class="form-group">
                            <label> Color (Specify if this is Important to Customers) </label>
                            {{Form::text('color',null,['class'=>'form-control'])}}
                        </div>  
                    </div>
                     
                    <div class="col-md-6">
                        <div  class="form-group">
                            <label> Quantity</label>
                            {{Form::number('quantity',null,['class'=>'form-control', 'step' => 1])}}
                        </div>          
                    </div>

                    <div class="col-md-6">
                        <div  class="form-group">
                            <label> Price </label>
                            {{Form::number('standard_price',null,['class'=>'form-control', 'step' => 0.1])}}
                        </div>
                    </div>

                 <div class="row">
                    
                </div>

<div class="col-md-6">
<div class="form-group">

<input  type="submit"  class="btn btn-success blue-button"  value="Save">
</div>

</div>

 </form>     

 </div>

<div class="col-md-12">


 <table class="table" style="border:1px solid #eee;">
  <thead>
      <tr style="background:#f5f5f5;color:#888">
          <th> Size</th>
          <th> Color</th>
          <th> Quantity</th>
          <th> Standard price</th>
          <th> Actions</th>

      </tr>
  </thead>
  <tbody>
      
      @foreach($product->prices  as $price)
      <tr style="border-top:1px solid #eee;">
          <td>{{isset($price->size)?$price->size:"N/A"}}</td>
           <td>{{isset($price->color)?$price->color:"N/A"}}</td>
           <td>{{$price->quantity}}</td>
           
           <td>{{$price->standard_price}}</td>
           <td> 
         <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editmodal{{$price->id}}">Edit</button>
         <a href="{{url('qc/remove_pricing/'.$price->id)}}" onclick="return  confirm('Are  you sure you want to remove this price record?')" class="btn btn-warning"> Delete</a>
         <a href="{{url('qc/promote-product/'.$price->id)}}" class="btn btn-success blue-button">Promote</a>

        <div id="editmodal{{$price->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Update  Product Price</h4>
        </div>
        <div class="modal-body">
        <form method="POST"  action="{{url('qc/product/update_price')}}">

        {{csrf_field()}}

        <input  type="hidden"  name="product_price_id"  value="{{$price->id}}">
        <input  type="hidden"  name="product_id"  value="{{$product->id}}">
        <div class="row">
            <div  class="col-md-6">
                <div  class="form-group">
                    <label> Size</label>
                    {{Form::text('size',$price->size,['class'=>'form-control'])}}

                </div>
               
            </div>

                 <div class="col-md-6">
                <div class="form-group">
                    <label> Color</label>
                    {{Form::text('color',$price->color,['class'=>'form-control'])}}

                </div>
                
            </div>

        </div>
               <div class="row">
            <div  class="col-md-6">
                <div  class="form-group">
                    <label> Quantity</label>
                    {{Form::text('quantity',$price->quantity,['class'=>'form-control'])}}

                </div>
               
            </div>

                <div  class="col-md-6">
                <div  class="form-group {{ $errors->has('minimum_quantity') ? 'has-error' : ''}}">
                    <label> Minimum  Qty</label>
                    {{Form::text('minimum_quantity',$price->minimum_quantity,['class'=>'form-control'])}}

                </div>
                
            </div>

        </div>
               <div class="row">
            <div  class="col-md-6">
                <div  class="form-group {{ $errors->has('standard_price') ? 'has-error' : ''}}">
                    <label> Standard Price</label>
                    {{Form::text('standard_price',$price->standard_price,['class'=>'form-control'])}}

                </div>
               
            </div>

        </div>
        <fieldset style="border-color: red"><legend> Promotion</legend>
          <div class="row">
            <div  class="col-md-4">
                <div  class="form-group">
                    <label> Offer  Price</label>
                    {{Form::text('offer_price',$price->offer_price,['class'=>'form-control'])}}

                </div>
               
            </div>
               <div  class="col-md-4">
                <div  class="form-group">
                    <label> Start  Date</label>
                    {{Form::text('start_date',$price->start_date,['class'=>'form-control'])}}

                </div>
               
            </div>

            <div  class="col-md-4">
                <div  class="form-group">
                    <label> End date</label>
                    {{Form::text('end_date',$price->end_date,['class'=>'form-control'])}}

                </div>

            </div>

        </div>
<fieldset>

<div class="row">
<div class="col-md-6">
<div class="form-group">

<input  type="submit"  class="btn btn-warning"  value="Save">
</div>

</div>

</div>
               </form>    
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>

 </td>
      </tr>

      @endforeach

  </tbody>
     

 </table>

</div>

</div>
<div role="tabpanel" class="tab-pane" id="tab4">
  <p style="font-size: 14px;font-weight: bold;" class="orange-color">  Please  add a maximum  of 6 images for each  product variation </p>

   @foreach($product->prices  as $price)
   <p> Size: {{$price->size}}  Color: {{$price->color}} Price: {{$price->standard_price}} </p>
     
  <div class="row"> 

  @foreach($price->images  as $image)
  <div  class="col-md-2">
    <img src="http://178.79.152.253/assets/images/products/{{$image->image_url}}" width="100px" />
    @if($image->default > 0)
      <div style="font-size: 14px;font-weight: bold;"> <span style="color: #0f7dc2;">Default Image</span> </div>
    @else
    <a href="{{url('qc/image/make_default/'.$image->id)}}">
      <button class="btn orange-button" style="margin-top: 10px;">Make Default</button>
    </a>
    @endif
  <span class=""> 
    <a  href="{{url('qc/remove_image/'.$image->id)}}" class="btn-danger" onclick="return confirm('Are you  sure you want to delete this image?')">  <span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Image"></span></a>
  </span>

    </div>

    @endforeach
  </div>
  <div style="margin-top: 20px;">
    <div style="background: #eee;padding: 10px;color: #0f7dc2;font-weight: bold;margin-bottom: 10px;">Upload New Product Image</div>
    <form  method="POST"  action="{{url('qc/upload_images')}}" enctype="multipart/form-data">
      <input  type="hidden"  name="product_id" value="{{$product->id}}">
       <input  type="hidden"  name="product_price_id" value="{{$price->id}}">
      {{csrf_field()}}
     <div class="row">

         <div class="col-md-4">
             <input type="file" name="file">

         </div>
         <div class="col-md-4">
           <input id="checkBox" name="default" type="checkbox" value="1"> Make Default
         </div>

     </div>

     <div class="row">
      <div  class="col-md-4">

        <input  type="submit"  class="btn btn-primary orange-button" style="margin-top: 23px;
padding: 7px 15px;" value="Save" 
      >
      </div>
     </div>

   </form>
</div>
<hr/>
 @endforeach

</div>
</div>
</div>
</div>