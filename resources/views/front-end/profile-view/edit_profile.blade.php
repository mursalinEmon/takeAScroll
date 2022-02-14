@extends('layouts.theme')

@section('content')
    <div class="container">


        <edit-profile :user_data="{{ $userData }}"></edit-profile>
          <!-- Content Row -->
    </div>
@endsection
