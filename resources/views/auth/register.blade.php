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
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6" style="border: 2px solid black; padding: 20px;">
                <div class="section-title">
                    <h2>Registration page</h2>
                </div>
                <form action="{{ route('register.request') }}" method="POST">
                    @csrf
                    <div class="checkout__input">
                        <label for="fullname" style="font-weight: 900">Fullname<span style="color: red;">*</span></label>
                        <input id="fullname" style="color: black; border: 2px solid black;" name="fullname" type="text" value="{{ old('fullname') }}">
                        <div class="text-right">
                            <p style="font-size: 12px; color: gray; font-weight: 900;">Ex. Juan Dela Cruz, Jr</p>
                        </div>
                    </div>
                    <div class="checkout__input">
                        <label for="email" style="font-weight: 900">Email<span style="color: red;">*</span></label>
                        <input id="email" style="color: black; border: 2px solid black;" name="email" type="email" value="{{ old('email') }}">
                        <div class="text-right">
                            <p style="font-size: 12px; color: gray; font-weight: 900;">Must be a valid email</p>
                        </div>
                    </div>
                    <div class="checkout__input">
                        <label for="password" style="font-weight: 900">Password<span style="color: red;">*</span></label>
                        <input id="password" style="color: black; border: 2px solid black;" name="password" type="password">
                        <div class="text-right">
                            <p style="font-size: 12px; color: gray; font-weight: 900;">Min:6, Max:20 characters</p>
                        </div>
                    </div>
                    <div class="checkout__input">
                        <label for="confirm_password" style="font-weight: 900">Confirm password<span style="color: red;">*</span></label>
                        <input id="confirm_password" style="color: black; border: 2px solid black;" name="confirm_password" type="password">
                        <div class="text-right">
                            <p style="font-size: 12px; color: gray; font-weight: 900;">Retype password</p>
                        </div>
                    </div>
                    <!-- Add other form fields as needed -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p style="font-weight: 900">Phone<span>*</span></p>
                                <input style="color: black; border: 2px solid black;" name="contact" type="text" value="{{ old('contact') }}">
                                <div class="text-left">
                                <p style="font-size: 12px; color: gray; font-weight: 900;">Must be a valid phone number</p>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p style="font-weight: 900">Address<span>*</span></p>
                                <input style="color: black; border: 2px solid black;" name="address" type="text" value="{{ old('address') }}">
                                <div class="text-right">
                                <p style="font-size: 12px; color: gray; font-weight: 900;">House number, Barangay</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="checkout__input d-flex justify-content-between align-items-center">
                        <a href="{{ route('loginpage') }}" style="color: red; font-weight: 900;">Click here to login</a>
                        <button type="submit" class="site-btn">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


    
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