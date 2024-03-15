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
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

</head>

<body>
    @include('page.components.header')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" style="background-image: url('https://www.doka-shop.com.my/image/dokashop/image/data/about/main_about_rice.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Tracking Orders</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Tracking Orders</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container container-box">
            @auth
            @if ($orders->isNotEmpty())
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table id="ordersTable">
                            <thead>
                                <tr>
                                    <th class="shoping__product">Reference number</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="img/cart/cart-1.jpg" alt="">
                                        <h5>{{ $order->reference_number }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ₱{{ $order->total_amount }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        @if ($order->order_status === 'Delivered')
                                            <h5 style="color: green">Paid</h5>
                                        @else
                                            <h5 style="color: brown">Not paid</h5>
                                        @endif
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a style="color: blue" href="{{ route('myordershow', ['ReferenceNumber' => $order->reference_number]) }}">Track orders</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                    <td colspan="8" style="color: brown; font-weight: 900; font-size: 50px">No orders available </td>
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
                                    <td colspan="8" style="color: brown; font-weight: 900; font-size: 50px">Please login first to view orders &nbsp; <i class="fa fa-shopping-bag"></i></td>
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

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#ordersTable').DataTable();
        });
    </script>
</body>

</html>
