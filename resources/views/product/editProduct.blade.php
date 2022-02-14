@extends('layouts.theme')
@section('content')
<div class="container">

    {{-- @forelse($product->product_pictures as $picture)
       <img src="{{ asset($picture) }}" alt="product-photo">
    @empty

    @endforelse --}}
    {{-- {{ dd($category_name) }} --}}
    <edit-product :product="{{ $product}}" category_name={{ $category_name }}></edit-product>

</div>
@endsection
