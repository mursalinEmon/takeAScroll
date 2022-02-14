<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Take a Scroll</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href={{ asset("css/bootstrap.min.css") }}>

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href={{  asset("css/icon-font.min.css") }}>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href={{ asset("css/plugins.css") }}>

    <!-- Main Style CSS -->
    <link rel="stylesheet" href={{ asset("css/style.css") }}>

    <!-- Modernizer JS -->
    <script src={{ asset("js/vendor/modernizr-2.8.3.min.js") }}></script>

</head>

<body>
<div id="app">

        <chat-head></chat-head>

</div>
<!-- Ft -->
    <div class="header-section section">

        <!-- Header Top Start -->
        <div class="header-top header-top-one header-top-border pt-10 pb-10">
            <div class="container">
                <div class="row align-items-center justify-content-between">

                    <div class="col mt-10 mb-10">
                        <!-- Header Links Start -->
                        @if(!auth()->user())

                        @elseif(auth()->user()->type == "customer")
                        <div class="header-links">
                            <a href="{{ route('customer.orders') }}"><img src="{{ asset('assets/images/icons/car.png') }}" alt="Car Icon"> <span>Track your order</span></a>
                            {{-- <a href="store.html"><img src="{{ asset('assets/images/icons/marker.png') }}" alt="Car Icon"> <span>Locate Store</span></a> --}}
                        </div>
                        @else<!-- Header Links End -->
                        @endif
                    </div>

                    <div class="col order-12 order-xs-12 order-lg-2 mt-10 mb-10">
                        <!-- Header Advance Search Start -->
                        <div class="header-advance-search">


                                <div class="input"><input id="searchvalue" onkeyup="randsearch()" type="text" placeholder="Search your product"></div>
                                <div class="select">
                                    <select id="serachoption"  class="nice-select">
                                        <option value="all">All Categories</option>
{{--                                             @forelse ($categories as $cat)--}}
{{--                                            <option value="{{$cat->id}}" >{{$cat->name}}</option>--}}
{{--                                            @endforeach--}}
                                        @forelse ($categories as $cat)
                                                    @forelse ($cat->subCategories as $sub_cat)
                                                    <option value="{{$cat->id}},{{$sub_cat->id}}" >{{$sub_cat->name}}</option>
                                                    @empty
                                                        <h1 class="text text-danger"> NO Data Found...!!</h1>
                                                    @endforelse

                                        @empty
                                            <h1 class="text text-danger"> NO Data Found...!!</h1>
                                        @endforelse

                                    </select>
                                </div>
                                <div class="submit"><button><i  id="searchbtn" onclick="search()" class="icofont icofont-search-alt-1"></i></button></div>
                            <div class="row" style="z-index: 2; position: absolute;top: 10vh;background-color: white;">
                                <div class="col-md-12" id="resarea" style="max-height:70vh;overflow-y:scroll;"></div>
                            </div>

                        </div><!-- Header Advance Search End -->

                    </div>

                    <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                        <!-- Header Account Links Start -->
                        <div class="header-account-links">
                            @if(!auth()->user())
                            <a href="{{ route('login')}}"><i class="icofont icofont-login d-none"></i> <span>my account</span></a>
                            @else
                                @if(auth()->user()->type === 'vendor')
                                <a href="{{ route('dashboard')}}"><i class="icofont icofont-login d-none"></i> <span>my account</span></a>
                                @else
                                <a href="{{ route('customer_profile.show')}}"><i class="icofont icofont-login d-none"></i> <span>my account</span></a>
                                @endif

                            @endif
                            @if(!auth()->user())
                            <a href="{{ route('login')}}"><i class="icofont icofont-login d-none"></i> <span>Login</span></a>
                            @else
                                @if(auth()->user()->type === 'vendor')
                                <a href="{{ route('dashboard')}}"><i class="icofont icofont-login d-none"></i> <span>Dashboard</span></a>
                                @elseif (auth()->user()->type==='admin')
                                <a href="{{ route('admin.dashboard')}}"><i class="icofont icofont-login d-none"></i> <span>Dashboard</span></a>
                                @else
                                <a href="{{ route('customer.dashboard')}}"><i class="icofont icofont-login d-none"></i> <span>Dashboard</span></a>
                                @endif

                            @endif
                        </div><!-- Header Account Links End -->
                    </div>

                </div>
            </div>
        </div><!-- Header Top End -->

        <!-- Header Bottom Start -->
        <div class="header-bottom header-bottom-one header-sticky">
            <div class="container">
                <div class="row align-items-center justify-content-between">

                    <div class="col mt-15 mb-15">
                        <!-- Logo Start -->
                        <div class="header-logo">
                            <a href="{{ url('/') }}">
                                <h1>Take A Scroll</h1>
                                {{-- <img src="assets/images/logo.png" alt="E&E - Electronics eCommerce Bootstrap4 HTML Template">
                                <img class="theme-dark" src="assets/images/logo-light.png" alt="E&E - Electronics eCommerce Bootstrap4 HTML Template"> --}}
                            </a>
                        </div><!-- Logo End -->
                    </div>

                    <div class="col order-12 order-lg-2 order-xl-2 d-none d-lg-block">
                        <!-- Main Menu Start -->
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="active"><a href="{{ url('/') }}">HOME</a></li>
                                    <li class="menu-item-has-children"><a href="javascript:void(0)">Shops</a>
                                    <ul class="mega-menu three-column ">
                                            <li>
                                            <ul>
                                                    <li><strong>Electronics</strong></li>
                                                    @forelse($Electronics as $shop)
                                                        <li style="margin-left: -1rem;"><a  href="{{ route('customer.shop.show',$shop->id) }}">{{ $shop->name }}</a>
                                                        </li>
                                                    @empty
                                                        <h1 class="text text-danger">No Shops available...!!</h1>
                                                    @endforelse
                                            </ul>
                                            </li>
                                            <li>
                                                <ul>
                                                    <li><strong>Realestate</strong></li>
                                                    @forelse($Realestate as $shop)
                                                        <li style="margin-left: -1rem;"><a  href="{{ route('customer.shop.show',$shop->id) }}">{{ $shop->name }}</a>
                                                        </li>
                                                    @empty
                                                        <li class="text text-danger">No Shops available...!!</li>
                                                    @endforelse
                                                </ul>
                                            </li>
                                            <li>
                                            <ul>
                                                    <li><strong>Cars</strong></li>
                                                    @forelse($Cars as $shop)
                                                        <li style="margin-left: -1rem;"><a href="{{ route('customer.shop.show',$shop->id) }}">{{ $shop->name }}</a>
                                                        </li>
                                                    @empty
                                                        <li class="text text-danger">No Shops available...!!</li>
                                                    @endforelse
                                            </ul>
                                                {{-- <li class="menu-item-has-children"><a href="single-product.html">Single Product</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="single-product.html">Single Product 1</a></li>
                                                    </ul>
                                                </li> --}}
                                            </li>
                                    </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="javascript:void(0)">Categories</a>
                                        <ul class="mega-menu three-column">
                                            @forelse ($categories as $cat)
                                                <li><a href="#">{{ $cat->name }}</a>
                                                    <ul>
                                                        @forelse ($cat->subCategories as $sub_cat)
                                                            <li><a href="{{ route('category.products.index',['category'=>$cat->id,'sub_cat_name'=>$sub_cat->name,'sub_cat'=>$sub_cat->id,'qty'=>8]) }}">{{ $sub_cat->name }}</a></li>
                                                        @empty
                                                            <h1 class="text text-danger"> NO Data Found...!!</h1>
                                                        @endforelse
                                                    </ul>
                                                </li>
                                            @empty
                                                <h1 class="text text-danger"> NO Data Found...!!</h1>
                                            @endforelse

                                        </ul>
                                    </li>
                                    <li><a href="{{ route('contact')}}">CONTACT</a></li>
                                </ul>
                            </nav>
                        </div><!-- Main Menu End -->
                    </div>

                    <div class="col order-2 order-lg-12 order-xl-12">
                        <!-- Header Shop Links Start -->
                        <div class="header-shop-links">

                            <!-- Compare -->
                            {{-- <a href="compare.html" class="header-compare"><i class="ti-control-shuffle"></i></a> --}}
                            <!-- Wishlist -->
                            <a href="wishlist.html" class="header-wishlist"><i class="ti-heart"></i> <span class="number">3</span></a>
                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" class=""><i class="ti-shopping-cart"></i> <span class="number" id="cartcount">{{ $cart }}</span></a>

                        </div><!-- Header Shop Links End -->
                    </div>

                    <!-- Mobile Menu -->
                    <div class="mobile-menu order-12 d-block d-lg-none col"></div>

                </div>
            </div>
        </div><!-- Header Bottom End -->

        <!-- Header Category Start -->
        <div class="header-category-section">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <!-- Header Category -->
                        <div class="header-category">

                            <!-- Category Toggle Wrap -->
                            <div class="category-toggle-wrap d-block d-lg-none">
                                <!-- Category Toggle -->
                                <button class="category-toggle">Categories <i class="ti-menu"></i></button>
                            </div>

                            <!-- Category Menu -->
                            <nav class="category-menu">
                                <ul style="border-bottom:1px solid black;">
                                    {{-- <li><a href="category-1.html">Tv & Audio System</a></li>
                                    <li><a href="category-2.html">Computer & Laptop</a></li>
                                    <li><a href="category-3.html">Phones & Tablets</a></li>
                                    <li><a href="category-1.html">Home Appliances</a></li>
                                    <li><a href="category-2.html">Kitchen appliances</a></li>
                                    <li><a href="category-3.html">Accessories</a></li> --}}
                                </ul>
                            </nav>

                        </div>

                    </div>
                </div>
            </div>
        </div><!-- Header Category End -->

    </div>
<!-- Header Section End -->


    @yield('section')
    @yield('content')







<!-- JS
============================================ -->

<!-- jQuery JS -->
<script src={{ asset("js/vendor/jquery-1.12.4.min.js") }}></script>
<!-- Popper JS -->
<script src={{ asset("js/popper.min.js") }}></script>
<!-- Bootstrap JS -->
<script src={{ asset("js/bootstrap.min.js") }}></script>
<!-- Plugins JS -->
<script src={{ asset("js/plugins.js") }}></script>

<!-- Main JS -->
<script src={{ asset("js/main.js") }}></script>
<script>
    window.$("#paginate").change(function(){

        $val=document.getElementById("paginate").value;
        var url = window.location.href;
        // let temp=url.slice(0, -1);
        let temp=url.substring(0, url.lastIndexOf("/") + 1);
        let f=temp.concat($val);
        location.replace(f);


    })
    window.$("#serachoption").change(function(){
        console.log("hit");
        document.getElementById("resarea").innerHTML="";

    })
</script>
<script>
    function clear() {

        document.getElementById("resarea").innerHTML="";
    }
    function randsearch(){
      if(document.querySelector('#searchvalue').value){
          search();
      }else{
          document.getElementById("resarea").innerHTML="";

      }

    }
    function search() {
        var opt=document.querySelector('#serachoption').value;
        var val=document.querySelector('#searchvalue').value
        axios.post(`/product/search`,{
            searctopt:opt,
            val:val
        }).then((res)=>{
            document.getElementById("resarea").innerHTML="";
        var products=res.data.products;

        var result='';
        if(products.length>0){
            products.forEach((p)=>{

                result+=`<div class="row" ><div class="col-md-6"><img style="height: 10rem;" src="{{ URL::asset("") }}${p.product_pictures[0]}" alt="product-image"></div>
<div class="col-md-6 " style="margin-top: 9vh;"><a href="/product-search/${p.category_id}/${p.sub_category_id}/${p.id}">${p.name}</a><p><b>${p.price}৳</b></p></div></div>`;

            })
        }else{
            result+=`<div class="row">
<div class="col-md-12" style="margin-top: 9vh;"><h6 class="text-danger">NO Product Found..!!</h6></div></div>`;
        }

            document.getElementById("resarea").innerHTML=result;

        }).catch((err)=>console.log(err));
    }
</script>







</body>

</html>
