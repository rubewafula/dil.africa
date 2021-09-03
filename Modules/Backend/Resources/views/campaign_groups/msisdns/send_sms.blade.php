    @extends('backend::layouts.master')

    @section('content')

    <script type="text/javascript">
     
     $(document).ready(function(){

       var text_length = 0;
       $("#characters_remaining").hide();

       $("#message_box").focus(function(){

          $("#characters_remaining").show();
       });
       $("#message_box").keyup(function(){

          text_length = $("#message_box").val().length;
          if(text_length < 150){

            $("#characters_remaining").html('<span style="font-weight: bold;color: #0F7DC2;">'+(160 - text_length)+' </span>Characters Remaining');
          }else if(text_length >= 150 && text_length <= 160){

            $("#characters_remaining").html('<span style="font-weight: bold;color: #CC0000;">'+(160 - text_length)+' </span>Characters Remaining');
          }else if(text_length > 160){

            $("#message_box").val($("#message_box").val().substring(0, 160));
          }
          
       });
     })
   </script>

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

           <div class="table-responsive" style="overflow-x: unset !important;">

            <div  class="row">

              <div class="col-md-12" style="padding: 10px;font-size: 18px;text-align: center;border-bottom: 1px solid #ddd;">
                
                  <div class=" blue-text">
                    <span style="color: #CC0000;text-transform: uppercase;"> Send SMS to All in this Group </span>
                  </div>
              </div>

            </div>

            <div class="row">
            
            <div class="col-md-8 col-md-offset-2">

              <form method="POST" action="{{url('/backend/campaign-groups/msisdns/save-sms')}}">
                {{ csrf_field() }}
                <input type="hidden" name="campaign_group_id" value="{{ $campaign_group->id }}"/>
                
                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                    
                    <div class="col-md-7 col-md-offset-1">
                        {!! Form::textarea('message', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control', 'style' => 'resize:none;', 'placeholder' => 'SMS Message (Max is 160 Characters)', 'id' =>'message_box']) !!}
                        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-md-4" id="characters_remaining">
                      <span style="font-weight: bold;color: #0F7DC2;">160 </span>Characters Remaining
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-1 col-md-4">
                        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Send Message', ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px;background:#0F7DC2;']) !!}
                    </div>
                </div>
              </div>

              </form>
            </div>

            </div>

            @if(isset($outbox_messages))
            <table id="crud" class="display table" style="width: 100%; cellspacing: 0;">
              <thead style="background: #ffa200;color:#fff;opacity: 0.7">
                <tr>
                  <th>Phone Number</th> 
                  <th>Message</th> 
                  <th>Status</th>    
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                @foreach($outbox_messages as $item)
                <tr>
                  <td>{{ $item->msisdn }}</td>
                  <td>{{ $item->message }}</td>
                  <td>{{ ($item->status == 0)?"Scheduled":"Sent to SMS Gateway" }} </td>
                  <td> 
                    {{ $item->created_at }}
                  </td>
                </tr>
                @endforeach   

              </tbody>
            </table>  
            @endif

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