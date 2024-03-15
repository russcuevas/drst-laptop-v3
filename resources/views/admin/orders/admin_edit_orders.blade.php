<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Sweetalert Css -->
    <link href="{{ asset('admin/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
    <style>
        body{
            background: #ddd3;
            height: 100vh;
            vertical-align: middle;
            display: flex;
            font-family: 'Times New Roman', Times, serif
            font-size: 14px;    
        }
        .card{
            margin: auto;
            width: 38%;
            max-width:600px;
            padding: 4vh 0;
            box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-top: 3px solid #0f3d71;
            border-bottom: 3px solid #0f3d71;
            border-left: none;
            border-right: none;
        }
        @media(max-width:768px){
            .card{
                width: 90%;
            }
        }
        .title{
            color: #0f3d71;
            font-weight: 600;
            margin-bottom: 2vh;
            padding: 0 8%;
            font-size: initial;
        }
        #details{
            font-weight: 400;
        }
        .info{
            padding: 5% 8%;
        }
        .info .col-5{
            padding: 0;
        }
        #heading{
            color: grey;
            line-height: 6vh;
        }
        .pricing{
            background-color: #ddd3;
            padding: 2vh 8%;
            font-weight: 400;
            line-height: 2.5;
        }
        .pricing .col-3{
            padding: 0;
        }
        .total{
            padding: 2vh 8%;
            color: #0f3d71;
            font-weight: bold;
        }
        .total .col-3{
            padding: 0;
        }
        .footer{
            padding: 0 8%;
            font-size: x-small;
            color: black;
        }
        .footer img{
            height: 5vh;
            opacity: 0.2;
        }
        .footer a{
            color: #0f3d71;
        }
        .footer .col-10, .col-2{
            display: flex;
            padding: 3vh 0 0;
            align-items: center;
        }
        .footer .row{
            margin: 0;
        }
            #progressbar {
            margin-bottom: 3vh;
            overflow: hidden;
            color: #0f3d71;
            padding-left: 0px;
            margin-top: 3vh
        }

        #progressbar li {
            list-style-type: none;
            font-size: x-small;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400;
            color: rgb(160, 159, 159);
        }

        #progressbar #step1:before {
            content: "";
            color: #0f3d71;
            width: 5px;
            height: 5px;
            margin-left: 0px !important;
            /* padding-left: 11px !important */
        }

        #progressbar #step2:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-left: 32%;
        }

        #progressbar #step3:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 32%;
            /* padding-right: 11px !important */
        }

        #progressbar #step4:before {
            content: "";
            color: #fff;
            width: 5px;
            height: 5px;
            margin-right: 0px !important;
            /* padding-right: 11px !important */
        }

        #progressbar li:before {
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: #ddd;
            border-radius: 50%;
            margin: auto;
            z-index: -1;
            margin-bottom: 1vh;
        }

        #progressbar li:after {
            content: '';
            height: 2px;
            background: #ddd;
            position: absolute;
            left: 0%;
            right: 0%;
            margin-bottom: 2vh;
            top: 1px;
            z-index: 1;
        }

        .progress-track {
            padding: 0 8%;
        }

        #progressbar li:nth-child(2):after {
            margin-right: auto;
        }

        #progressbar li:nth-child(1):after {
            margin: auto;
        }

        #progressbar li:nth-child(3):after {
            float: left;
            width: 68%;
        }

        #progressbar li:nth-child(4):after {
            margin-left: auto;
            width: 132%;
        }

        #progressbar li.active {
            color: black;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #0f3d71;
        }

        /* order tracking */
        .table-container {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin: 20px 0;
        }

        .table-header {
            background-color: #0f3d71;
            padding: 5px;
            text-align: center;
        }


        .table-row {
            display: flex;
            width: 120%;
            border-bottom: 1px solid #ddd;
        }

        .table-column {
            flex: 1;
            padding: 10px;
            text-align: left;
        }

        .table-footer {
            background-color: #0f3d71;
            padding: 10px;
            text-align: end;
            font-weight: bold;
        }
    </style>
    </head>
    <body>
        <div class="card">
            <div class="title">
                <a href="{{ route('admin.orders')}}">Go back</a> <br>
                Tracking #{{ $orders->first()->reference_number }}
            @if ($orders->first()->order_status === 'Delivered')
                <div class="paid-banner">
                    <span class="badge badge-success">Paid</span>
                </div>
            @else
                <div class="paid-banner">
                    <span class="badge badge-danger">Not paid</span>
                </div>
            @endif
            </div>
            <div class="info">
                <div class="row">
                    <div class="col-12">
                        <h5>Order details </h5>
                        <p style="margin-bottom: 0px !important;">Ordered date: {{ \Carbon\Carbon::parse($orders->first()->created_at)->format('M-d-Y, h:iA') }}
                        <p style="margin-bottom: 0px !important;">Payment method : {{ $orders->first()->payment_method }} </p>                        
                        <p style="margin-bottom: 0px !important;">Customer : {{ $orders->first()->fullname }}</p>
                        <p style="margin-bottom: 0px !important;">Delivery address : {{ $orders->first()->address }} </p>
                        <p>Contact No : {{ $orders->first()->contact }}</p>

                    </div>
                </div>      
            </div>      
            <div class="pricing">
                <div class="table-container">
                    <div class="table-row">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    <strong>Products</strong>
                                </div>
                                <div class="col-4">
                                    <strong>Quantity</strong>
                                </div>
                                <div class="col-4">
                                    <strong>Subtotal</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($orders as $order)
                    <div class="table-row">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    {{ $order->products_ordered }}
                                </div>
                                <div class="col-4">
                                    {{ $order->total_quantity }}
                                </div>
                                <div class="col-4">
                                    ₱{{ $order->subtotal }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            @php
                $totalSubtotal = 0;
            @endphp

            @foreach ($orders as $order)
                @php
                    $totalSubtotal += $order->subtotal;
                @endphp
            @endforeach

            <div class="total">
                <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3"><big>₱{{ number_format($totalSubtotal, 2) }}</big></div>
                </div>
            </div>
            <div class="tracking">
                {{-- display the alert success --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="title">Tracking Order</div>
            </div>
            <form action="{{ route('updateOrdersStatus', ['referenceNumber' => $order->reference_number, 'invoiceNumber' => $order->invoice_number]) }}" method="POST">
                @csrf
                <input type="hidden" name="referenceNumber" value="{{ $order->reference_number }}">
                <input type="hidden" name="invoiceNumber" value="{{ $order->invoice_number }}">
                @if ($order->order_status === 'Placed orders')
                    <div class="progress-track">
                        <ul id="progressbar">
                            <li class="step0 active " id="step1">{{ $order->order_status }} <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->placed_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->placed_at)->format('h:iA') }}</span> </li>
                            <li class="step0 text-center" id="step2">On process</li>
                            <li class="step0 text-right" id="step3">On the way</li>
                            <li class="step0 text-right" id="step4">Delivered</li>
                        </ul>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status">Select Status:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="On process">On process</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Edit Status</button>
                                <a href="#" onclick="confirmCancel('{{ route('cancelorder', ['referenceNumber' => $order->reference_number, 'invoiceNumber' => $order->invoice_number]) }}')" class="btn btn-danger btn-block">Cancel Order</a>
                            </div>
                        </div>
                    </div>
                @elseif ($order->order_status === 'On process')
                    <div class="progress-track">
                        <ul id="progressbar">
                            <li class="step0 active " id="step1">{{ $order->order_initial_status }} <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->placed_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->placed_at)->format('h:iA') }}</span> </li>
                            <li class="step0 active text-center" id="step2">{{ $order->order_status }} <br> 
                                <span style="color: #777">{{ \Carbon\Carbon::parse($order->on_process_at)->format('M-d-Y') }} <br> 
                                {{ \Carbon\Carbon::parse($order->on_process_at)->format('h:iA') }}
                                </span> 
                            </li>
                            <li class="step0 text-right" id="step3">On the way</li>
                            <li class="step0 text-right" id="step4">Delivered</li>
                        </ul>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Select Status:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="On the way">On the way</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="on_the_way_at">Delivery Date and Time:</label>
                            <input type="datetime-local" class="form-control" name="on_the_way_at" id="on_the_way_at" required>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Edit Status</button>
                            </div>
                        </div>
                    </div>
                @elseif ($order->order_status === 'On the way' )
                    <div class="progress-track">
                        <ul id="progressbar">
                            <li class="step0 active " id="step1">Placed orders <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->placed_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->placed_at)->format('h:iA') }}</span> </li>
                            <li class="step0 active text-center" id="step2">{{ $order->order_initial_status }} <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->on_process_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->on_process_at)->format('h:iA') }}</span> </li>
                            <li class="step0 active text-right" id="step3">{{ $order->order_status }} <br> <span style="color: brown">Delivery date <br> {{ \Carbon\Carbon::parse($order->on_the_way_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->on_the_way_at)->format('h:iA') }} </span> </li>
                            <li class="step0 text-right" id="step4">Delivered</li>
                        </ul>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="payment_method" value="{{ $order->payment_method }}">
                        <input type="hidden" name="fullname" value="{{ $order->fullname }}">
                        <input type="hidden" name="email" value="{{ $order->email }}">
                        <input type="hidden" name="address" value="{{ $order->address }}">
                        @php
                            $productQuantities = [];

                            foreach ($orders as $order) {
                                $productsOrderedArray = explode(',', $order->products_ordered);

                                foreach ($productsOrderedArray as $product) {
                                    $productName = trim($product);

                                    if (!isset($productQuantities[$productName])) {
                                        $productQuantities[$productName] = 0;
                                    }

                                    $productQuantities[$productName] += $order->total_quantity;
                                }
                            }

                            $combinedProductQuantities = '';

                            foreach ($productQuantities as $productName => $totalQuantity) {
                                $combinedProductQuantities .= $productName . ' (' . $totalQuantity . '), ';
                            }

                            $combinedProductQuantities = rtrim($combinedProductQuantities, ', ');
                        @endphp
                        <input type="hidden" name="products_ordered" value="{{ $combinedProductQuantities }}">
                        <input type="hidden" name="total_amount" value="{{ $totalSubtotal }}" step="any">
                        <input type="hidden" name="ordered_date" value="{{ $order->created_at }}">
                        <input type="hidden" name="receiving_date">

                        {{-- top products --}}
                        @foreach ($orders as $singleOrder)
                            <input type="hidden" name="products[]" value="{{ $singleOrder->product_id }}">
                            <input type="hidden" name="total_sold[]" value="{{ $singleOrder->total_quantity }}">
                        @endforeach
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Select Status:</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="On the way">On the way</option>
                                    <option value="Delivered" selected>Delivered</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"  id="onTheWayDateContainer">
                            <div class="form-group">
                                <label for="on_the_way_at">Delivery Date and Time:</label>
                                <input type="datetime-local" class="form-control" name="on_the_way_at" id="on_the_way_at" required>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Edit Status</button>
                                </div>
                            </div>
                        </div>
                @elseif ($order->order_status === 'Delivered')
                    <div class="progress-track">
                        <ul id="progressbar">
                            <li class="step0 active " id="step1">Placed orders <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->placed_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->placed_at)->format('h:iA') }}</span></li>
                            <li class="step0 active text-center" id="step2">On process <br> <span style="color: #777">{{ \Carbon\Carbon::parse($order->on_process_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->on_process_at)->format('h:iA') }} </span></li>
                            <li class="step0 active text-right" id="step3">{{ $order->order_initial_status }} <br> <span style="color: brown">Estimated delivery <br> {{ \Carbon\Carbon::parse($order->on_the_way_at)->format('M-d-Y') }} <br> {{ \Carbon\Carbon::parse($order->on_the_way_at)->format('h:iA') }} </span></li>
                            <li class="step0 active text-right" id="step4">{{ $order->order_status }} <br> 
                            <span style="color: green">
                                {{ \Carbon\Carbon::parse($order->delivered_at)->format('M-d-Y') }} <br>
                                {{ \Carbon\Carbon::parse($order->delivered_at)->format('h:iA') }}
                            </span>
                            </li>
                        </ul>
                    </div>
                <a href="#" onclick="confirmDelete('{{ route('deletecompleted', ['referenceNumber' => $order->reference_number, 'invoiceNumber' => $order->invoice_number]) }}')" class="btn btn-danger btn-block">Delete</a>
                @else
                @endif
            </form>
        </div>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js')}}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var onTheWayDateContainer = document.getElementById('onTheWayDateContainer');
                var statusSelect = document.getElementById('status');
                var onTheWayInput = document.getElementById('on_the_way_at');

                function toggleOnTheWayDate() {
                    onTheWayDateContainer.style.display = (statusSelect.value === 'On the way') ? 'block' : 'none';
                    onTheWayInput.disabled = (statusSelect.value !== 'On the way');
                }

                statusSelect.addEventListener('change', toggleOnTheWayDate);

                toggleOnTheWayDate();
            });
        </script>
        <script src="{{ asset('admin/js/orders_management.js')}}"></script>

</body>
</html>