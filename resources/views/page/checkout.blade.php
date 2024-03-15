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
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
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
            <div class="checkout__form">
                <h4>Payment Details</h4>
                <form action="{{ route('checkoutrequest') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8 col-md-6">
                                            <div class="checkout__input">
                                                <p>Fullname<span>*</span></p>
                                                <input style="color: black; border: 2px solid black;" name="fullname" type="text">
                                            </div>
                                            <div class="checkout__input">
                                                <p>Address<span>*</span></p>
                                                <input style="color: black; border: 2px solid black;" name="address" type="text">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="checkout__input">
                                                        <p>Phone<span>*</span></p>
                                                        <input style="color: black; border: 2px solid black;" name="contact" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout__input">
                                                        <p>Email<span>*</span></p>
                                                        <input style="color: black; border: 2px solid black;" name="email" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="checkout__order">
                                                <h4>Your Order</h4>
                                                <div class="checkout__order__products">Products <span>Total</span></div>
                                                <ul>
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($cart_items as $cart)
                                                        @if(in_array($cart->id, $selectedProductIds))
                                                            <input type="hidden" name="product_details[]" value="{{ $cart->product->product_name }} ({{ $cart->product->product_price }})">
                                                            <input type="hidden" name="customer_id[]" value="{{ $cart->customer_id }}">
                                                            <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
                                                            @php
                                                                $subtotal = $cart->quantity * $cart->product->product_price;
                                                                $total += $subtotal;
                                                            @endphp
                                                            <input type="hidden" name="subtotal[]" value="{{ $subtotal }}">
                                                            <input type="hidden" name="total_amount[]" value="{{ $subtotal }}">
                                                            <input type="hidden" name="total_quantity[]" value="{{ $cart->quantity }}">
                                                            
                                                            <li>
                                                                {{ $cart->product->product_name }} ({{ $cart->product->product_grain}})
                                                                <span>({{ $cart->quantity }}) -- ₱{{ number_format($subtotal, 2) }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <div class="checkout__order__total">Total <span>₱{{ number_format($total, 2) }}</span></div>
                                                <h5 style="font-weight: 900; margin-bottom: 10px;">Select payment method</h5>
                                                <div>
                                                    <select name="payment_method" id="">
                                                        <option value="Cash on delivery">Cash on delivery</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

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