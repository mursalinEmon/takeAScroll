

@extends('layouts.front-end.theme')
@section('section')
<!-- Single Product Section Start -->
<div class="product-section section mt-90 mb-90">
    <div class="container">
        @if(Session::has('message'))
            <div  class="alert alert-danger">
                <h1 >{{ Session::get('message') }}</h1>
            </div>
        @endif
        <div class="row mb-90">

            <div class="col-lg-6 col-12 mb-50">

                <!-- Image -->
                <div class="single-product-image thumb-right">

                    <div class="tab-content">
                       @if($product->category->categoryType=='RealEstate')
                             {{-- product images --}}
                            @forelse($product->images as $key => $value)
                            <div id="single-image-{{ $key}}" class="tab-pane fade show active big-image-slider">
                                <div class="big-image"><img src="{{ asset($value) }}" alt="Big Image"><a href="{{ asset($value) }}"  class="big-image-popup"><i class="fa fa-search-plus"></i></a></div>
                            </div>
                                @empty
                                    <h1 class="text text-danger">No Images Found ...!!1</h1>
                                @endforelse
                       @else
                             {{-- product images --}}
                        @forelse($product->product_pictures as $key => $value)
                        <div id="single-image-{{ $key}}" class="tab-pane fade show active big-image-slider">
                            <div class="big-image"><img src="{{ asset($value) }}" alt="Big Image"><a href="{{ asset($value) }}"  class="big-image-popup"><i class="fa fa-search-plus"></i></a></div>
                        </div>
                            @empty
                                <h1 class="text text-danger">No Images Found ...!!1</h1>
                            @endforelse
                       @endif

                    </div>
                    {{-- thumb nails --}}
                    <div class="thumb-image-slider nav" data-vertical="true">
                    @if($product->category->categoryType=='RealEstate')

                        @forelse($product->images as $key => $value)
                        <a class="thumb-image active" data-toggle="tab" href="#single-image-{{ $key}}"><img src="{{ asset($value) }}" alt="Thumbnail Image"></a>
                        @empty
                        @endforelse
                    @else
                        @forelse($product->product_pictures as $key => $value)
                        <a class="thumb-image active" data-toggle="tab" href="#single-image-{{ $key}}"><img src="{{ asset($value) }}" alt="Thumbnail Image"></a>
                        @empty

                        @endforelse

                    @endif


                    </div>

                </div>

            </div>

            <div class="col-lg-6 col-12 mb-50">

                <!-- Content -->
                <div class="single-product-content">

                    <!-- Category & Title -->
                    <div class="head-content">

                        <div class="category-title">
                            <a href="#" class="cat">{{ $sub_cat_name }}</a>
                            <h5 class="title">{{ $product->name }}</h5>
                        </div>

                        <h5 class="price">৳{{ $product->price - ($product->price * ($product->discount/100)) }}</h5>

                    </div>

                    <div class="single-product-description">

                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>

                        <div class="desc">

                             @if($product->category->categoryType=='RealEstate' )
                                <p> {!! $product->sub_area !!}  ,{!! $product->area !!}  ,{!! $product->district  !!}</p>
                            @else
                                <p> {!!  $product->product_decription !!}</p>
                                 @endif
                        </div>

                        <span class="availability">Availability:
                            @if($product->product_stock > 0)<span>In Stock</span>
                                @elseif($product->category->categoryType)
                                <span>Available</span>
                            @else
                            <span>Out Of Stock</span>
                            @endif
                        </span>

                        <div class="quantity-colors">

                            <div class="quantity">
                                <h5>Quantity</h5>
                                <div class="pro-qty"><input type="text" value="1"></div>
                            </div>
                        </div>

                        <div class="actions">

                           @if($product->category->categoryType=='RealEstate'  )
                           <a href="{{ route('contact.mail',['store_id'=>$product->store_id,'product_id'=>$product->id]) }}"  ><button class="btn btn-success">Contact</button></a>
                           @elseif ($product->category->categoryType=='cars' )
                                <a href="{{ route('contact.mail',['store_id'=>$product->store_id,'product_id'=>$product->id]) }}"  ><button class="btn btn-success">Contact</button></a>
                           @else
                           <a href="{{ route('cart.add',$product->id) }}" data-para2="{{$product->id}}" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>
                           @endif

                           @if($product->category->categoryType=='RealEstate'  )

                           @elseif ($product->category->categoryType=='cars' )

                           @else
                            <div class="wishlist-compare">
                                {{-- <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a> --}}
                                    <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>
                            </div>
                           @endif



                        </div>

                        <div class="tags">



                        </div>

                        <div class="share">

                            <h5>Share: </h5>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-10 col-12 ml-auto mr-auto">

                <ul class="single-product-tab-list nav">
                    <li><a href="#product-description" class="active" data-toggle="tab" >description</a></li>

                    <li><a href="#product-reviews" data-toggle="tab" >reviews</a></li>
                </ul>

                <div class="single-product-tab-content tab-content">
                    <div class="tab-pane fade show active" id="product-description">

                        <div class="row">
                            <div class="single-product-description-content col-lg-8 col-12">
                              @if($product->category->categoryType=='RealEstate')
                              <div class="row">
                                <div class="col-md-3 col-sm-3 ">
                                    <i class="fa fa-bed" aria-hidden="true"></i><span class="p-2">Bed: {{ $product->bed }}</span>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <i class="fa fa-bath" aria-hidden="true"></i><span class="p-2">Bath: {{ $product->bath }}</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <i  class="fa fa-table" aria-hidden="true"></i><span class="p-2">Area: {{ $product->space_area }}sqft</span>
                                </div>

                            </div>
                              <h3>Location:</h3>
                                    <h4> {!! $product->sub_area !!}  ,{!! $product->area !!}  ,{!! $product->district  !!} </h4>
                                     {!! $product->description !!}
                              @else
                                <p>
                                    {!!  $product->product_decription !!}
                                </p>
                              @endif
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="product-reviews">

                        <div class="product-ratting-wrap">
							<div class="pro-avg-ratting">
								<h4>4.5 <span>(Overall)</span></h4>
								<span>Based on 9 Comments</span>
							</div>
							<div class="ratting-list">
								<div class="sin-list float-left">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<span>(5)</span>
								</div>
								<div class="sin-list float-left">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
									<span>(3)</span>
								</div>
								<div class="sin-list float-left">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<span>(1)</span>
								</div>
								<div class="sin-list float-left">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<span>(0)</span>
								</div>
								<div class="sin-list float-left">
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<i class="fa fa-star-o"></i>
									<span>(0)</span>
								</div>
							</div>
							<div class="rattings-wrapper">

								<div class="sin-rattings">
									<div class="ratting-author">
										<h3>Cristopher Lee</h3>
                                        <div class="ratting-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span>(5)</span>
                                        </div>
									</div>
									<p>enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci veli</p>
								</div>

								<div class="sin-rattings">
									<div class="ratting-author">
										<h3>Nirob Khan</h3>
                                        <div class="ratting-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span>(5)</span>
                                        </div>
									</div>
									<p>enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci veli</p>
								</div>

								<div class="sin-rattings">
									<div class="ratting-author">
										<h3>MD.ZENAUL ISLAM</h3>
                                        <div class="ratting-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span>(5)</span>
                                        </div>
									</div>
									<p>enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia res eos qui ratione voluptatem sequi Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci veli</p>
								</div>

							</div>
							<div class="ratting-form-wrapper fix">
								<h3>Add your Comments</h3>
								<form action="#">
								    <div class="ratting-form row">
										<div class="col-12 mb-15">
											<h5>Rating:</h5>
											<div class="ratting-star fix">
												<i class="fa fa-star-o"></i>
												<i class="fa fa-star-o"></i>
												<i class="fa fa-star-o"></i>
												<i class="fa fa-star-o"></i>
												<i class="fa fa-star-o"></i>
											</div>
										</div>
										<div class="col-md-6 col-12 mb-15">
                                            <label for="name">Name:</label>
                                            <input id="name" placeholder="Name" type="text">
										</div>
										<div class="col-md-6 col-12 mb-15">
                                            <label for="email">Email:</label>
                                            <input id="email" placeholder="Email" type="text">
										</div>
										<div class="col-12 mb-15">
											<label for="your-review">Your Review:</label>
											<textarea name="review" id="your-review" placeholder="Write a review"></textarea>
										</div>
										<div class="col-12">
											<input value="add review" type="submit">
										</div>
								    </div>
								</form>
							</div>
						</div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div><!-- Single Product Section End -->

{{--<!-- Related Product Section Start -->--}}
{{--<div class="product-section section mb-70">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}

{{--            <!-- Section Title Start -->--}}
{{--            <div class="col-12 mb-40">--}}
{{--                <div class="section-title-one" data-title="RELATED PRODUCT"><h1>RELATED PRODUCT</h1></div>--}}
{{--            </div><!-- Section Title End -->--}}

{{--            <!-- Product Tab Content Start -->--}}
{{--            <div class="col-12">--}}

{{--                <!-- Product Slider Wrap Start -->--}}
{{--                <div class="product-slider-wrap product-slider-arrow-one">--}}
{{--                    <!-- Product Slider Start -->--}}
{{--                    <div class="product-slider product-slider-4">--}}

{{--                        <div class="col pb-20 pt-10">--}}
{{--                            <!-- Product Start -->--}}
{{--                            <div class="ee-product">--}}

{{--                                <!-- Image -->--}}
{{--                                <div class="image">--}}

{{--                                    <a href="single-product.html" class="img"><img src="assets/images/product/product-1.png" alt="Product Image"></a>--}}

{{--                                    <div class="wishlist-compare">--}}
{{--                                        <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a>--}}
{{--                                        <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>--}}
{{--                                    </div>--}}

{{--                                    <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>--}}

{{--                                </div>--}}

{{--                                <!-- Content -->--}}
{{--                                <div class="content">--}}

{{--                                    <!-- Category & Title -->--}}
{{--                                    <div class="category-title">--}}

{{--                                        <a href="#" class="cat">Laptop</a>--}}
{{--                                        <h5 class="title"><a href="single-product.html">Zeon Zen 4 Pro</a></h5>--}}

{{--                                    </div>--}}

{{--                                    <!-- Price & Ratting -->--}}
{{--                                    <div class="price-ratting">--}}

{{--                                        <h5 class="price">$295.00</h5>--}}
{{--                                        <div class="ratting">--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star-half-o"></i>--}}
{{--                                            <i class="fa fa-star-o"></i>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div><!-- Product End -->--}}
{{--                        </div>--}}

{{--                        <div class="col pb-20 pt-10">--}}
{{--                            <!-- Product Start -->--}}
{{--                            <div class="ee-product">--}}

{{--                                <!-- Image -->--}}
{{--                                <div class="image">--}}

{{--                                    <span class="label sale">sale</span>--}}

{{--                                    <a href="single-product.html" class="img"><img src="assets/images/product/product-2.png" alt="Product Image"></a>--}}

{{--                                    <div class="wishlist-compare">--}}
{{--                                        <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a>--}}
{{--                                        <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>--}}
{{--                                    </div>--}}

{{--                                    <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>--}}

{{--                                </div>--}}

{{--                                <!-- Content -->--}}
{{--                                <div class="content">--}}

{{--                                    <!-- Category & Title -->--}}
{{--                                    <div class="category-title">--}}

{{--                                        <a href="#" class="cat">Drone</a>--}}
{{--                                        <h5 class="title"><a href="single-product.html">Aquet Drone D 420</a></h5>--}}

{{--                                    </div>--}}

{{--                                    <!-- Price & Ratting -->--}}
{{--                                    <div class="price-ratting">--}}

{{--                                        <h5 class="price"><span class="old">$350</span>$275.00</h5>--}}
{{--                                        <div class="ratting">--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star-half-o"></i>--}}
{{--                                            <i class="fa fa-star-o"></i>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div><!-- Product End -->--}}
{{--                        </div>--}}

{{--                        <div class="col pb-20 pt-10">--}}
{{--                            <!-- Product Start -->--}}
{{--                            <div class="ee-product">--}}

{{--                                <!-- Image -->--}}
{{--                                <div class="image">--}}

{{--                                    <a href="single-product.html" class="img"><img src="assets/images/product/product-3.png" alt="Product Image"></a>--}}

{{--                                    <div class="wishlist-compare">--}}
{{--                                        <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a>--}}
{{--                                        <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>--}}
{{--                                    </div>--}}

{{--                                    <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>--}}

{{--                                </div>--}}

{{--                                <!-- Content -->--}}
{{--                                <div class="content">--}}

{{--                                    <!-- Category & Title -->--}}
{{--                                    <div class="category-title">--}}

{{--                                        <a href="#" class="cat">Games</a>--}}
{{--                                        <h5 class="title"><a href="single-product.html">Game Station X 22</a></h5>--}}

{{--                                    </div>--}}

{{--                                    <!-- Price & Ratting -->--}}
{{--                                    <div class="price-ratting">--}}

{{--                                        <h5 class="price">$295.00</h5>--}}
{{--                                        <div class="ratting">--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star-half-o"></i>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div><!-- Product End -->--}}
{{--                        </div>--}}

{{--                        <div class="col pb-20 pt-10">--}}
{{--                            <!-- Product Start -->--}}
{{--                            <div class="ee-product">--}}

{{--                                <!-- Image -->--}}
{{--                                <div class="image">--}}

{{--                                    <a href="single-product.html" class="img"><img src="assets/images/product/product-4.png" alt="Product Image"></a>--}}

{{--                                    <div class="wishlist-compare">--}}
{{--                                        <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a>--}}
{{--                                        <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>--}}
{{--                                    </div>--}}

{{--                                    <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>--}}

{{--                                </div>--}}

{{--                                <!-- Content -->--}}
{{--                                <div class="content">--}}

{{--                                    <!-- Category & Title -->--}}
{{--                                    <div class="category-title">--}}

{{--                                        <a href="#" class="cat">Accessories</a>--}}
{{--                                        <h5 class="title"><a href="single-product.html">Roxxe Headphone Z 75</a></h5>--}}

{{--                                    </div>--}}

{{--                                    <!-- Price & Ratting -->--}}
{{--                                    <div class="price-ratting">--}}

{{--                                        <h5 class="price">$110.00</h5>--}}
{{--                                        <div class="ratting">--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div><!-- Product End -->--}}
{{--                        </div>--}}

{{--                        <div class="col pb-20 pt-10">--}}
{{--                            <!-- Product Start -->--}}
{{--                            <div class="ee-product">--}}

{{--                                <!-- Image -->--}}
{{--                                <div class="image">--}}

{{--                                    <a href="single-product.html" class="img"><img src="assets/images/product/product-5.png" alt="Product Image"></a>--}}

{{--                                    <div class="wishlist-compare">--}}
{{--                                        <a href="#" data-tooltip="Compare"><i class="ti-control-shuffle"></i></a>--}}
{{--                                        <a href="#" data-tooltip="Wishlist"><i class="ti-heart"></i></a>--}}
{{--                                    </div>--}}

{{--                                    <a href="#" class="add-to-cart"><i class="ti-shopping-cart"></i><span>ADD TO CART</span></a>--}}

{{--                                </div>--}}

{{--                                <!-- Content -->--}}
{{--                                <div class="content">--}}

{{--                                    <!-- Category & Title -->--}}
{{--                                    <div class="category-title">--}}

{{--                                        <a href="#" class="cat">Camera</a>--}}
{{--                                        <h5 class="title"><a href="single-product.html">Mony Handycam Z 105</a></h5>--}}

{{--                                    </div>--}}

{{--                                    <!-- Price & Ratting -->--}}
{{--                                    <div class="price-ratting">--}}

{{--                                        <h5 class="price">$110.00</h5>--}}
{{--                                        <div class="ratting">--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star"></i>--}}
{{--                                            <i class="fa fa-star-half-o"></i>--}}
{{--                                            <i class="fa fa-star-o"></i>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div><!-- Product End -->--}}
{{--                        </div>--}}

{{--                    </div><!-- Product Slider End -->--}}
{{--                </div><!-- Product Slider Wrap End -->--}}

{{--            </div><!-- Product Tab Content End -->--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div><!-- Related Product Section End -->--}}

{{--<!-- Brands Section Start -->--}}
{{--<div class="brands-section section mb-90">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}

{{--            <!-- Brand Slider Start -->--}}
{{--            <div class="brand-slider col">--}}
{{--                <div class="brand-item col"><img src="assets/images/brands/brand-1.png" alt="Brands"></div>--}}
{{--                <div class="brand-item col"><img src="assets/images/brands/brand-2.png" alt="Brands"></div>--}}
{{--                <div class="brand-item col"><img src="assets/images/brands/brand-3.png" alt="Brands"></div>--}}
{{--                <div class="brand-item col"><img src="assets/images/brands/brand-4.png" alt="Brands"></div>--}}
{{--                <div class="brand-item col"><img src="assets/images/brands/brand-5.png" alt="Brands"></div>--}}
{{--            </div><!-- Brand Slider End -->--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div><!-- Brands Section End -->--}}

@endsection
