@extends('layouts.app')
@section( 'content')
<div class="conatiner">
    <chat-component :user="{{ auth()->user() }}"></chat-component>
</div>
@endsection
