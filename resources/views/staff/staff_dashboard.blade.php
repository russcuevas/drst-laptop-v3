<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('staff/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('staff/plugins/node-waves/waves.css')}}" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="{{ asset('staff/plugins/animate-css/animate.css')}}" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="{{ asset('staff/plugins/morrisjs/morris.css')}}" rel="stylesheet" />
    {{-- JQuery Datatable --}}
    <link href="{{ asset('staff/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('staff/css/style.css')}}" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('staff/css/themes/all-themes.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('staff/css/custom.css')}}">
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
        
    </style>
</head>

@include('staff.components.navbar')

    <section>
        @include('staff.components.left_sidebar')
        @include('staff.components.right_sidebar')
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                PRODUCTS LIST
                            </h2>
                        </div>
                        <div class="body">
                            {{-- display results --}}
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style=" color: #0e0e0e !important; margin-top: 20px important!">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                            <th>Net weight</th>
                                            <th>Grain</th>
                                            <th>Stocks</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($products) > 0)
                                            @foreach ($products as $product)
                                            <tr style="text-wrap: nowrap;">
                                                <td>{{ $product->product_code }}</td>
                                                <td><img src="{{ asset('storage/products/' . basename($product->product_picture)) }}" alt="Product Image" style="max-width: 50px; max-height: 50px;"></td>
                                                <td>{{ $product->product_name}}</td>
                                                <td>₱{{ $product->product_price }}</td>
                                                <td>{{ $product->product_type }}</td>
                                                <td>{{ $product->product_net_wt }}</td>
                                                <td style="text-transform: capitalize">{{ $product->product_grain }}</td>
                                                <td>{{ $product->product_stocks }}</td>
                                                <td>{{ $product->product_status }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">No product available</td>
                                            </tr>
                                        @endif
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>

    </section>

    <!-- Jquery Core Js -->
    <script src="{{ asset('staff/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('staff/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('staff/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('staff/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('staff/plugins/node-waves/waves.js')}}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('staff/plugins/jquery-countto/jquery.countTo.js')}}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('staff/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('staff/plugins/chartjs/Chart.bundle.js')}}"></script>

        <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('staff/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('staff/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('staff/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{ asset('staff/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('staff/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{ asset('staff/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{ asset('staff/plugins/flot-charts/jquery.flot.time.js')}}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('staff/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('staff/js/admin.js')}}"></script>
    <script src="{{ asset('staff/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{ asset('staff/js/pages/index.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('staff/js/demo.js')}}"></script>

</body>
</html>