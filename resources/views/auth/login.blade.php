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
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <div id="scroll-to-top">
        <i class="fa fa-arrow-up"></i>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#">
                <img style="height: 100px; width: 100px;" src="https://www.vippng.com/png/full/36-362739_svg-free-rice-paddy-field-logo-circle.png" alt="">
            </a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="{{ route('view.cart') }}"><i class="fa fa-shopping-bag"></i> <span>{{ count($cart_items) }}</span></a></li>
            </ul>
            <div class="header__cart__price">Total: <span>₱{{ number_format($total_price, 2) }}</span></div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="{{ request()->routeIs('homepage') ? 'active' : '' }}"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="{{ request()->routeIs('shoppage') ? 'active' : '' }}"><a href="{{ route('shoppage') }}">Shop</a></li>
                <li class="{{ request()->routeIs('myorderpage') ? 'active' : '' }}">
                    <a href="#">Orders</a>
                    <ul class="header__menu__dropdown">
                        <li class="{{ request()->routeIs('myorderpage') ? 'active' : '' }}">
                            <a href="{{ route('myorderpage') }}">Track orders</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('contactpage') ? 'active' : '' }}"><a href="{{ route('contactpage')}}">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="{{ route('homepage') }}" style="color: black;">
                            <img style="height: 100px; width: 100px;" src="https://www.vippng.com/png/full/36-362739_svg-free-rice-paddy-field-logo-circle.png" alt=""> &nbsp; Dimasupil's
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="{{ request()->routeIs('homepage') ? 'active' : '' }}"><a href="{{ route('homepage') }}">Home</a></li>
                            <li class="{{ request()->routeIs('shoppage') ? 'active' : '' }}"><a href="{{ route('shoppage') }}">Shop</a></li>
                            <li class="{{ request()->routeIs('myorderpage') ? 'active' : '' }}">
                                <a href="#">Orders</a>
                                <ul class="header__menu__dropdown">
                                    <li class="{{ request()->routeIs('myorderpage') ? 'active' : '' }}">
                                        <a href="{{ route('myorderpage') }}">Track orders</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ request()->routeIs('contactpage') ? 'active' : '' }}"><a href="{{ route('contactpage') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        @auth
                            @if(auth()->user()->role == 'customers')
                                <ul>
                                    <li><a href="{{ route('myprofilepage') }}" style="color: black !important"><i class="fa fa-user"></i> Profile</a></li>
                                    <li><a href="{{ route('logoutrequest') }}" style="color: rgb(157, 16, 16) !important">Logout</a></li>
                                    <li><a href="{{ route('view.cart') }}"><i class="fa fa-shopping-bag"></i> <span>{{ count($cart_items) }}</span></a></li>
                                    <li>
                                        <a href="#" id="notificationBell">
                                            <i class="fa fa-bell"></i> <span>{{ $notifications->count() }}</span>
                                        </a>
                                        <div style="text-align: left" class="notification__dropdown" id="notificationDropdown">
                                            @if ($notifications->isEmpty())
                                                <p style="text-align: center; margin-top: 10px; color: brown;">No inbox found</p>
                                            @else
                                                @foreach ($notifications as $notification)
                                                    <a href="#" onclick="markNotificationCustomerSeen('{{ $notification->reference_number }}')" class="notification__item">
                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <!-- Order icon -->
                                                        @if ($notification->message === "New orders")
                                                            You placed your orders {{ $notification->reference_number }}
                                                        @else
                                                            Admin {{ $notification->message }} {{ $notification->reference_number }}
                                                        @endif
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </li>
                                    <div class="header__cart__price">Total: <span>₱{{ number_format($total_price, 2) }}</span></div>
                                </ul>
                            @elseif(auth()->user()->role == 'admin' || auth()->user()->role == 'staff')
                                <ul>
                                    <li><a href="{{ route('admin.dashboard') }}" style="color: black !important"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                                </ul>
                            @endif
                        @else
                            <ul>
                                <li><a href="{{ route('loginpage') }}" style="color: black !important"><i class="fa fa-user"></i> Login</a></li>
                                <li><a href="{{ route('registerpage' )}}" style="color: black !important"> Register</a></li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->


    <section class="featured spad">
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
            <div class="row justify-content-center"> <!-- Center the row -->
                <div class="col-lg-6 col-md-6" style="border: 2px solid black; padding: 20px;">
                    <div class="section-title">
                        <h2>Login page</h2>
                    </div>
                    <form action="{{ route('loginrequest') }}" method="POST">
                        @csrf
                        <div class="checkout__input">
                            <p style="font-weight: 900">Email : <span></span></p>
                            <input style="color: black; border: 2px solid black;" name="email" type="text">
                        </div>
                        <div class="checkout__input">
                            <p style="font-weight: 900">Password : <span></span></p>
                            <input style="color: black; border: 2px solid black;" name="password" type="password">
                        </div>
                        <div class="checkout__input d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('registerpage' )}}" style="color: red; font-weight: 900; margin-bottom: 0;">Click here to register</a>
                            </div>
                            <div>
                                <button type="submit" class="site-btn">Login</button>
                            </div>
                        </div>
                        <div style="text-align: left; margin-top: -30px;">
                        <a style="color: red; font-weight: 900;" href="#" id="forgot-password-link" data-toggle="modal" data-target="#forgot-password-modal">Forgot password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel" style="font-weight: 900">Forgot Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="forgotPasswordForm" action="{{ route('forgotpassword') }}" method="POST" class="forgotPasswordForm" onsubmit="disableForm()">
                            @csrf
                            <div class="checkout__input">
                                <p style="font-weight: 900">Email : <span></span></p>
                                <input style="color: black; border: 2px solid black;" name="email" type="text">
                            </div>
                            <div style="display: flex; justify-content: end;">
                                <button id="submitButton" type="submit" class="site-btn mt-2">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="overlay">
        <div id="loading-message">Submitting, please wait...</div>
    </div>

    
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