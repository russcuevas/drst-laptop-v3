        <aside id="leftsidebar" class="sidebar">
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header" style="font-size:14px !important; color: #333 !important;">Welcome <br> <label style="font-weight:700; color:#073186;">{{ Auth::user()->fullname }}</label></li>
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.users', 'admin.addusers') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">groups</i>
                            <span>User Management</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <a href="{{ route('admin.users')}}">User List</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.addusers') ? 'active' : '' }}">
                                <a href="{{ route('admin.addusers')}}">Add user</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('admin.products', 'admin.addproducts') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">inventory</i>
                            <span>Inventory Management</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{ request()->routeIs('admin.products') ? 'active' : '' }}">
                                <a href="{{ route('admin.products')}}">Product List</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.addproducts') ? 'active' : '' }}">
                                <a href="{{ route('admin.addproducts')}}">Add product</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('admin.orders', 'admin.invoice') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">local_shipping</i>
                            <span>Transactions</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                                <a href="{{ route('admin.orders')}}">Orders List</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.invoice') ? 'active' : '' }}">
                                <a href="{{ route('admin.invoice') }}">Invoice List</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports') }}">
                            <i class="material-icons">analytics</i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                        <a href="{{ route('admin.analytics') }}">
                            <i class="material-icons">pie_chart</i>
                            <span>Analytics</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <!-- <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div> -->
            </div>
            <!-- #Footer -->
        </aside>