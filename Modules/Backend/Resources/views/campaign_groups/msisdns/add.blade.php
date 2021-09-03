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

            <a href="{{ url('/backend/campaign-groups/'.$campaign_group->id.'/msisdns') }}" title="Back">
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

              <div  class="col-md-4 col-sm-12">
                
                <div class="page-title">
                  <div class="container" class="blue-text" style="padding: 10px;font-size: 18px;text-align: center;border-bottom: 1px solid #ddd;">
                    Add Numbers to <span style="color: #0F7DC2;">{{ $campaign_group->group_name }} </span>
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
            
            <div class="col-md-6">

              <form method="POST" action="{{url('/backend/campaign-groups/msisdns/add-msisdn')}}">
                {{ csrf_field() }}
                <input type="hidden" name="campaign_group_id" value="{{ $campaign_group->id }}"/>
                <div class="form-group {{ $errors->has('msisdn') ? 'has-error' : ''}}">
                  <div class="col-md-3">
                    {!! Form::label('msisdn', 'Phone No.', ['class' => 'control-label']) !!}
                  </div>
                    <div class="col-md-5">
                        {!! Form::text('msisdn', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control', 'style' => 'margin-bottom: 10px;margin-left: -25px;']) !!}
                        {!! $errors->first('msisdn', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Save', ['class' => 'btn btn-primary', 'style' => 'background:#0F7DC2;margin-left: -50px;']) !!}
                    </div>
                </div>

              </form>
            </div>
            <div class="col-md-5">
              <form method="POST" action="{{url('/backend/campaign-groups/msisdns/upload-csv')}}" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                <input type="hidden" name="campaign_group_id" value="{{ $campaign_group->id }}"/>
                <div class="col-md-12">
                  <label>Upload CSV (Each Number On Each Line - No Header)</label>
                </div>
                <div class="col-md-8">
                  
                     <input type="file" name="msisdn_csv"/>
                </div>
                <div class="col-md-4">
                    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Upload', ['class' => 'btn btn-primary', 'style' => 'background:#0F7DC2;margin-left: -50px;']) !!}
                </div>
              </form>
            </div>

            <div class="col-md-1">
              
              <a href="{{ url('/backend/campaign-groups/' . $campaign_group->id . '/sms') }}" title="Send SMSs"><button class="btn btn-primary btn-sm" style="margin-top: 22px;margin-left: -27px !important;"> Send SMSs</button></a>
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