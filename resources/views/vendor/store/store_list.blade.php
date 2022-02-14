@extends('layouts.theme')
@section('content')
<div class="container">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
      @endif
    @forelse($stores as $store)
    <div class="card m-3" style="width: 25rem;">
        <img class="card-img-top" src="{{ asset('/'.$store->banner) }}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">{{ $store->name }}</h5>
          <p class="card-text">{{ $store->description }}</p>
            <div class="d-flex justify-content-center align-item-center">
                <a href="{{ route('stores.show',$store->id) }}" class="btn btn-success">Browser</a>
                <a href="{{ route('stores.edit',$store->id) }}" class="btn btn-warning ml-2 mr-2">Edit</a>
                <form action="{{ route('stores.destroy',$store->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button  type="submit" class="btn btn-danger" >Delete</button>
                </form>

            </div>
        </div>
      </div>
    @empty
        <h1 class="text-danger">NO Stores For You</h1>
    @endforelse
</div>
@endsection
