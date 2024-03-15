<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('admin/plugins/node-waves/waves.css')}}" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="{{ asset('admin/plugins/animate-css/animate.css')}}" rel="stylesheet" />
    <!-- Morris Chart Css-->
    <link href="{{ asset('admin/plugins/morrisjs/morris.css')}}" rel="stylesheet" />
    {{-- JQuery Datatable --}}
    <link href="{{ asset('admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('admin/css/themes/all-themes.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css')}}">
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

@include('admin.components.navbar')

    <section>
        @include('admin.components.left_sidebar')
        @include('admin.components.right_sidebar')
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL USERS</div>
                            <div> <span style="font-size: 25px">{{ $get_total_users }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL PRODUCTS</div>
                            <div> <span style="font-size: 25px">{{ $get_total_products }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL SALES</div>
                            <div> <span style="font-size: 25px">₱{{ $get_total_sales }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">COMPLETED ORDERS</div>
                            <div> <span style="font-size: 25px">{{ $get_completed }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Display Low Stock Products -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            PRODUCT ALERT STOCKS
                        </h2>
                    </div>
                    <div class="body">
                        {{-- display low stock products --}}
                        @if($get_low_stock_products->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="color: #0e0e0e !important; margin-top: 20px !important;">
                                    <thead>
                                        <tr>
                                            <th>Product name</th>
                                            <th>Product stocks</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($get_low_stock_products as $product)
                                            <tr>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_stocks }}</td>
                                                <td>{{ $product->product_status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.updateproducts', ['id' => $product->id])}}">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p style="text-align: center">No products with low stocks</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Display Recent Orders -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RECENT ORDERS
                            </h2>
                        </div>
                        <div class="body">
                            {{-- display results --}}
                            @if($recentOrders->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="color: #0e0e0e !important; margin-top: 20px !important;">
                                        <thead>
                                            <tr>
                                                <th>Reference number</th>
                                                <th>Customer</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentOrders as $order)
                                            <tr>
                                                <td>{{ $order->reference_number }}</td>
                                                <td>{{ $order->fullname }}</td>
                                                <td>₱{{ $order->total_amount }}</td>
                                                <td>
                                                    <a href="{{ route('admin.orders.show', ['ReferenceNumber' => $order->reference_number, 'InvoiceNumber' => $order->invoice_number]) }}">View</a>
                                                </td>
                                            </tr>                                    
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p style="text-align: center">No recent orders</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Jquery Core Js -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('admin/plugins/node-waves/waves.js')}}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-countto/jquery.countTo.js')}}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('admin/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('admin/plugins/chartjs/Chart.bundle.js')}}"></script>

        <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('admin/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{ asset('admin/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('admin/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{ asset('admin/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{ asset('admin/plugins/flot-charts/jquery.flot.time.js')}}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('admin/js/admin.js')}}"></script>
    <script src="{{ asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{ asset('admin/js/pages/index.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('admin/js/demo.js')}}"></script>

</body>
</html>