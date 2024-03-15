        <aside id="leftsidebar" class="sidebar">
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                <li class="header" style="font-size:14px !important; color: #333 !important;">Welcome <br> <label style="font-weight:700; color:#073186;">{{ Auth::user()->fullname }}</label></li>
                    <li class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('staff.dashboard') }}">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('staff.reports') ? 'active' : '' }}">
                        <a href="{{ route('staff.reports')}}">
                            <i class="material-icons">analytics</i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('staff.analytics') ? 'active' : '' }}">
                        <a href="{{ route('staff.analytics')}}">
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