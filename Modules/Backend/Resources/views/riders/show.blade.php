@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Rider {{ $rider->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/backend/riders') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/backend/riders/' . $rider->id . '/edit') }}" title="Edit Rider"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('backend/riders' . '/' . $rider->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Rider" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Name</th><td> {{ $rider->name }} </td></tr>
                                    <tr><th> Phone Number </th><td> {{ $rider->phone }} </td></tr>
                                    <tr><th> Email Address </th><td> {{ $rider->email }} </td></tr>
                                    <tr><th> Gender </th><td> {{ $rider->gender }} </td></tr>
                                    <tr><th> ID Number </th><td> {{ $rider->id_number }} </td></tr>
                                    <tr><th> Vehicle </th><td> {{ $rider->vehicle->registration_no }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
