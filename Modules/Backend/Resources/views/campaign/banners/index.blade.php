  @extends('backend::layouts.master')

  @section('content')
        <div class="page-breadcrumb" >
           {{ Breadcrumbs::render() }}

        </div>

        <div class="container">
          <div class="row">

            <div class="col-md-12">
                <div class="card">
      
                    <div class="card-body">

                        <a href="{{ url('/backend/campaign') }}" title="Back">
                          <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Campaign Name</th><td> {{ $campaign->name }} </td></tr>
                                    <tr><th> Active From </th><td> {{ $campaign->active_from }} </td></tr>
                                    <tr><th> Active To </th><td> {{ $campaign->active_to }} </td></tr>
                                    <tr><th> Category </th><td> {{ ($campaign->category_id != null)?$campaign->category->name:"" }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                         <h4 class="panel-title"></h4> 
                    </div>
                    <div class="panel-body">

                        
                       <div class="table-responsive">

                          <div  class="row">

                            <div  class="col-md-4 col-sm-12">
                              
                              <div class="page-title">
                                  <div class="container" class="blue-text" style="padding: 10px;font-size: 18px;text-align: center;border-bottom: 1px solid #ddd;">
                                      Add / Remove Banners to <span style="color: #0F7DC2;">{{ $campaign->name }} </span>
                                  </div>
                              </div>
                            </div>

                          </div>
                        <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                                <tr>
                                  <th>Promotion Section</th>  
                                  <th>Active From</th> 
                                  <th>Active To</th>
                                  <th>Banner</th>
                                  <th>Status</th>   
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($campaign_banners as $item)
                            <tr>
                              <td>{{ ucwords(str_replace("_", " ", $item->promotion_section->name)) }}</td>
                              <td>{{ $item->active_from }}</td>
                              <td>{{ $item->active_to }} </td>
                              <td>
                                <a href="{{url('/assets/images/banners/'.$item->url)}}" target="_blank"> Banner </a> 
                              </td>
                              <td>{{ ($item->status == 1)?"Active":"Inactive" }}</td>
                              <td> 

                                @if($item->campaign_id != $campaign->id)
                                  <a href="{{ url('/backend/campaign/banners/add-to-campaign/' . $campaign->id . '/'. $item->id) }}" title="Add to this Campaign"><button class="btn btn-primary btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add to Campaign </button></a>
                                @else
                                  <form method="POST" action="{{ url('/backend/campaign/banners/remove-from-campaign/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                      {{ csrf_field() }}
                                      <button type="submit" class="btn btn-danger btn-sm" title="Remove from this Campaign" onclick="return confirm(&quot;Are you sure you want to remove this banner from this campaign?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i>  Remove from Campaign </button>
                                  </form>
                                @endif
                              </td>
                            </tr>
                            @endforeach   
                            
                          </tbody>
                        </table>  

                        </div>
                    </div>
                </div>
               
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
    <div class="page-footer">
        <div class="container">
            <p class="no-s"><?php echo date('Y') ?> &copy; DIL.AFRICA</p>
        </div>
    </div>
         
   @endsection