@extends('backend::layouts.master')

@section('content')

<script type="text/javascript">
    
    $(document).ready(function(){

    $("#level").change(function(){

      populate_depends();

    });

    $('#active_from').datepicker({
        format: 'yyyy-mm-dd'       
     });

     $('#active_to').datepicker({
        format: 'yyyy-mm-dd'       
     });

    function  check_popular()
    {

      var  level = $("#level").val();

      if(level =='1')
      {
        $(".popular").show();

      } else{

        $(".popular").hide();

      }

    }


    function populate_depends()
    {

      var  level = $("#level").val();

      $.ajax({
        url:"{{url('backend/filter_categories')}}",
        type:"GET",
        data:{level:level},
        success:function(data){

          $("#depends_on").empty();
          if(data.length > 0)
          {
            $.each(data,function(index){

            $("#depends_on").append('<option  value="'+ data[index].id +'"> '+ data[index].name +'</option');  
                     
            });
     
         } else{
                  $("#depends_on").append('<option  value="">Not  Applicable</option');  

             }
          }

      });

    }

  });

</script>
<div class="page-breadcrumb" >
    {{ Breadcrumbs::render() }}

</div>
<div class="page-title">
    <div class="container">
        <h3>  New Campaign </h3>
    </div>
</div>
<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                </div>
                 <a href="{{ url('backend/campaign') }}" title="Back">
                  <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <div class="panel-body">

                                            
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ url('backend/campaign') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <?php $campaign = new \App\Campaign; ?>

            @include ('backend::campaign.form')

        </form>
                  
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