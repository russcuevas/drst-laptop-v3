<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('admin/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/invoice.css')}}">
    <title>Invoice page</title>
</head>
<body>
    <div class="container">
        <div class="col-md-12">
            <div class="invoice">
                <!-- begin invoice-company -->
                <div class="invoice-company text-inverse f-w-600">
                    <span class="pull-right hidden-print">
                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-danger m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
                    </span>
                    Dimasupil's
                    @if ($invoices->first()->order_status === 'Delivered')
                        <div class="paid-banner">
                            <span class="badge badge-success" style="background-color: green">Paid</span>
                        </div>
                    @else
                        <div class="paid-banner">
                            <span class="badge badge-danger" style="background-color: brown">Not paid</span>
                        </div>
                    @endif
                </div>
                <!-- end invoice-company -->
                <!-- begin invoice-header -->
                <div class="invoice-header">
                    <div class="invoice-from">
                    <small>From</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">Example name</strong><br>
                        Example address<br>
                        Example contact<br>
                    </address>
                    </div>
                    <div class="invoice-to">
                    <small>To</small>
                    <address class="m-t-5 m-b-5">
                        <strong class="text-inverse">{{ $invoices->first()->fullname }}</strong><br>
                        {{ $invoices->first()->address }}<br>
                        {{ $invoices->first()->contact }}<br>
                    </address>
                    </div>
                    <div class="invoice-date">
                    <small>Invoice</small>
                    {{-- <div class="date text-inverse m-t-5">August 3,2012</div> --}}
                    <div class="invoice-detail">
                        #{{ $invoices->first()->invoice_number }}<br>
                        Rice services
                    </div>
                    </div>
                </div>
                <!-- end invoice-header -->
                <!-- begin invoice-content -->
                <div class="invoice-content">
                    <!-- begin table-responsive -->
                    <div class="table-responsive">
                    <table class="table table-invoice">
                        <thead>
                            <tr>
                                <th>PRODUCTS ORDERED</th>
                                <th class="text-center" width="10%">QUANTITY</th>
                                {{-- <th class="text-center" width="10%">SUB</th> --}}
                                <th class="text-right" width="20%">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>
                                <span class="text-inverse">{{ $invoice->products_ordered }}</span><br>
                                </td>
                                <td class="text-center">{{ $invoice->total_quantity }}</td>
                                {{-- <td class="text-center">50</td> --}}
                                <td class="text-right">₱{{ $invoice->subtotal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    @php
                        $total_amount = 0;
                    @endphp

                    @foreach ($invoices as $invoice)
                        @php
                            $total_amount += $invoice->subtotal;
                        @endphp
                    @endforeach
                    <!-- end table-responsive -->
                    <!-- begin invoice-price -->
                    <div class="invoice-price">
                    <div class="invoice-price-left">
                        <div class="invoice-price-row">
                        </div>
                    </div>
                    <div class="invoice-price-right">
                        <small>TOTAL</small> <span class="f-w-600">₱{{ number_format($total_amount, 2) }}</span>
                    </div>
                    </div>
                    <!-- end invoice-price -->
                </div>
                <!-- end invoice-content -->
                <!-- begin invoice-note -->
                <div class="invoice-note">
                    * If you have any questions concerning this invoice, contact  Name, Phone Number, Email
                </div>
                <!-- end invoice-note -->
                <!-- begin invoice-footer -->
                <div class="invoice-footer">
                    <p class="text-center m-b-5 f-w-600">
                    THANK YOU FOR ORDERING
                    </p>
                    {{-- <p class="text-center">
                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> matiasgallipoli.com</span>
                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T:016-18192302</span>
                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> rtiemps@gmail.com</span>
                    </p> --}}
                </div>
                <!-- end invoice-footer -->
            </div>
        </div>
        </div>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.js')}}"></script>
</body>
</html>