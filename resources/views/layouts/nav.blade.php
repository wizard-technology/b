     <!-- Top Bar Start -->
     <div class="topbar">
        <nav class="navbar-custom">
            <ul class="list-inline float-right mb-0">
                
                {{-- <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light"
                        data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti-email noti-icon"></i>
                        <span class="badge badge-danger noti-icon-badge">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5><span class="badge badge-danger float-right">5</span>Messages</h5>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon"><img src="assets/images/users/avatar-2.jpg"
                                    alt="user-img" class="img-fluid rounded-circle" /> </div>
                            <p class="notify-details"><b>Charles M. Jones</b><small class="">Dummy text of
                                    the printing and typesetting industry.</small></p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon"><img src="assets/images/users/avatar-3.jpg"
                                    alt="user-img" class="img-fluid rounded-circle" /> </div>
                            <p class="notify-details"><b>Thomas J. Mimms</b><small class="">You have 87
                                    unread messages</small></p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon"><img src="assets/images/users/avatar-4.jpg"
                                    alt="user-img" class="img-fluid rounded-circle" /> </div>
                            <p class="notify-details"><b>Luis M. Konrad</b><small class="">It is a long
                                    established fact that a reader will</small></p>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            View All
                        </a>
                    </div>
                </li>

                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light"
                        data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti-bell noti-icon"></i>
                        <span class="badge badge-success noti-icon-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5><span class="badge badge-success float-right">9</span>Notification</h5>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                            <p class="notify-details"><b>Your order is placed</b><small class="">Dummy text
                                    of the printing and typesetting industry.</small></p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-success"><i class="mdi mdi-message"></i></div>
                            <p class="notify-details"><b>New Message received</b><small class="">You have 87
                                    unread messages</small></p>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-warning"><i class="mdi mdi-martini"></i></div>
                            <p class="notify-details"><b>Your item is shipped</b><small class="">It is a
                                    long established fact that a reader will</small></p>
                        </a>
                        <div class="dropdown-divider"></div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            View All
                        </a>
                    </div>
                </li> --}}

                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user"
                        data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <img src="{{asset('assets/images/users/user.jpg')}}" alt="user" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5>Welcome</h5>
                        </div>
                        <a class="dropdown-item" href="{{route('dashboard.profile.edit',session('dashboard'))}}"><i class="mdi mdi-account-circle "></i>
                            Profile</a>
                        <a class="dropdown-item" href="{{route('dashboard.setting.index')}}"><i
                                class="mdi mdi-settings "></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{route('dashboard.logout')}}"><i data-feather="log-out"></i> Logout</a>
                    </div>
                </li>
            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-light waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                <li class="hide-phone app-search">
                </li>
            </ul>
            <div class="clearfix"></div>
        </nav>
    </div>