<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        
        .dropdown-menu-scrollable {
        max-height: 400px;
        overflow-y: auto;
    }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a id="app-title" style="display:flex;align-items:center" class="navbar-brand" href="{{ route ('admin.dashboard')}}">
                    <img id="bcas-logo" style="width:45px;display:inline;margin-right:10px;" src="https://www.wholesalericeph.com/wp-content/uploads/2020/07/Wholesale-Rice-PH-logo.png" />
                    DRST
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">{{ $notifications->count() }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-scrollable">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu" style="list-style: none">
@if($notifications->isEmpty())
                                        <li style="text-align: center; font-size: 15px; color: brown;">No inbox found</li>
                                    @else
                                        @foreach($notifications as $notification)
                                            <li>
                                                @if($notification instanceof \App\Models\ProductNotifications)
                                                    <!-- Product Notification -->
                                                    <a href="#" onclick="markNotificationProduct('{{ $notification->id }}', '{{ $notification->product_id }}')">
                                                        <div class="icon-circle bg-orange">
                                                            <i class="material-icons">inventory_2</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>{{ $notification->product->product_name }} <br> <span style="color: brown">{{ $notification->message }}</span></h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </a>
                                                @else
                                                    <!-- Order Notification -->
                                                    <a href="#" onclick="markNotificationSeen('{{ $notification->reference_number }}', '{{ $notification->invoice_number }}')">
                                                        <div class="icon-circle bg-cyan">
                                                            <i class="material-icons">add_shopping_cart</i>
                                                        </div>
                                                        <div class="menu-info">
                                                            <h4>{{ $notification->reference_number }} <br> <span style="color: brown">{{ $notification->message }}</span></h4>
                                                            <p>
                                                                <i class="material-icons">access_time</i> {{ \Carbon\Carbon::parse($notification->notification_created_at)->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            {{-- <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li> --}}
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">account_circle</i></a></li>
                </ul>
            </div>
        </div>
    </nav>

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
    <script>
        function markNotificationProduct(id, product_id) {
            fetch(`/mark-product-notification-seen/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => {
                if (response.ok) {
                    console.log('Notification marked as seen successfully');
                    var url = "{{ route('admin.updateproducts', ['id' => 'REPLACE_PRODUCT_ID']) }}".replace('REPLACE_PRODUCT_ID', product_id);
                    console.log("Constructed URL:", url);
                    window.location.href = url;
                } else {
                    console.error('Failed to mark product notification as seen. Server response:', response.status);
                }
            })
            .catch(error => {
                console.error('Error marking product notification as seen:', error);
            });
        }
    </script>

    <script>
        function markNotificationSeen(referenceNumber, invoiceNumber) {
            fetch(`/mark-notification-seen/${referenceNumber}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    referenceNumber: referenceNumber,
                    invoiceNumber: invoiceNumber
                })
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = "{{ route('admin.orders.show', ['ReferenceNumber' => 'REPLACE_REFERENCE_NUMBER', 'InvoiceNumber' => 'REPLACE_INVOICE_NUMBER']) }}"
                        .replace('REPLACE_REFERENCE_NUMBER', referenceNumber)
                        .replace('REPLACE_INVOICE_NUMBER', invoiceNumber);
                } else {
                    console.error('Failed to mark notification as seen.');
                }
            })
            .catch(error => {
                console.error('Error marking notification as seen:', error);
            });
        }
    </script>



</body>
</html>