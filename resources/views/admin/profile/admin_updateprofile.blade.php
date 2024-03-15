


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.css') }} " rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('admin/plugins/node-waves/waves.css') }} " rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('admin/plugins/animate-css/animate.css') }} " rel="stylesheet" />

    <!-- Sweet Alert Css -->
    <link href="{{ asset('admin/plugins/sweetalert/sweetalert.css') }} " rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('admin/plugins/bootstrap-select/css/bootstrap-select.css') }} " rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('admin/css/style.css') }} " rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('admin/css/themes/all-themes.css') }} " rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .tab-content ul li a:hover {
            color: #002b53 !important;
        }

        .pagination li.active a {
            background-color: #002b53 !important;
        }

        .breadcrumb-col-red li a {
            color: #002b53 !important;
            font-weight: bold;
        }

        .theme-red .sidebar .menu .list li.active> :first-child i,
        .theme-red .sidebar .menu .list li.active> :first-child span {
            color: #002b53 !important;
        }

        .dataTables_wrapper .dt-buttons a.dt-button {
             background-color: #002b53 !important;
            color: #fff;
            padding: 7px 12px;
            margin-right: 5px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -ms-border-radius: 2px;
            border-radius: 2px;
            border: none;
            font-size: 13px;
            outline: none;
        }

        .bg-custom {
            background-color: #002b53 !important;
            color: #fff;
        }

        .bg-custom:hover {
            color: gray;
        }

        .form-group .form-line.focused .form-label,
        .form-group .form-line .form-label {
            top: -15px !important;
            color: #212529 !important;
            font-weight: 900;
        }

        .col-centered{
    float: none;
    margin: 0 auto;
}
    </style>
</head>

@include('admin.components.navbar')
    <section>
        @include('admin.components.left_sidebar')
        @include('admin.components.right_sidebar')
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <ol class="breadcrumb breadcrumb-col-red">
                    <li><a href="{{ route('admin.dashboard')}} "><i class="material-icons">home</i> Home</a></li>
                    <li class="active"><i class="material-icons">lock</i> Update Profile</li>
                </ol>
            </div>
            <!-- Advanced Validation -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12col-xs-12 col-centered">
                    <div class="card">
                        <div class="header">
                            <h2>Update Profile</h2>
                        </div>
                        <div class="body">
                            {{-- display the alert success --}}
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <br>
                            <br>
                            <form id="form_advanced_validation" action="{{ route('admin.updateprofilerequest')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}" required>
                                        <label class="form-label">Fullname</label>
                                    </div>
                                    <div class="help-info">Ex. Juan Dela Cruz, Jr</div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="contact" value="{{ $user->contact }}" minlength="11" maxlength="11" required>
                                        <label class="form-label">Phone number</label>
                                    </div>
                                    <div class="help-info">09123456789</div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="address" value="{{ $user->address }}" required>
                                        <label class="form-label">Address</label>
                                    </div>
                                    <div class="help-info">House number, Barangay</div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}" required>
                                        <label class="form-label">Email</label>
                                    </div>
                                    <div class="help-info">Must be a valid email</div>
                                    @error('email')
                                        <label class="error">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" maxlength="20" minlength="6">
                                        <label class=" form-label">Password</label>
                                    </div>
                                    <div class="help-info">Min.6, Max 20 characters.</div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password_confirmation" maxlength="20" minlength="6">
                                        <label class=" form-label">Confirm password</label>
                                    </div>
                                    @error('password_confirmation')
                                        <label class="error">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div style="display: flex !important; justify-content: end !important; align-items: flex-end !important">
                                    <input class="btn bg-custom btn-lg" type="submit" name="submit" value="Update profile">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Advanced Validation -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }} "></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.js') }} "></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js') }} "></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }} "></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.js') }} "></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js') }} "></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-steps/jquery.steps.js') }} "></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js') }} "></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('admin/plugins/node-waves/waves.js') }} "></script>

    <!-- Custom Js -->
    <script src="{{ asset('admin/js/admin.js') }} "></script>
    <script src="{{ asset('admin/js/pages/forms/form-validation.js') }} "></script>

    <!-- Demo Js -->
    <script src="{{ asset('admin/js/demo.js') }} "></script>
</body>
</html>