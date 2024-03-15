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
                <li><a href="dashboard.php"><i class="material-icons">home</i> Home</a></li>
                <li class="active"><i class="material-icons">analytics</i> Analytics</li>
            </ol>
        </div>

        <div class="row clearfix">
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>TOP 3 PRODUCT</h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="pie_chart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- #END# Pie Chart -->

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>YEARLY SALES</h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <canvas id="yearly-chart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- #END# Line Chart -->
        </div>

        <div class="row clearfix">
            <!-- Line Chart -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>MONTHLY SALES</h2>
                        <ul class="header-dropdown m-r--5">

                        </ul>
                    </div>
                    <div class="body">
                        <div style="text-align: right;">
                            <span style="color: #0f3d71 !important;">Year : </span>
                            <select name="" id="selectYearMonthlySales">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <br>
                        <canvas id="bar-chart" height="170"></canvas>
                    </div>
                </div>
            </div>
            <!-- #END# Line Chart -->

            <!-- Pie Chart -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>WEEKLY SALES</h2>
                        <ul class="header-dropdown m-r--5">
                        </ul>
                    </div>
                    <div class="body">
                        <div style="text-align: right;">
                            <span style="color: #0f3d71 !important;">Year : </span>
                            <select name="" id="selectYear">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                            <br>
                            <span style="color: #0f3d71 !important;">Month : </span>
                            <select name="" id="selectMonth">
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <br>
                        <canvas id="line-chart" height="155"></canvas>
                    </div>
                </div>
            </div>
            <!-- #END# Pie Chart -->
        </div>
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

    <script src="{{ asset('admin/plugins/chartjs/Chart.bundle.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('admin/js/admin.js') }} "></script>
    <script src="{{ asset('admin/js/pages/forms/form-validation.js') }} "></script>
    <script src="{{ asset('admin/js/custom_chart.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('admin/js/demo.js') }} "></script>
</body>
</html>