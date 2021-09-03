    @extends('backend::layouts.master')
    @section('content')

    <script type="text/javascript">
      $(document).ready(function(){

       $(".suspended").hide();
       load_reasons();

       $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
       
       $("#status_id").change(function(){

         load_reasons();

       });

       function  load_reasons()
       {

         var  status_id=  $('#status_id').val();

         if(status_id == '2')
         {
           $(".suspended").show();


         } else{
           $(".suspended").hide();

         }

       }

     });


   </script>

   <div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

  </div>
  <div class="page-title">
    <div class="container">
      <h3> Manage  Product: {{$product->name}} 
        <span class="pull-right"> Status: {{$product->status}}</span>

      </h3>
    </div>
  </div>
  <div id="main-wrapper" class="container" >
    <div class="row">
      <div class="col-md-12">
        <div class="panel-heading clearfix"></div>

        <div class="panel panel-white">
         <div class="panel-body">

           <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="tabMenu">
             @if($product->id > 0)

             <li role="presentation" class="active"><a href="#orders" role="tab" data-toggle="tab"> <span class="glyphicon glyphicon-files" aria-hidden="true"></span>   Orders</a></li>
             @endif
             <li role="presentation"><a href="#admin" role="tab" data-toggle="tab"> Administration </a></li>


             <li role="presentation" @if($product->id < 1) class="active" @endif  ><a href="#tab1" role="tab"   data-toggle="tab">Product  Information</a></li>
             @if($product->id > 0)
             <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">More  product details</a></li>
             <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Product  pricing</a></li>
             <li role="presentation"><a href="#tab4" role="tab" data-toggle="tab">Images</a></li>
             <li role="presentation"><a href="#tab5" role="tab" data-toggle="tab">Product Tags</a></li>
             @endif
           </ul>
           <!-- Tab panes -->
           <div class="tab-content">
            @if($product->id > 0)

            <div role="tabpanel" class="tab-pane active" id="orders">
              <h3>Orders</h3>
              <div  class="row">
                <div  class="col-md-12">

                  <table class="table">
                    <thead class="thead-dark" style="background-color:#9b9ea0;color:#fff">
                      <tr> 
                        <td> Order  ref#</td>
                        <td>  Quantity </td>
                        <td>   Order  date </td>
                        <td>   Status </td>
                      </tr>
                    </thead>
                    <tbody>

                      @if($product->order_details->count()> 0)

                      @foreach($product->order_details as $order)
                      <tr>
                        <td> {{$order->order->order_ref}} </td>
                        <td> {{$order->quantity}}</td>
                        <td>  {{$order->created_at->format('dd/mm/yyyy h:i')}}</td>
                        <td>  {{$order->status}}</td>

                      </tr>
                      @endforeach

                      @else
                      <tr>
                        <td colspan="4"> There  are no  orders  that  have  been  made  yet</td>
                      </tr>


                      @endif

                    </tbody>

                  </table>

                </div>

              </div>

            </div>
            @endif

            <div role="tabpanel" class="tab-pane @if($product->id < 1) active @endif " id="tab1">
             <form  method="POST"  action="{{ url('backend/products/save')}}">
              {{csrf_field()}}

              <input  type="hidden" name="seller_id" value="{{ Auth::user()->seller_id}}">
              <input type="hidden" name="product_id"  value="{{$product->id}}">
              <input type="hidden" name="category_id" value="{{$product->category_id}}">
              <div class="row">
                <div class="col-md-6">
                  <div  class="form-group">
                    <label> Name *</label>

                    {{Form::text('name',$product->name,['class'=>'form-control'])}}

                  </div>
                </div>
                <div class="col-md-6">
                  <div  class="form-group">
                    <label></label>
                    <input type="checkbox" name="locally_made_products" @if($product->locally_made_products > 0) checked  @endif>Locally  Made Products <br>

                  </div>
                </div>

              </div>

              <div  class="row">
                <div  class="col-md-12">
                  <div  class="form-group">
                    <label> Product  Description </label>

                    {{Form::textarea('product_description',$product->product_description,['class'=>'form-control textarea',
                    'id'=>'desc','rows'=>'20'])}}
                  </div>


                </div>

              </div>
              <div class="row">

               <div class="col-md-6">
                <div  class="form-group">
                  <label> Main Material *</label>

                  {{Form::text('main_material',$product->main_material,['class'=>'form-control'])}}

                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div  class="form-group">
                  <label> Whats in  the box </label>

                  {{Form::textarea('whats_inthe_box',$product->whats_inthebox,['class'=>'form-control',
                  'id'=>'brands'])}}

                </div>
              </div>

              <div class="col-md-6">
                <div  class="form-group">
                  <label> Tax  Class</label>

                  <?php $tax_classes=['0'=>'NoTax','16'=>'16 %']  ?>
                  {{Form::select('tax_class',$tax_classes,$product->tax_class,['class'=>'form-control'])}}

                </div>
              </div>

            </div>

            <div class="row">
             <div class="col-md-6">
              <div  class="form-group">
                <label> Product Highlights</label>

                {{Form::textarea('highlight',$product->highlight,['class'=>'form-control textarea','id'=>'highlight'])}}


              </div>
            </div>

            <div class="col-md-6">
              <div  class="form-group">
                <label> Product  Warranty </label>

                {{Form::textarea('product_warranty',$product->product_warranty,['class'=>'form-control',
                'id'=>'brands'])}}

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
    <div role="tabpanel" class="tab-pane" id="tab2">
      
      <form  method="POST"  action="{{url('backend/update_product_details')}}">

        {{csrf_field()}}

        <input  type="hidden" name="seller_id" value="{{ Auth::user()->seller_id}}">
        <input type="hidden" name="product_id"  value="{{$product->id}}">
        <input type="hidden" name="category_id" value="{{$product->category_id}}">

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

  <div  id="new_product">

  </div>
  <div   class="row">
   <div class="col-md-12">


     <table class="table">
      <thead>
        <tr>
          <th> Size</th>
          <th> Color</th>
          <th> Quantity</th>
          <th> Minimum Order Quantity</th>
          <th> Standard price</th>
          <th> Offer  price</th>
          <th>Start Date</th>
          <th> End  Date</th>
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
          <td>{{$price->offer_price}}</td>
          <td>{{$price->start_date}}</td>
          <td>{{$price->end_date}}</td>
          <td> 

           <a href="" class="btn btn-warning"> Delete</a>


         </td>
       </tr>

       @endforeach

     </tbody>


   </table>

 </div>

</div>
</div>

<div role="tabpanel" class="tab-pane" id="admin">
 <form method="POST"  action="{{url('backend/update_product_admin/'.$product->id)}}">

  <div  class="row">
   <div class="col-md-12">
    <div  class="form-group">
     <label> Supplier</label>

     <?php $sellers= App\Seller::pluck('name','id')->prepend('select',''); ?>

     {{Form::select('seller_id',$sellers,$product->seller_id,['class'=>'form-control'])}}

   </div>

 </div>		

</div>

<div  class="row">
 <div class="col-md-12">
  <div  class="form-group">
   <label> Status</label>

   <?php $statuses = ['0'=>'DRAFT','1'=>'PUBLISHED','2'=>'SUSPENDED']; ?>

   {{Form::select('publish_status',$statuses,$product->publish_status,['class'=>'form-control','id'=>'status_id'])}}

 </div>

</div>		

</div>

<div  class="suspended">

  <div  class="row">
   <div class="col-md-12">
    <div  class="form-group">
      <label> Reason For  Suspension </label>
      <?php  $reasons=App\Suspension_reason::pluck('name','id')->prepend('Select one  option','') ?>

      {{Form::select('suspension_reason_id',$reasons,$product->suspension_reason_id,['class'=>'form-control'])}}

    </div>

  </div>   

</div>  

<div  class="row">
 <div class="col-md-12">
  <div  class="form-group">
    <label> Comments </label>

    {{ Form::textarea('comments',null,['class'=>'form-control textarea']) }}

  </div>

</div>   

</div>  

</div>

<div  class="row">
 <div class="col-md-3">

  <input  type="submit"  class="btn  btn-success" value="Save">
</div>
</div>

{{csrf_field()}}
</form>	

</div>
<div role="tabpanel" class="tab-pane" id="tab4">
  <p>  please  add a maximum  of  5  pictures</p>
  <div class="row"> 
    @foreach($product->images  as $image)
    <div  class="col-md-2">
      <img src="{{url('assets/images/products/'.$image->image_url)}}" width="100px" />
      @if($image->default > 0)
      <sup>Main</sup>
      @endif
      <span class=""> <a  href="{{url('backend/remove_image/'.$image->id)}}" class="btn-danger" onclick="return confirm('Are you  sure?')">  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
    </span>
  </div>

  @endforeach
</div>


</div>

<div role="tabpanel" class="tab-pane" id="tab5">
      
      <form  method="POST"  action="{{url('backend/order/add-product-tag')}}">

        {{csrf_field()}}

        <input  type="hidden" name="seller_id" value="{{ Auth::user()->seller_id}}">
        <input type="hidden" name="product_id"  value="{{$product->id}}">
        <input type="hidden" name="category_id" value="{{$product->category_id}}">

        <div class="row">
         <div class="col-md-12">
          <div  class="form-group">
            <label> Tag </label>
            {{Form::text('product_tag', null,['class'=>'form-control'])}}
          </div>
        </div>

      </div>

    <div class="row">

     <div class="col-md-6">
      <input type="submit" class="btn btn-success btn-lg" value="Save">
    </div>
  </div>

  <div class="row" style="margin-top: 10px;color: #0F7DC2;">

    <div class="col-md-12">
      @foreach($product_tags as $tag)

      {{$tag->tag->name}}, &nbsp;
      @endforeach
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