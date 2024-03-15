<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description">
    <meta name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dimasupil's</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('page/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('page/css/style.css') }}" type="text/css">
</head>

<body>
    @include('page.components.header')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
        {{-- displaying the validation error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All grains</span>
                        </div>
                            <ul>
                                <li><a href="{{ route('shoppage') }}">All</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'short grain']) }}">Short grain</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'medium grain']) }}">Medium grain</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'long grain']) }}">Long grain</a></li>
                            </ul>
                    </div>
                </div>
                <div class="col-lg-9" style="background-color: #073186;">
                    <div class="hero__item set-bg"
                        style="background-image: url('https://www.srssulit.com/wp-content/uploads/products/2004874038-1.png') !important; background-size: auto; background-position: right;">
                        <div class="hero__text">
                            <span>Best rice</span>
                            <h2>Rice <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="{{ route('shoppage') }}" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        @if ($top_products->isNotEmpty())
            <div class="container">
                <div class="section-title">
                    <h2>Best seller</h2>
                </div>
                <div class="row">
                    <div class="categories__slider owl-carousel">
                        @foreach ($top_products as $product)
                            <div class="col-lg-3">
                                <div class="categories__item set-bg"
                                    style="background-image: url('{{ asset('storage/products/' . basename($product->product_picture)) }}') !important;">
                                    <h5><a href="{{ route('product.details', ['id' => $product->id ])}}">{{ $product->product_name }}</a></h5>
                                <p style="background-color: green; color: white; padding: 5px; border-radius: 5px;">
                                    TOTAL SOLD: {{ $product->total_sold }}
                                </p>                                
                            </div> 
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        @if ($featured_products->isNotEmpty())
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach ($featured_products as $featured_product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg"
                            style="background-image: url('{{ asset('storage/products/' . basename($featured_product->product_picture)) }}') !important;">
                            <ul class="featured__item__pic__hover">
                            <li><a href="{{ route('product.details', ['id' => $featured_product->id ])}}"><i class="fa fa-eye"></i></a></li>
                            <form method="post" action="{{ route('cart.add') }}">
                                @csrf
                                <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="product_id" value="{{ $featured_product->id }}">
                            </form>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">{{ $featured_product->product_name }} ({{ $featured_product->product_type }})</a></h6>
                            <h6 style="text-transform: capitalize">{{ $featured_product->product_grain }} ({{ $featured_product->product_net_wt }})</h6>
                            <h5>₱{{ $featured_product->product_price }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>
    <!-- Featured Section End -->

    @include('page.components.footer')
    <!-- Js Plugins -->
    <script src="{{ asset('page/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('page/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('page/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('page/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('page/js/main.js') }}"></script>



</body>

</html>