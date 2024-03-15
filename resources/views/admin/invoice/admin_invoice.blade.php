

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>
    <!-- Favicon-->
    <link rel="icon" href="../../images/login/logo-kll.jpg" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('admin/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('admin/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="{{ asset('admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{ asset('admin/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('admin/css/themes/all-themes.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <li><a href="{{ route('admin.dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                    <li class="active"><i class="material-icons">local_shipping</i> Transactions</li>
                    <li class="active"><i class="material-icons">receipt</i> Invoice</li>
                </ol>
            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                INVOICE LIST
                            </h2>
                        </div>
                        <div class="body">
                            {{-- <div>
                                <a href="{{ route('admin.addusers')}}" class="btn btn-tealbtn bg-custom waves-effect btn-lg" style="margin-bottom: 15px;">+ Add users</a>
                            </div> --}}
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
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="color: #0e0e0e !important; margin-top: 20px !important;">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Invoice Number</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($invoices->count() > 0)
                                            @php $count = 1 @endphp
                                            @foreach($invoices as $invoice)
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <td>₱{{ $invoice->total_amount }}</td>
                                                    @if ($invoice->order_status === 'Delivered')
                                                        <td style="color: green">Paid</td>
                                                    @else
                                                        <td style="color: brown">Not paid</td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ route('admin.invoice.show', ['InvoiceNumber' => $invoice->invoice_number])}}" style="color: #002b53; text-decoration: none;"><i class="fa-solid fa-eye"></i> View</a>
                                                    </td>
                                                </tr>
                                                @php $count++ @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No invoices available</td>
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
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('admin/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('admin/plugins/node-waves/waves.js')}}"></script>

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

    <!-- Custom Js -->
    <script src="{{ asset('admin/js/admin.js')}}"></script>
    <script src="{{ asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{ asset('admin/js/pages/forms/form-validation.js')}}"></script>
    <script src="{{ asset('admin/js/products_management.js')}}"></script>
    <!-- Demo Js -->
    <script src="{{ asset('admin/js/demo.js')}}"></script>
</body>

</html>