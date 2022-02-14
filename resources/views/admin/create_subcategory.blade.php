@extends('layouts.theme')

@section('content')
    <div class="container">
        <create-sub-category :category="{{ $category }}"></create-sub-category>
    </div>
@endsection
