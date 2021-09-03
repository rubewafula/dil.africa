@extends('backend::layouts.master')
@section('content')

           <div class="page-breadcrumb" >
                    {{ Breadcrumbs::render() }}

                </div>
                <div class="page-title">
                    <div class="container">
                        <h3> Edit  #{{$warehouse->name}} </h3>
                    </div>
                </div>
                <div id="main-wrapper" class="container" >
                    <div class="row">
                        <div class="col-md-12">
                        	     <div class="panel-heading clearfix"> </div>

                            <div class="panel panel-white">
                            	       <div class="panel-body">
                            	       	 <a href="{{ url('/backend/warehouses') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($warehouse, [
                            'method' => 'PATCH',
                            'url' => ['/backend/warehouses', $warehouse->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('backend::warehouses.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                                	
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
              

@endsection