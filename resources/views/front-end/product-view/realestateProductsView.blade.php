
@extends('layouts.front-end.theme')
<!-- Product Section Start -->
@section('section')
<div class="product-section section mt-90 mb-90">
    <div class="container">
        @if(Session::has('message'))
            <div  class="alert alert-danger">
                <h1 >{{ Session::get('message') }}</h1>
            </div>
        @endif


        <div class="row">

            <div class="col-12">

                <div class="row mb-50">
                    <div class="col">

                        <!-- Shop Top Bar Start -->
                        <div class="shop-top-bar">

                            <!-- Product View Mode -->
                            <div class="product-view-mode">
                                <a class="active" href="#" data-target="grid"><i class="fa fa-th"></i></a>
                                <a href="#" data-target="list"><i class="fa fa-list"></i></a>
                            </div>

                            <!-- Product Showing -->
                            <div class="product-showing">
                                <p>Showing</p>
                                <select id="paginate" name="showing" class="nice-select">
                                    @if($qty==8)
                                        <option selected value="8">8</option>

                                    @else
                                        <option  value="8">8</option>
                                    @endif
                                    @if($qty==12)
                                        <option selected value="12">12</option>

                                    @else
                                        <option value="12">12</option>
                                    @endif
                                    @if($qty==16)
                                        <option selected value="16">16</option>

                                    @else
                                        <option value="16">16</option>
                                    @endif
                                    @if($qty==20)
                                        <option selected value="20">20</option>

                                    @else
                                        <option value="20">20</option>
                                    @endif
                                    @if($qty==24)
                                        <option selected value="24">24</option>

                                    @else
                                        <option value="24">24</option>
                                    @endif

                                </select>
                            </div>

                            <!-- Product Short -->
                            <div class="product-short">
                                <p>Short by</p>
                                <select name="sortby" class="nice-select">
                                    <option value="trending">Trending items</option>
                                    <option value="sales">Best sellers</option>
                                    <option value="rating">Best rated</option>
                                    <option value="date">Newest items</option>
                                    <option value="price-asc">Price: low to high</option>
                                    <option value="price-desc">Price: high to low</option>
                                </select>
                            </div>

                            <!-- Product Pages -->
                            <div class="product-pages">
                                <p>Pages 1 of 25</p>
                            </div>

                        </div><!-- Shop Top Bar End -->

                    </div>
                </div>

                <!-- Shop Product Wrap Start -->
                <!-- Shop Product Wrap Start -->
                <div class="shop-product-wrap grid row">

                    <div class="row">
                        @forelse ($products as $product)

                            <!-- Product Start -->
                        <div class="ee-product col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10 ">

                            <!-- Image -->
                            <div class="image">

                                <a href="{{ route('category.realestate.products.show',['category'=>$product->category->id,'sub_cat_name'=>$product->subCategory->name,'sub_cat'=>$product->subCategory->id,'realestate'=>$product->id]) }}" class="img"><img style="height:30vh;max-height: 30vh;max-width: 20vw;" src="{{ asset($product->images[0]??"") }}" alt="Product Image"></a>

                            </div>
                            <br><br><br>

                            <!-- Content -->
                            <div class="content">

                                <!-- Category & Title -->
                                <div class="category-title">

                                    <a  href="{{ route('category.realestate.products.show',['category'=>$product->category->id,'sub_cat_name'=>$product->subCategory->name,'sub_cat'=>$product->subCategory->id,'realestate'=>$product->id]) }}"  class="cat"><h4>{{ $sub_cat_name }}</h4></a>




                                    <h5 class="title"><a  href="{{ route('category.realestate.products.show',['category'=>$product->category->id,'sub_cat_name'=>$product->subCategory->name,'sub_cat'=>$product->subCategory->id,'realestate'=>$product->id]) }}" >{{ $product->name }}</a></h5>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 ">
                                        <i class="fa fa-bed" aria-hidden="true"></i><span class="p-2">{{ $product->bed }}</span>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <i class="fa fa-bath" aria-hidden="true"></i><span class="p-2">{{ $product->bath }}</span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <i  class="fa fa-table" aria-hidden="true"></i><span class="p-2">{{ $product->space_area }}sqft</span>
                                    </div>

                                </div>
                                <!-- Price & Ratting -->
                                <div class="price-ratting">

                                    <h5 class="price">৳{{ $product->price }}</h5>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- Product End -->

                        @empty
                            <h1 class="text text-danger">NO Products ..!!</h1>
                        @endforelse

                    </div>


                </div><!-- Shop Product Wrap End -->

                <div class="row mt-30">
                    <div class="col">

                        <ul class="pagination">

                            {{ $products->links() }}

                        </ul>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div><!-- Feature Product Section End -->


@endsection
