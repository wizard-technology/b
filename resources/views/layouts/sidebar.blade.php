<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left">
        <i class="ion-close"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left">
        <br>
        <br>
        <div class="text-center">
            <a href="/" class="logo">
               <h5>{{$dashboard_admin->u_first_name }} {{$dashboard_admin->u_second_name }}</h5>
         
            </a>
        </div>
        <br>

    </div>


    <div class="sidebar-inner slimscrollleft" id="sidebar-main">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Overview
                </li>
                <li>
                    <a href="{{route('dashboard.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'index' ? 'active' : ''}}">
                        <i data-feather="pie-chart"></i>
                        <span>
                            Dashboard</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.company.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'company' ? 'active' : ''}}"><i
                            data-feather="briefcase"></i><span>
                            Companies</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.type.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'type' ? 'active' : ''}}"><i
                            data-feather="flag"></i><span>
                            Categories</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.subcategory.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'subcategory' ? 'active' : ''}}"><i
                            data-feather="folder"></i><span>
                            Subcategories</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.grouped.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'grouped' ? 'active' : ''}}"><i
                            data-feather="grid"></i><span>
                                Grouped</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.tag.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'tag' ? 'active' : ''}}">
                        <i data-feather="hash"></i>
                        <span> Hashtags</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.product.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'product' ? 'active' : ''}}"><i
                            data-feather="package"></i><span>
                            Products</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.card.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName())== 'card' ? 'active' : ''}}"><i
                            data-feather="credit-card"></i><span>
                            Card</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.support.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'support' ? 'active' : ''}}"><i
                            data-feather="headphones"></i><span>
                            Support</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.employee.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'employee' ? '' : ''}}"><i
                            data-feather="user"></i><span>
                            Employee</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.city.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'city' ? 'active' : ''}}"><i
                            data-feather="map-pin"></i><span>
                            Cities</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.user.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName())== 'user' ? 'active' : ''}}"><i
                            data-feather="users"></i><span>
                            Users</span></a>
                </li>
                
                <li>
                    <a href="calendar.html"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'index' ? '' : ''}}"><i
                            data-feather="shopping-bag"></i><span>
                            Orders</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.setting.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'setting' ? 'active' : ''}}"><i
                            data-feather="settings"></i><span>
                            Settings</span></a>
                </li>
                <li>
                    <a href="{{route('dashboard.bizzcoin.index')}}"
                        class="waves-effect {{getCurrentRoute(Route::currentRouteName() )== 'bizzcoin' ? 'active' : ''}}"><i
                            data-feather="activity"></i><span>
                            Bizzcoin Price</span></a>
                </li>
                

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>