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
        @forelse($products as $product)
        <div class="card m-4">
            <div class="card-header">Name:{{ $product->name }} <span class="ml-2 mr-2"></span>   ID:{{ $product->id }}</div>
                <div class="card-body">
                    <p class="text"><i>Brand</i>: {{ $product->brand_name }}</p>
                    <p class="text"><i>Price</i>: {{ $product->price }} </p>
                    <p class="text-muted"> <i>Description:</i> {!! $product->product_decription !!} </p>
                    <div class="d-flex flex-row-reverse ">
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning "> Edit </a>
                        <form action="{{ route('product.delete',$product->id) }}" method="POST">
                            @csrf
                            @method('delete')
                        <button class="btn btn-danger mr-2">delete</button>
                        </form>
                    </div>
                </div>
        </div>

    @empty
    <h1 class="text-danger">No Products to show...!!</h1>
    @endforelse

       <div class="d-flex flex-row-reverse mr-4 p-4">
        {{ $products->links() }}
       </div>


  </div>

@endsection
