@extends('layouts.theme')

@section('content')
    <div class="container">

        <div class="banner">
            <img class="img-fluid" style="height: 30vh;width:100%;" src="{{ asset('/'.$store->banner) }}" alt="">
        </div>
        <h3 class="text m-4">{{ $store->name }} </h3>

        <div class="align-items-right mb-4">
            @if($store->type === "electronics")
                 <a href="{{ route('product.create',$store->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create A Product</a>
            @elseif($store->type === "cars")
                 <a href="{{ route('cars.product.create',$store->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create A Product</a>
            @else
                 <a href="{{ route('product.realestate.create',$store->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create A Product</a>
            @endif
          </div>

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
               <a href="{{ route('products.view',$store->id) }}">
                <div class="card-body" >
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Your Products</div>
                  @if($store->type!="realestate")
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $store->products->count() }}</div>
                  @else
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $store->realestates->count() }}</div>
                  @endif
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
               </a>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Your Rating</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">4.5</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1"></div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"></div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas  fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
    </div>

@endsection
