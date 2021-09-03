@extends('messages::layouts.message_master')

@section('content')
            <div class="panel panel-white" style="background:#fff">

    <div class="col-md-12">
        <h1>{{ $thread->subject }}</h1>
        @each('messages::messenger.partials.messages', $thread->messages, 'message')

        @include('messages::messenger.partials.form-message')
    </div>
</div>
@stop
