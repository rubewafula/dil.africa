    <script type="text/javascript">
        
$(document).ready(function(){
 // load_features();
 $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');


 // $('#tabMenu a[href="#tab2"]').tab('show');



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
    url: "{{url('seller/update_product_features')}}",
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

     <div class="panel-body">
        <div role="tabpanel">
            <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist" id="tabMenu">
                                                  
                  <li role="presentation"  class="active"  ><a href="#tab1" role="tab"   data-toggle="tab">Product  Information</a></li>
                        @if($product->id > 0)
                            <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">More  product details</a></li>
                            <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Product  combinations</a></li>
                            <li role="presentation"><a href="#tab4" role="tab" data-toggle="tab">Images</a></li>

                            @endif
                          </ul>
                          <!-- Tab panes -->
                          <div class="tab-content">
                                                        
                              <div role="tabpanel" class="tab-pane active "" id="tab1">
                                  <form  method="POST"  action="{{ url('seller/products/save')}}">
                                    {{csrf_field()}}

                                      <input  type="hidden" name="seller_id" value="{{ Auth::user()->seller_id}}">
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
                                                            <div  class="form-group {{ $errors->has('main_material') ? 'has-error' : ''}}">
                                                                <label> Main Material </label>

                                         {{Form::text('main_material',$product->main_material,['class'=>'form-control'])}}

                                                            </div>
                                                        </div>
                                                         <div class="col-md-6">
                                                         <div  class="form-group">
                                                                <label> Tax  Class</label>

                                                                <?php $tax_classes=['0'=>'NoTax','16'=>'16 %']  ?>
                                                                {{Form::select('tax_class',$tax_classes,$product->tax_class,['class'=>'form-control required'])}}

                                                            </div>
                                                        </div>

                                                    </div>
                                              
                                                            <div class="row">
                                                             
                                                        <div class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Product  Warranty </label>

                                         {{Form::text('product_warranty',$product->product_warranty,['class'=>'form-control',
                                         'id'=>'brands'])}}

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <input type="submit" class="btn btn-success btn-lg" value="Save">
                                                         </div>

                                                    </div>

                                                   </form>

                                                   <div class="col-md-6">
                                                     
                                                   </div>

                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab2">

                                                  <div  class="row">
                                                    <div  class="col-md-12">
        <form  method="POST" id="update_featuress"  action="{{url('seller/update_product_features')}}">  
                                                        {{csrf_field()}}

                                                        <input type="hidden" id="" name="product_id" value="{{$product->id}}">
                                            @if($product->category_id > 0)
                                                         <div  class="form-group">
                                                           <label>  Select  Feature Type</label>

                         <?php
                         

                       $feature_types= App\Feature_type::where('level_two_category',$product->category->level_two_category)->pluck('name','id')->prepend('Pick  Feature','');
                                                       
             ?>
            {{Form::select('feature_type_id',$feature_types,null,['class'=>'form-control','id'=>'feature_type_id'])}}
                                                         </div>

                                                         @endif

                                                            <div  class="form-group">
                                                           <label>  Description</label>
                                                         
                 {{Form::text('value',null,['class'=>'form-control','id'=>'description'])}}
                                                         </div>
                                                             <div  class="form-group">
                                                         
                                                           <input type="submit" class="btn btn-primary"  value="Add">
                                                         </div>
</form>

                                                    </div>

                                                  </div>

                                                  <div  class="row">
                                                    <div  class="col-md-12">
                                                      <table  class="table">
                                                        <thead>
                                                          <tr>  
                                                            <td> Feature  Type</td> 
                                                            <td>  Description</td>
                                                            <td></td>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          @if($product->features->count() > 0)
                                                          @foreach($product->features  as $feature)
                                                          <tr>
                                                            <td> {{$feature->feature_type->name}} 
                                                            </td>
                                                            <td>{{$feature->value}}</td>
                                                            <td> <a  href="{{url('seller/remove_product_feature/'.$feature->id)}}" class="btn btn-danger" onclick=" return  confirm('Are  you  sure?')">  Delete</a></td>
                                                          </tr>

                                                          @endforeach

                                                          @else
                                                          <tr>
                                                            <td colspan="4"> Please  add  Features</td>
                                                          </tr>
                                                          @endif

                                                        </tbody>

                                                      </table>

                                                    </div>

                                                  </div>



                                                  <form  method="POST"  action="{{url('seller/update_product_details')}}">

                                                      {{csrf_field()}}

                                                    <input  type="hidden" name="seller_id" value="{{ Auth::user()->seller_id}}">
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
                                                    </div>

                                                    <div class="row">
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

                                                    </div>

                                                         <div class="row">
                                                         <div class="col-md-6">
                                                            <div  class="form-group">
                                                              
                                                                    <input type="checkbox" name="product_expiry" @if($product->product_expiry > 0) checked  @endif> Does the  product Expires? <br>

                                                            </div>
                                                        </div>

                                                                <div class="col-md-6 expiration">
                                                            <div  class="form-group">
                                                                <label> Expiration Date </label>
                                                                      {{Form::text('product_expiry_date',$product->product_expiry_date,['class'=>'form-control'])}}
                                                            </div>
                                                        </div>


                                                    </div>
                                                      <div class="row">
                                                               <div class="col-md-6">
                                                               </div>

                                                             <div class="col-md-6">
                                                                <input type="submit" class="btn btn-success btn-lg" value="Save">
                                                               </div>
                                                           </div>

                                                </form>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab3">
                                                  
                                                    <div class="row">
                                                        <div class="col-md-3">
                                             <button class="btn btn-primary" id="add-new"> Add Price</button>

                                                        </div>
                                                    </div>

                                                    <div  id="new_product">
                                                   <form method="POST"  action="{{url('seller/product/add_price')}}">

                                                    {{csrf_field()}}

                                                    <input  type="hidden"  name="product_id"  value="{{$product->id}}">
                                                    <div class="row">
                                                        <div  class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Size</label>
                                                     @if($product->category_id > 0)
                                                       
                     <?php $category_sizes= App\Category_size::where('category_id',$product->category->level_two_category)->pluck('size','id')->prepend('Select',''); ?>   

                     {{Form::select('size',$category_sizes,null,['class'=>'form-control'])}}
                                                     @endif     
                                                                <!-- {{Form::text('size',null,['class'=>'form-control'])}} -->


                                                            </div>
                                                           

                                                        </div>

                                                             <div  class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Color</label>
                                                                {{Form::text('color',null,['class'=>'form-control'])}}


                                                            </div>
                                                            

                                                        </div>

                                                    </div>
                                                           <div class="row">
                                                        <div  class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Quantity</label>
                                                                {{Form::text('quantity',null,['class'=>'form-control'])}}


                                                            </div>
                                                           

                                                        </div>
                                                        <div  class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Price </label>
                                                                {{Form::text('standard_price',null,['class'=>'form-control'])}}


                                                            </div>
                                                          

                                                        </div>

                                                          <!--    <div  class="col-md-6">
                                                            <div  class="form-group">
                                                                <label> Minimum Order Qty</label>
                                                                {{Form::text('minimum_quantity',null,['class'=>'form-control','value'=>1])}}


                                                            </div>
                                                            

                                                        </div> -->

                                                    </div>
                                                           <div class="row">
                                                        

                                                    </div>
                                                   <!--  <fieldset style="border-color: red"><legend> Promotion</legend>
                                                      <div class="row">
                                                        <div  class="col-md-4">
                                                            <div  class="form-group">
                                                                <label> Offer  Price</label>
                                                                {{Form::text('offer_price',null,['class'=>'form-control'])}}


                                                            </div>
                                                           

                                                        </div>
                                                           <div  class="col-md-4">
                                                            <div  class="form-group">
                                                                <label> Start  Date</label>
                                                                {{Form::text('start_date',null,['class'=>'form-control'])}}


                                                            </div>
                                                           

                                                        </div>

   <div  class="col-md-4">
                                                            <div  class="form-group">
                                                                <label> End date</label>
                                                                {{Form::text('end_date',null,['class'=>'form-control'])}}


                                                            </div>
                                                           

                                                        </div>

                                                    </div>
<fieldset> -->

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            
            <input  type="submit"  class="btn btn-success"  value="Save">
        </div>

    </div>

</div>
                                                   </form>     

                                                   </div>
                                                   <div   class="row">
                                                       <div class="col-md-12">


                                                           <table class="table">
                                                            <thead>
                                                                <tr style="background:grey;color:#fff">
                                                                    <th> Size</th>
                                                                     <th> Color</th>
                                                                    <th> Quantity</th>
                                                                     <th> Minimum Order Quantity</th>
                                                                      <th> Standard price</th>
                                                                    <!-- <th> Offer  price</th> 
                                                                     <th>Start Date</th>
                                                                     <th> End  Date</th>-->
                                                                     <th> Actions</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                                @foreach($product->prices  as $price)
                                                                <tr>
                                                                    <td>{{$price->size}}</td>
                                                                     <td>{{$price->color}}</td>
                                                                     <td>{{$price->quantity}}</td>
                                                                     <td>{{$price->minimum_quantity}}</td>
                                                                     <td>{{$price->standard_price}}</td>
                                                                    <!--  <td>{{$price->offer_price}}</td>
                                                                     <td>{{$price->start_date}}</td>
                                                                     <td>{{$price->end_date}}</td> -->
                                                                     <td> 
                                                                   <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editmodal{{$price->id}}">Edit</button>
                                                                   <a href="{{url('seller/remove_pricing/'.$price->id)}}" onclick="return  confirm('Are  you sure?')" class="btn btn-warning"> Delete</a>

<div id="editmodal{{$price->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Update  Product Price</h4>
      </div>
      <div class="modal-body">
               <form method="POST"  action="{{url('seller/product/update_price')}}">

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

                                                             <div  class="col-md-6">
                                                            <div  class="form-group">
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
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab4">
                                                  <p>  please  add a maximum  for each  product combination </p>

                                                   @foreach($product->prices  as $price)
                                                   <p> Size: {{$price->size}}  Color: {{$price->color}} Price: {{$price->standard_price}} </p>
                                                     


                                                  <div class="row"> 
  
                                                  @foreach($price->images  as $image)
                                                  <div  class="col-md-2">
                                                    <img src="{{url('assets/images/products/'.$image->image_url)}}" width="100px" />
                                                    @if($image->default > 0)
                                                       <sup>Main</sup>
                                                    @endif
                    <span class=""> <a  href="{{url('seller/remove_image/'.$image->id)}}" class="btn-danger" onclick="return confirm('Are you  sure?')">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </span>

                                                  </div>

                                                  @endforeach
                                                </div>
                                                  <form  method="POST"  action="{{url('seller/upload_images')}}" enctype="multipart/form-data">
                                                    <input  type="hidden"  name="product_id" value="{{$product->id}}">
                                                     <input  type="hidden"  name="product_price_id" value="{{$price->id}}">
                                                    {{csrf_field()}}
                                                   <div class="row">

                                                       <div class="col-md-4">
                                                           <input type="file" name="file">

                                                       </div>
                                                       <div class="col-md-4">
                                                         <input id="checkBox" name="default" type="checkbox" value="1"> Default
                                                       </div>

                                                   </div>

                                                   <div class="row">
                                                    <div  class="col-md-4">

                                                      <input  type="submit"  class="btn btn-primary" style="margin-top: 23px;
    padding: 7px 15px;" value="Save" 
                                                    >
                                                    </div>
                                                   </div>




                                                 </form>

<hr/>
                                                   @endforeach



                                                </div>
                                            </div>
                                        </div>
                                    </div>

