@extends('seller::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3>  Promotions </h3>
                    </div>
                </div>
                <div class="panel panel-white">

                <div id="main-wrapper" class="container" >

                    <div class="row">
                        
                        <div class="col-md-12">
                            
                          <table class="table table-bordered">
                            <thead class="thead-dark" style="background-color:#f5f5f5f;color:#888">
                              <tr>
                                <th> Product Code</th>
                                <th> Name </th>
                                <th> Category</th>
                                <th> Standard Price</th>
                                <th> Offer Price</th>
                                <th> Status</th>
                                <th> Actions</th>
                               </tr>
                            </thead>
                            <tbody>
                            	 
@if(count($promotions) > 0)
@foreach($promotions  as $promotion)
<tr>
	<td>{{$promotion->product->product_code}}</td>
    <td>{{$promotion->product->name}}</td>
    <td>  

    @if(App\Category::where('id',$promotion->product->category_id)->exists())

      {{$promotion->product->category->name}}

    @endif

     </td>
     <td>{{$promotion->standard_price}}</td>
     <td>{{$promotion->offer_price}}</td>
     <td>
        {{ ($promotion->status == 1)?"Active":"Inactive"}} 

     </td>
     <td>
      
      @if($promotion->status == 1)
      <a href="{{ url('seller/deactivate_promotion/'.$promotion->id)}}" class="btn-danger btn-sm" onclick="return confirm('Are you sure  you  want to  deactivate this promotion ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
      @else
      <a href="{{ url('seller/activate_promotion/'.$promotion->id)}}" class="btn-success btn-sm blue-button" onclick="return confirm('Are you sure  you  want to  activate this promotion ?')"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
      @endif
     </td>

</tr>


@endforeach

@else
<tr>
  <td  colspan="7"> You have  not added any  promotions for your products</td>

</tr>
@endif

  </tbody>
</table>
                        </div>
</div>

                    </div>

                	
                </div>

  @endsection              