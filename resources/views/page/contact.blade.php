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

        {{-- displaying the validation error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif


        @if (session('success'))
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        @endif

        @if (session('error'))
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        @endif

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" style="background-image: url('https://www.doka-shop.com.my/image/dokashop/image/data/about/main_about_rice.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Contact</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Contact</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="contact spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <div class="contact__widget">
                            <span class="icon_phone"></span>
                            <h4>Contact</h4>
                            <p>09478510206 - SMART <br>
                                09957016519 - GLOBE <br>
                                (02)-8350-4696 - PLDT
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <div class="contact__widget">
                            <span class="icon_pin_alt"></span>
                            <h4>Address</h4>
                            <p>#1354, Sampaguita Street, Ismar Kalawaan, Pasig City</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <div class="contact__widget">
                            <span class="icon_clock_alt"></span>
                            <h4>Open time</h4>
                            <p>6:00am -- 10:00pm</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <div class="contact__widget">
                            <span class="icon_mail_alt"></span>
                            <h4>Email</h4>
                            <p>twilightharrypotterhunger23@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Section End -->

        <!-- Map Begin -->
        <div class="map">
        <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15406.623212337882!2d121.09867808396299!3d14.555961045233205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397a8fb52e3c85d%3A0x1b8d5a9a71e9d4b4!2s1354%20Sampaguita%20St%2C%20Pasig%2C%201602%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1647347240715!5m2!1sen!2sph"
        height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <div class="map-inside">
                <i class="icon_pin"></i>
                <div class="inside-widget">
                    <h4>Location</h4>
                    <ul>
                        <li>Address: #1354, Sampaguita Street, Ismar Kalawaan, Pasig City</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Map End -->

        <!-- Contact Form Begin -->
        <div class="contact-form spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact__form__title">
                            <h2>Leave Message</h2>
                        </div>
                    </div>
                </div>
                <form action="{{ route('send_inquiry') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <input type="text" placeholder="Your name" name="name" required>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input type="email" placeholder="Your Email" name="email" required>
                        </div>
                        <div class="col-lg-12 text-center">
                            <textarea placeholder="Your message" name="message" required></textarea>
                            <button type="submit" class="site-btn">SEND MESSAGE</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- Contact Form End -->

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