<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description">
    <meta name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">

            <div class="alert alert-success" style="display: none;">
                <!-- success message display dynamically -->
            </div>
            <div class="alert alert-danger" style="display: none;">
                <!-- error message display dynamically -->
            </div>
            @auth
            @if ($cart_items->isNotEmpty())
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                    <form action="{{ route('checkoutpage') }}" method="get">
                        @csrf
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart_items as $cart)
                                    <tr>
                                        <td>
                                        <input type="checkbox" class="productCheckbox individualCheckbox" name="selected_products[]" value="{{ $cart->id }}" data-price="{{ $cart->quantity * $cart->product->product_price }}">
                                        </td>
                                        <td class="shoping__cart__item">
                                            <img style="width: 100px; height: 100px;" src="{{ asset('storage/products/' . basename($cart->product->product_picture)) }}" alt="{{ $cart->product->product_name }}"> <br>
                                            <h5>{{ $cart->product->product_name }}</h5> <br>
                                            <h5>{{ $cart->product->product_type }}</h5> <br>
                                            <h5 style="text-transform: capitalize">{{ $cart->product->product_grain }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            ₱{{ $cart->product->product_price }}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty" style="background-color: rgb(0, 0, 0);" data-cart-id="{{ $cart->id }}" data-product-id="{{ $cart->product->id }}">
                                                    <input style="background-color: rgb(0, 0, 0); color: white;" name="quantity" type="text" value="{{ $cart->quantity }}" readonly>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            ₱{{ number_format($cart->quantity * $cart->product->product_price, 2) }}
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <span style="color: rgb(199, 30, 30);" class="icon_close" data-cart-id="{{ $cart->id }}"></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                    <a href="{{ route('delete.allcart') }}" style="background-color: brown; color: white !important" class="primary-btn cart-btn cart-btn-right">DELETE ALL</a>
                        <span class="primary-btn">
                            SELECT ALL : <input type="checkbox" class="productCheckbox btn-left select-all-checkbox">
                        </span>
                    </div>
                </div>
                <div class="col-lg-6">
                </div>
                    <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                        <li>Total <span id="cartTotal">₱{{ number_format($total, 2) }}</span></li>
                        </ul>
                            <button type="submit" class="primary-btn">PROCEED TO CHECKOUT</button> <br>
                        </form>
                        <button onclick="window.location.href='{{ route('shoppage') }}'" class="primary-btn">CONTINUE SHOPPING</button>

                    </div>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" style="color: brown; font-weight: 900; font-size: 50px">No item in the cart &nbsp; <i class="fa fa-shopping-bag"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" style="color: brown; font-weight: 900; font-size: 50px">Please login first to view your cart &nbsp; <i class="fa fa-shopping-bag"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endauth
    </section>

    <!-- Shoping Cart Section End -->

    @include('page.components.footer')
    <!-- Js Plugins -->
    <script src="{{ asset('page/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('page/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('page/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('page/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('page/ajax/cart/update_cart.js')}}"></script>
    <script src="{{ asset('page/ajax/cart/delete_cart.js')}}"></script>



</body>
</html>