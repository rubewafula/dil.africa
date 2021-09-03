@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Shipping_price {{ $shipping_price->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/backend/shipping_prices') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/backend/shipping_prices/' . $shipping_price->id . '/edit') }}" title="Edit Shipping_price"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('backend/shipping_prices' . '/' . $shipping_price->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Shipping_price" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $shipping_price->id }}</td>
                                    </tr>
                                    <tr><th> Zone Id </th><td> {{ $shipping_price->zone_id }} </td></tr><tr><th> Shipping Type Id </th><td> {{ $shipping_price->shipping_type_id }} </td></tr><tr><th> Item Size Id </th><td> {{ $shipping_price->item_size_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
