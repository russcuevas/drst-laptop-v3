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

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" style="background-image: url('https://www.doka-shop.com.my/image/dokashop/image/data/about/main_about_rice.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Quick view</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Quick view</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
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
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="{{ asset('storage/products/' . basename($single_product->product_picture)) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $single_product->product_name }}</h3>
                        <h4>{{ $single_product->product_type }}</h4>
                        <h4 style="text-transform: capitalize">{{ $single_product->product_grain }}</h4>

                        <div class="product__details__price">₱{{ $single_product->product_price }}</div>
                        <ul>
                            <li><b>Availability</b> <span>{{ $single_product->product_status }}</span></li>
                            <li><b>Net Weight</b> <span>{{ $single_product->product_net_wt }}</span></li>
                            <br>
                            <br>
                        </ul>
                        <div class="product__details__quantity">
                        <form method="post" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $single_product->id }}">
                                <div class="quantity">
                                    <div class="pro-qty" style="background-color: rgb(0, 0, 0);">
                                        <input style="background-color: rgb(0, 0, 0); color: white;" name="quantity" value="1">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn">ADD TO CART</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($related_products as $related_product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" style="background-image: url('{{ asset('storage/products/' . basename($related_product->product_picture)) }}') !important;">
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('product.details', ['id' => $related_product->id]) }}">{{ $related_product->product_name }}</a></h6>
                                <h6><a href="{{ route('product.details', ['id' => $related_product->id]) }}" style="text-transform: capitalize">{{ $related_product->product_grain }}</a></h6>
                                <h5>₱{{ $related_product->product_price }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

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