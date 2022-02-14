@extends('layouts.theme')

@section('content')
    <div class="container">

            <div class="row">
                <div id="mask" style="height:100vh;width:100vw;z-index:1000;background-color:rgba(189, 189, 189, 0.13);display:none;"><h1 class="text text-danger text-center">
                    Processing Please Wait..!!</h1> </div>
                <div class="col-md-8" class="text-right"><h4 class="text-right">Run Product Count Update Procedure</h4></div>
                <div class="col-md-2"><a onclick="mask()" href="{{ route('admin.update-list') }}" class="btn btn-success text-center">GO</a></div>

            </div>
<br>
            <div class="row">
                <div id="mask" style="height:100vh;width:100vw;z-index:1000;background-color:rgba(189, 189, 189, 0.13);display:none;"><h1 class="text text-danger text-center">
                    Processing Please Wait..!!</h1> </div>
                <div class="col-md-8" class="text-right"><h4 class="text-right">Run Recommendation Generation Procedure</h4></div>
                <div class="col-md-2"><a onclick="mask()" href="{{ route('admin.update-recommendation') }}" class="btn btn-success text-center">GO</a></div>

            </div>


    </div>
@endsection
