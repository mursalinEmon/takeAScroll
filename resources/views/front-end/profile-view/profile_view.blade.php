@extends('layouts.theme')

@section('content')
    <div class="container">


        <view-profile :user_data="{{ $userData }}"></view-profile>
          <!-- Content Row -->
    </div>
@endsection
