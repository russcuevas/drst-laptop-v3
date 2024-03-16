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
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu" style="list-style: none">
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