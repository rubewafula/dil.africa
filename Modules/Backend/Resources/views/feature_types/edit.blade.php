@extends('backend::layouts.master')

@section('content')

<script type="text/javascript">
    
      $(document).ready(function(){

        $('#level_2_category').select2();

      });
   </script>
                <div class="page-breadcrumb" >
                   {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Edit  Feature_type #{{ $feature_type->id }} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                </div>
                                 <a href="{{ url('/backend/feature_types') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                <div class="panel-body">

                                                            <form method="POST" action="{{ url('/backend/feature_types/' . $feature_type->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('backend::feature_types.form', ['submitButtonText' => 'Update'])

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