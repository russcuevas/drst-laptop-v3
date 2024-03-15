<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description">
    <meta name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link href="{{ asset('page/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />

    <style>
        .card {
            padding: 20px
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
            overflow-x: auto; /* Enable horizontal scrolling */
            max-width: 100%; /* Ensure the table container doesn't exceed the screen width */
            margin: 20px 0;
        }

        @media screen and (min-width: 768px) {
            .table-container {
                overflow-x: hidden;
            }
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
    @include('page.components.header')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" style="background-image: url('https://www.doka-shop.com.my/image/dokashop/image/data/about/main_about_rice.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        {{-- @if ($orders->isNotEmpty())
                            <h2>{{ $orders[0]->reference_number }}</h2>
                        @endif --}}
                        <div class="breadcrumb__option">
                            <a href="{{ route('homepage') }}">Home</a>
                            <span>Tracking Orders</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    

    <!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <div class="shoping__cart__table__title">
                        <h2>Your Order</h2>
                    </div>
                    <div class="shoping__cart__table__content">
                        <div class="card">
                            <div class="title">
                                <h4>Tracking #{{ $orders->first()->reference_number }}</h4>
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
                                        <div style="text-align: end" class="col-sm-12"><big>Total : ₱{{ number_format($totalSubtotal, 2) }}</big></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="tracking">
                    {{-- display the alert success --}}
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="title">Tracking Order</div>
                                </div>
                                    <form id="cancelForm" action="{{ route('cancel-myorders') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="referenceNumber" value="{{ $order->reference_number }}">
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
                                                        <label>&nbsp;</label>
                                                        <button type="button" id="cancelButton" class="btn btn-danger btn-block">Cancel orders</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

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
                                        {{-- <a href="#" onclick="" class="btn btn-danger btn-block">Delete</a> --}}
                                        @else
                                    @endif
                            </div>
                            <!-- Your form content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Shoping Cart Section End -->

    @include('page.components.footer')
    <!-- Js Plugins -->
    <script src="{{ asset('page/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('page/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('page/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('page/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('page/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('page/ajax/cart/update_cart.js')}}"></script>
    <script src="{{ asset('page/ajax/cart/delete_cart.js')}}"></script>
    <script src="{{ asset('page/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script>
        document.getElementById('cancelButton').addEventListener('click', function() {
            if (confirm('Are you sure? You won\'t be able to revert this!')) {
                document.getElementById('cancelForm').submit();
            }
        });
    </script>






</body>
</html>