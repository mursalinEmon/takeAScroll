@extends('layouts.theme')

@section('content')
    <div class="container">


        <create-product :store="{{ $store }}"></create-product>
          <!-- Content Row -->
    </div>
@endsection
