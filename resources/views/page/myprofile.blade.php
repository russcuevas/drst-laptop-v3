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
                        <h2>My profile</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section End -->


    <!-- Contact Form Begin -->
    <div class="contact-form spad">
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
                <h4>Change Information</h4>
                <form action="{{ route('updatemyprofilerequest') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Fullname<span>*</span></p>
                                <input style="color: black; border: 2px solid black;" name="fullname" value="{{ $user->fullname }}" type="text" required>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input style="color: black; border: 2px solid black;" name="address" value="{{ $user->address }}" type="text" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input style="color: black; border: 2px solid black;" name="contact" value="{{ $user->contact }}" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" maxlength="11" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input style="color: black; border: 2px solid black;" name="email" value="{{ $user->email }}" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Password<span>*</span></p>
                                        <input style="color: black; border: 2px solid black;" name="password" type="password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Confirm password<span>*</span></p>
                                        <input style="color: black; border: 2px solid black;" name="password_confirmation" type="password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <!-- <h4>Your Order</h4>-->
                                <ul>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="">
                                    <button type="submit" class="site-btn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- Contact Form End -->

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