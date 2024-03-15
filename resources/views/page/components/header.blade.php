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
        <a href="#"><img style="height: 100px; width: 100px;"
                src="https://www.vippng.com/png/full/36-362739_svg-free-rice-paddy-field-logo-circle.png"
                alt=""></a>
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
                    <a href="{{ route('homepage') }}" style="color: black;"><img style="height: 100px; width: 100px;"
                            src="https://www.vippng.com/png/full/36-362739_svg-free-rice-paddy-field-logo-circle.png"
                            alt=""> &nbsp; Dimasupil's</a>
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
                                <li><a href="{{ route('view.cart') }}"><i class="fa fa-shopping-bag"></i> <span>0</span></a></li>
                                <div class="header__cart__price">Total: <span>₱0.00</span></div>
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
