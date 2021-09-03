@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Campaign {{ $promotion_banner->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/backend/campaign') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/backend/campaign/' . $promotion_banner->id . '/edit') }}" title="Edit Campaign"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('backend/categories' . '/' . $promotion_banner->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Campaign" onclick="return confirm(&quot;Confirm Delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $promotion_banner->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $promotion_banner->promotion_section->name }} </td></tr><tr><th> Active From </th><td> {{ $promotion_banner->active_from }} </td></tr><tr><th> Active To </th><td> {{ $promotion_banner->active_to }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
