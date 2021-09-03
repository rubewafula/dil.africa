@extends('messages::layouts.message_master')

@section('content')
    @include('messages::messenger.partials.flash')

    @each('messages::messenger.partials.thread', $threads, 'thread', 'messages::messenger.partials.no-threads')
@stop
