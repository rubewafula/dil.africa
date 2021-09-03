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

            <a href="{{ url('/backend/campaign-groups') }}" title="Back">
              <button class="btn btn-warning btn-sm" style="margin-top: 15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr><th> Group Name</th><td> {{ $campaign_group->group_name }} </td></tr>
                  <tr><th> Description </th><td> {{ $campaign_group->description }} </td></tr>
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
                  <div  class="col-md-8 col-sm-12">

                  </div>
                  <div  class="col-md-4 col-sm-12">
                      <span  class="pull-right"> 
                        <a href="{{ url('/backend/campaign-groups/msisdns/add/'.$campaign_group->id) }}" class="btn btn-success btn-sm" style="margin-bottom: 5px;" title="Add Phone Number">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Phone Numbers
                        </a> 
                        <a href="{{ url('/backend/campaign-groups/' . $campaign_group->id . '/sms') }}" title="Send SMSs"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;margin-bottom: 5px;"> Send SMSs</button></a>
                    </span>
                </div>

            </div>
            <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
              <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                <tr>
                  <th>Phone Number</th>  
                  <th>Status</th>    
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($campaign_msisdns as $item)
                <tr>
                  <td>{{ $item->msisdn }}</td>
                  <td>{{ ($item->status == 1)?"Active":Inactive }} </td>
                  <td> 
                    <form method="POST" action="{{ url('/backend/campaign-groups/msisdns/remove-from-group/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-danger btn-sm" title="Remove from this Campaign Group" onclick="return confirm(&quot;Are you sure you want to remove this number from this campaign group?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i>  Remove from Campaign Group </button>
                    </form>
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