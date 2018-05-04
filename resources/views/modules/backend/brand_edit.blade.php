@extends('backend::layouts.master')

@section('content')
                <div class="page-breadcrumb" >
                    <ol class="breadcrumb container" style="color:#F89530 !important">
                      <!--   <li><a href="index.html">Home</a></li>
                        <li><a href="#">Tables</a></li>
                        <li class="active">Datatables</li> -->
                    </ol>
                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Edit  %%modelName%% #{{ $%%crudNameSingular%%->%%primaryKey%% }} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                </div>
                                 <a href="{{ url('/%%routeGroup%%%%viewName%%') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                <div class="panel-body">

                                	                        <form method="POST" action="{{ url('/%%routeGroup%%%%viewName%%/' . $%%crudNameSingular%%->%%primaryKey%%) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('%%viewTemplateDir%%.form', ['submitButtonText' => 'Update'])

                        </form>
                                  
                                </div>
                            </div>
                           
                           
                           
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <div class="page-footer">
                    <div class="container">
                        <p class="no-s"><?php echo date('Y') ?>&copy; </p>
                    </div>
                </div>
       

 @endsection