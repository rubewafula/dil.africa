@extends('backend::layouts.master')

@section('content')

<div class="page-breadcrumb" >
     {{ Breadcrumbs::render() }}
</div>

<div class="page-title">
    <div class="container">
          <h3>Campaigns Groups</h3>
      </div>
  </div>

  <div id="main-wrapper" class="container">
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
                            <a href="{{ url('/backend/campaign-groups/create') }}" class="btn btn-success btn-sm" style="margin-bottom: 5px;" title="Add New Campaign Group">
                                <i class="fa fa-plus" aria-hidden="true"></i> New Campaign Group
                            </a> 
                        </span>
                    </div>

                </div>


                <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
                  <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                      <tr>
                         <tr>
                          <th>Group Name</th><th>Status</th> <th>Actions</th>
                      </tr>
                  </tr>
              </thead>
              <tbody>
                  @foreach($campaign_groups as $item)
                  <tr>
                      <td>{{ ucwords($item->group_name) }}</td>
                      <td> 

                         {{ ($item->status == 1)?"Active":Inactive }}

                     </td>

                     <td>
                        <a href="{{ url('/backend/campaign-groups/' . $item->id . '/msisdns') }}" title="Add Phone Number to this Group">
                            <button class="btn btn-sm btn-success"> Phone Numbers</button>
                        </a>

                        <a href="{{ url('/backend/campaign-groups/' . $item->id . '/edit') }}" title="Edit Campaign Group"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('/backend/campaign-groups' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Campaign Group" onclick="return confirm(&quot;Confirm Delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <a href="{{ url('/backend/campaign-groups/' . $item->id . '/sms') }}" title="Send SMSs"><button class="btn btn-primary btn-sm" style="background: #0F7DC2;"> Send SMSs</button></a>
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
        <p class="no-s"><?php echo date('Y') ?>&copy; DIL.AFRICA</p>
    </div>
</div>
@endsection