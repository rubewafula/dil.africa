@extends('accounts::layouts.master')

@section('content')

	<div class="container" style="text-align: center;margin-top: 10px;background: #fff;">

	     <h3 style="border-bottom: 1px solid #ddd;padding-bottom: 10px;"> Welcome {{Auth::user()->name}} to  Accounts Management </h3>

	    <div>
	    	 
	    	 <img src="{{url('/assets/images/key-account-mgmt.png')}}"/>
	    </div>

	</div>
@stop
