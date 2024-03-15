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
                        <h2>Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
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
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>All grains</h4>
                            <ul>
                                <li><a href="{{ route('shoppage') }}">All</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'short grain']) }}">Short grain</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'medium grain']) }}">Medium grain</a></li>
                                <li><a href="{{ route('shopgrain', ['grain' => 'long grain']) }}">Long grain</a></li>
                            </ul>
                        </div>
                        {{-- <div class="sidebar__item">
                            <h4>Price</h4>
                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="10" data-max="540">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minamount">
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="sidebar__item">
                            <h4>Product type</h4>
                            <div class="sidebar__item__size">
                                <label for="large">
                                    Large
                                    <input type="radio" id="large">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="medium">
                                    Medium
                                    <input type="radio" id="medium">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="small">
                                    Small
                                    <input type="radio" id="small">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="tiny">
                                    Tiny
                                    <input type="radio" id="tiny">
                                </label>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Best seller</h2>
                        </div>
                        @if($top_products->isNotEmpty())
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                @foreach ($top_products as $product)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="featured__item">
                                        <div class="featured__item__pic set-bg"
                                            style="background-image: url('{{ asset('storage/products/' . basename($product->product_picture)) }}') !important;">
                                            <p style="background-color: green; color: white; padding: 5px; border-radius: 5px;">
                                                TOTAL SOLD: {{ $product->total_sold }}
                                            </p>
                                            <ul class="featured__item__pic__hover">
                                            <li><a href="{{ route('product.details', ['id' => $product->id ])}}"><i class="fa fa-eye"></i></a></li>
                                            <form method="post" action="{{ route('cart.add') }}">
                                                @csrf
                                                <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                            </ul>
                                        </div>
                                        <div class="featured__item__text">
                                            <h6><a href="#">{{ $product->product_name }} ({{ $product->product_type }})</a></h6>
                                            <h6 style="text-transform: capitalize">{{ $product->product_grain }} ({{ $product->product_net_wt }})</h6>
                                            <h5>₱{{ $product->product_price }}</h5>
                                        </div>
                                    </div>
                                </div>      
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                        <h2 style="color: brown; font-weight: 900; font-size: 50px;" class="text-center">No top products found</h2> <br>
                    @endif
                    <div class="filter__item">
                        <div class="row">
                            {{-- <div class="col-lg-6 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-12 col-md-4">
                                <div class="filter__found">
                                    <h6>
                                        @if(isset($grain_type))
                                            <span style="text-transform: capitalize">{{ $grain_type }}</span> Products
                                        @else
                                            <span>{{ $product_count }}</span> Products found
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            {{-- <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($all_products as $all_product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg"
                                    style="background-image: url('{{ asset('storage/products/' . basename($all_product->product_picture)) }}') !important;">
                                    <ul class="featured__item__pic__hover">
                                    <li><a href="{{ route('product.details', ['id' => $all_product->id ])}}"><i class="fa fa-eye"></i></a></li>
                                    <form method="post" action="{{ route('cart.add') }}">
                                        @csrf
                                        <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="product_id" value="{{ $all_product->id }}">
                                    </form>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6>{{ $all_product->product_name }} ({{ $all_product->product_type }})</h6>
                                    <h6 style="text-transform: capitalize">{{ $all_product->product_grain }} ({{ $all_product->product_net_wt }})</h6>
                                    <h5>₱{{ $all_product->product_price }}</h5>
                                </div>
                            </div>
                        </div>                
                        @endforeach
                    </div>
                        <div class="product__pagination">
                            @if($all_products instanceof \Illuminate\Pagination\AbstractPaginator)
                                @foreach ($all_products->links()->elements[0] as $page => $url)
                                    <a href="{{ $url }}" class="pagination-link @if($page == $all_products->currentPage()) current @endif">{{ $page }}</a>
                                @endforeach
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

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