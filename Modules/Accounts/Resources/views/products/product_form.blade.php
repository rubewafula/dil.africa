
        <script type="text/javascript">
            $(document).ready(function(){

              $("#brand_id").select2();

              $("#category_id").select2();

            });

        </script>


<div class="panel-body" style="padding: 15px;">

             <span  class="pull-right">
    
    <a  href="{{url('accounts/preview_product/'.$product->slug)}}" target="_BLANK" 
      class="btn btn-primary btn-sm">  Preview   </a>
  </span>
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
               <form  method="POST"  action="{{ url('accounts/products/save')}}">
                {{csrf_field()}}

@if(isset($seller_id))
                <input  type="hidden" name="seller_id" value="{{ $seller_id}}">
@endif
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

                <div class="row">
                    <div class="col-md-12">
                        <div  class="form-group {{ $errors->has('keywords') ? 'has-error' : ''}}">
                            <label> Keywords (Helps in Google Search) (Separate Keywords by Comma) </label>

     {{Form::text('keywords',$product->keywords,['class'=>'form-control'])}}
             {!! $errors->first('keywords', '<p class="help-block">:message</p>') !!}


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
                               <select  name="category_id" id="category_id" class="form-control">
                               <?php $levels1 = \App\Category::where('level',1)->get(); ?>
                               @foreach($levels1 as  $level1)
                                 <optgroup label="{{$level1->name}}">

                            <?php $levels2= \App\category::where('depends_on',$level1->id)->get(); ?>

                            @foreach($levels2 as $level_2)
                              <optgroup label="{{$level_2->name}}">
                           <?php $levels3= \App\Category::where('depends_on',$level_2->id)->get() ?>

                           @foreach($levels3 as  $lev3)
                           @if($product->id > 0)
                           <option value="{{$lev3->id}}" @if($product->category_id == $lev3->id) selected @endif >{{$lev3->name}}</option>

                           @else
                           <option value="{{$lev3->id}}"  @if($category_id == $lev3->id) selected @endif >{{$lev3->name}}</option>



                           @endif

                           @endforeach

 
                              </optgroup>
                            @endforeach

                              </optgroup>
                               @endforeach

                             </select>
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
                        <div  class="form-group">
                            <label>Brand </label>
                            <?php $brands= App\Brand::pluck('name','id')->prepend('Select Brand',''); ?>
      {{Form::select('brand_id',$brands,$product->brand_id,['class'=>'form-control', 'id' => 'brand_id'])}}
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
                  <form  method="POST"  action="{{url('accounts/update_features')}}">
                    {{csrf_field()}}
                    <input  type="hidden" name="product_id"  value="{{$product->id}}">
                  <table  class="table">
                    <thead class="orange-color" style="background: #eee;font-weight: bold;font-size: 14px;">
                      <tr>  
                        <td> Feature Type</td> 
                        <td> Description</td>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>
                    @if($product->id > 0)
                      <?php  $ftypes= App\Feature_type::where('level_two_category',$product->category->level_two_category)->get(); ?>

                      @foreach($ftypes as $ftype)

                      <?php  $product_feature = App\Product_feature::where(['product_id'=>$product->id,'feature_type_id'=>$ftype->id])->first(); ?>

                      <tr>
                        <td>{{$ftype->name}} </td>
                        <td> <input type="text" name="{{$ftype->id}}" class="form-control" placeholder="{{$ftype->name}}" value=" @if(!empty( $product_feature)){{ trim($product_feature->value)}} @endif" required="required"></td>
                      </tr>
                      @endforeach
                      @endif
                        
                            <?php  $product_feature2 = App\Product_feature::where(['product_id'=>$product->id,'feature_type_id'=>0])->first(); ?>

                      <tr>
                        <td>General (Other) </td>
           <td> <input type="text" name="0" class="form-control" 
                 value="@if(!empty($product_feature2)){{trim($product_feature2->value)}} @endif"> </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td> <input type="submit" name="save"  value="Save" class="btn btn-success"></td>
                      </tr>


                  <!--     <form  method="POST" id="addfeature" action="{{url('seller/update_product_features')}}">
                              {{csrf_field()}}

                      <tr>
                        <td>
                             <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}">
                 

   @if($product->category_id > 0)
                     <div  class="form-group">
                       <label>  Select  Feature Type</label>

<?php
$feature_types= App\Feature_type::where('level_two_category',$product->category->level_two_category)->pluck('name','id')->prepend('General','0')->prepend('Pick  Feature','');
                   
?>
{{Form::select('feature_type_id',$feature_types,null,['class'=>'form-control','id'=>'feature_type_id'])}}
                     </div>

                     @endif
                         </td>
                         <td>
                            <div  class="form-group">
                       <label>Description</label>
                     
{{Form::text('value',null,['class'=>'form-control','id'=>'description'])}}
                     </div>

                         </td>
                         <td>
                  <div  class="form-group" style="margin-top: 10 px">
                   <label></label>
                       <input type="submit" class="btn btn-primary"  value="Add Feature ">
                     </div>

                         </td>

                      </tr>
                    </form> -->

<!-- 
                      @if($product->features->count() > 0)
                      @foreach($product->features  as $feature)
                      <tr>
                        <td> {{($feature->feature_type != null)?$feature->feature_type->name:"General"}} 
                        </td>
                        <td>{{$feature->value}}</td>
                        <td> <a  href="{{url('seller/remove_product_feature/'.$feature->id)}}" class="btn btn-danger" onclick=" return  confirm('Are  you  sure?')">  Delete</a></td>


                      </tr>

                      @endforeach

                      @else
                      <tr>
                        <td colspan="4"> Please  add  any Key Features</td>
                      </tr>
                      @endif -->

                    </tbody>

                  </table>
                  </form>


                </div>

              </div>

          </div>
            <div role="tabpanel" class="tab-pane" id="tab3">                                                    

                <div  id="new_product">
           <!--     <form method="POST"  action="{{url('seller/product/add_price')}}">

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
                    @else

                    {{Form::text('size', null, ['class'=>'form-control'])}}
                    @endif     

                    </div>

                    </div>

                    @else
                    <div  class="col-md-6">
                    <div  class="form-group">
                    <label> Size (Ignore if Not Applicable)</label>
                    {{Form::text('size',null,['class'=>'form-control'])}}
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

 </form>     --> 

 </div>

<div class="col-md-12">


 <table class="table" style="border:1px solid #eee;">
  <thead>
     <tr>
        <th colspan="5"></th>
        <th colspan="4" style="background:#808080;color:#fff;text-align: center;"> Promotion Pricing(Optional)</th>

      </tr>
      <tr style="background:#0F7DC2;color:#fff">
          <th>Seller  SKU * </th> 
          <th> Size (Optional)</th>
          <th> Color (Optional)</th>
          <th> Quantity</th>
          <th> Price (Ksh)</th>
          <th style="background:#808080;color:#fff;text-align: center;"> Offer  Price(Ksh)</th>
          <th style="background:#808080;color:#fff;text-align: center;"> Start Date </th>
          <th style="background:#808080;color:#fff;text-align: center;" > End date </th>
         <th style="background:#808080;color:#fff;text-align: center;" > Action </th>


      </tr>
     

  </thead>
  <tbody>
    
    <form method="POST"  action="{{url('accounts/product/add_price')}}">

                {{csrf_field()}}

                <input  type="hidden"  name="product_id"  value="{{$product->id}}">
                <tr>
                    <td> 
                          <input  type="text"  name="skuid"  class="form-control" value="" readonly="readonly">
                     </td>
                  <td> 
                @if(App\Product::where('category_id',$product->category_id)->exists())

                @if(count($category_sizes) > 1)
                  
                  {{Form::select('size',$category_sizes, null, ['class'=>'form-control'])}}

                @else
                  {{Form::text('size', null, ['class'=>'form-control'])}}

                @endif

            @endif
                     
       </td>
       <td>
          {{Form::text('color',null,['class'=>'form-control'])}}

       </td>
       <td>
            {{Form::text('quantity',null,['class'=>'form-control ', 
              'step' => 1,'required'=>'required'])}}

       </td>
       <td>
         
      {{Form::text('standard_price',null,['class'=>'form-control', 
        'id'=>'standard_price', 'required' => 'required'])}}
       </td>
       <td>
          {{Form::text('offer_price',null,['class'=>'form-control','id'=>'offer_price'])}}
          <span class="error-show" style="color: #ff0000"></span>

       </td>
       <td>
           
          {{Form::text('start_date',null,['class'=>'form-control start_date'])}}

         
       </td>
       <td>
           
          {{Form::text('end_date',null,['class'=>'form-control end_date'])}}

         
       </td>

       <td>
        <button type="submit"  class="btn btn-warning orange-button btn-sm" >
             <span class="glyphicon glyphicon-plus"> Add</span>

        </button>

    </td>

    </tr>
  </form> 
      
      @foreach($product->prices  as $price)
    
  <tr style="border-top:1px solid #eee;">
           <td>S{{$price->seller_code}}-{{$price->skuid}}</td>
          <td>{{isset($price->size)}}</td>
           <td> {{$price->color}}</td>
           <td>{{$price->quantity}}</td>
          
           <td>{{$price->standard_price}}</td>
           <td>{{$price->offer_price}}</td>
           <td>{{$price->start_date}}</td>
           <td>{{$price->end_date}}</td>
           <td>  
             <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal{{$price->id}}">  <span class="glyphicon glyphicon-pencil"> Edit</span>
</button>
        
       <!--   <a href="{{url('seller/promote-product/'.$price->id)}}" class="btn btn-success blue-button btn-sm">Promote</a>
 -->
        <div id="editmodal{{$price->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Update  Product Price</h4>
        </div>
        <div class="modal-body">
<script type="text/javascript">
  
  $(document).ready(function(){
  $(".offer_price").keyup(function(){

             var  offer_price= $(this).val();
             //alert(offer_price);
             var  standard_price= $(".standard_price").val();
           // alert(standard_price);
             if(offer_price >= standard_price)
             {
              $(".error-show").text(" The offer price should  be  less  than your price");
     
            } else{

                $(".error-show").empty();
            }



            });


  });
</script>

        <form method="POST"  action="{{url('accounts/product/update_price')}}">

        {{csrf_field()}}

        <input  type="hidden"  name="product_price_id"  value="{{$price->id}}">
        <input  type="hidden"  name="product_id"  value="{{$product->id}}">
        <div class="row">
             <div class="col-md-4">
                <div class="form-group">
                    <label> Seller  SKU</label>
                    {{Form::text('skuid','S'.$price->seller_code.'-'.$price->skuid,['class'=>'form-control','readonly'=>'readonly'])}}

                </div>
                
            </div>
            <div  class="col-md-4">
                <div  class="form-group">
                    <label> Size</label>
                      @if(App\Product::where('category_id',$product->category_id)->exists())

            @if(count($category_sizes) > 1)
              
              {{Form::select('size',$category_sizes,$price->size,['class'=>'form-control'])}}

            @else
              {{Form::text('size', $price->size, ['class'=>'form-control'])}}


            @endif

            @endif
                   

                </div>
               
            </div>

                 <div class="col-md-4">
                <div class="form-group">
                    <label> Color</label>
                    {{Form::text('color',$price->color,['class'=>'form-control'])}}

                </div>
                
            </div>

        </div>
               <div class="row">
            <div  class="col-md-4">
                <div  class="form-group">
                    <label> Quantity</label>
                    {{Form::text('quantity',$price->quantity,['class'=>'form-control'])}}

                </div>
               
            </div>
             <div  class="col-md-6">
                <div  class="form-group {{ $errors->has('standard_price') ? 'has-error' : ''}}">
                    <label>  Price</label>
                    {{Form::text('standard_price',$price->standard_price,['class'=>'form-control standard_price'])}}

                </div>
               
            </div>
             

        </div>
     <h4>Promotion  Price</h4>
           <div class="row">
            <div  class="col-md-4">
                <div  class="form-group">
                    <label> Offer  Price</label>
                    {{Form::text('offer_price',$price->offer_price,['class'=>'form-control offer_price'])}}
          <span class="error-show" style="color: #ff0000"></span>

                </div>
               
            </div>
             <div  class="col-md-4">
                <div  class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
                    <label>  Start  Date</label>
                    {{Form::text('start_date',$price->start_date,['class'=>'form-control start_date'])}}

                </div>
               
            </div>

            <div  class="col-md-4">
                <div  class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
                    <label>  End  Date</label>
                    {{Form::text('end_date',$price->end_date,['class'=>'form-control end_date'])}}

                </div>
               
            </div>
             

        </div>

            
    
<div class="row">
  <div class="col-md-6">
     <a href="{{url('accounts/remove_pricing/'.$price->id)}}" onclick="return  confirm('Are  you sure you want to remove this price record?')" class="btn btn-danger btn-sm"> Delete</a>
</div>
<div class="col-md-6">

<div class="form-group pull-right">

<input  type="submit"  class="btn btn-success btn-lg"  value="Save">
</div>

</div>

</div>
               </form>    
</div>
<!-- <div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div> -->
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
     <h4> <div style="background: #eee;padding: 10px;color: #0f7dc2;font-weight: bold;margin-bottom: 10px;"> Please upload images  for  the  SKU : <strong>S{{$price->seller_code}}-{{$price->skuid}} </strong> </div></h4>

   <p> Size: {{$price->size}}  Color: {{$price->color}} Price: {{$price->standard_price}} </p>
     
  <div class="row"> 

  @foreach($price->images  as $image)
  <div  class="col-md-2">
    <img src="{{url('assets/images/products/'.$image->image_url)}}" width="100px" />
    @if($image->default > 0)
      <div style="font-size: 14px;font-weight: bold;"> <span style="color: #0f7dc2;">Default Image</span> </div>
    @else
    <a href="{{url('accounts/image/make_default/'.$image->id)}}">
      <button class="btn orange-button" style="margin-top: 10px;">Make Default</button>
    </a>
    @endif
  <span class=""> 
    <a  href="{{url('accounts/remove_image/'.$image->id)}}" class="btn-danger" onclick="return confirm('Are you  sure you want to delete this image?')">  <span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Image"></span></a>
  </span>

    </div>

    @endforeach
  </div>
  <div style="margin-top: 20px;">
    <!-- <div style="background: #eee;padding: 10px;color: #0f7dc2;font-weight: bold;margin-bottom: 10px;">Upload New Product Image</div> -->
    <form  method="POST"  action="{{url('accounts/upload_images')}}" enctype="multipart/form-data">
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