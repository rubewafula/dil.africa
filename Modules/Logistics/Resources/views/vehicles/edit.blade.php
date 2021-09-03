 @extends('logistics::layouts.logistics_master')

@section('content')
<div class="page-breadcrumb" >
   {{ Breadcrumbs::render() }}

</div>
<div class="page-title">
    <div class="container">
        <h3> Edit  Vehicle #{{ $vehicle->id }} </h3>
    </div>
</div>
<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                </div>
                 <a href="{{ url('/logistics/vehicles') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <div class="panel-body">

                <form method="POST" action="{{ url('/logistics/vehicles/' . $vehicle->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('logistics::vehicles.form', ['submitButtonText' => 'Update'])

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