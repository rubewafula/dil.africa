  @extends('backend::layouts.master')
  @section('content')

  <div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

  </div>

  <div id="main-wrapper" class="container" >
    <div class="row">
      <div class="col-md-12">
        <div class="panel-heading clearfix"> Customer Searches  </div>

        <div class="panel panel-white">
          <div class="panel-body">
           <div  class="row">
            <div class="col-md-12">

              <table class="table table-bordered">
                <thead class="thead-dark" style="background-color:#FFA200;color:#fff">
                  <tr>
                    <th> Date  </th>
                    <th> Original Search Item </th>
                    <th> Hit </th>
                    <th> Searched From  </th>
                    <th> Prompted Search Item</th>
                    <th> Phone Number</th>
                    <th> Email Address</th>
                    

                  </tr>
                </thead>
                <tbody>

               @foreach($customer_searches  as $item)

               <tr>
                <td>{{$item->created_at}} </td>
                <td>{{$item->original_search_item}}</td>
                <td>{{$item->search_hit}} </td>
                
                <td>{{$item->ip_address}} </td>
                <td>{{$item->prompted_search_item}} </td>
                <td>{{$item->phone_number}} </td>
                <td>{{$item->email_address}} </td>

            </tr>

            @endforeach

          </tbody>
        </table>

      </div>

    </div>

  </div>
</div>

</div>
</div>
</div>

@endsection