@extends('layouts.theme')

@section('content')

<div class="container" >
    <edit-store :store="{{ $store }}"></edit-store>
</div>

@endsection
