
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="{{asset('adminlte/img/AdminLTELogo.png')}}"  alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"> Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminlte/img/user2-160x160.jpg')}}"   class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">

              <a href="#" class="d-block">{{Auth::user()->name}}</a>

            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
               @can('category')
                <li class="nav-item">
                    <a href="{{url(route('category.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-list-alt"></i>
                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                @endcan

                @can('Client')
                <li class="nav-item">
                    <a href="{{url(route('client.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            clients
                        </p>
                    </a>
                </li>
                @endcan

                @can('City')
                <li class="nav-item">
                    <a href="{{url(route('city.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-city"></i>
                        <p>
                            cities
                        </p>
                    </a>
                </li>
                @endcan

                @can('Distriction')
                <li class="nav-item">
                    <a href="{{url(route('distriction.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-map-marker"></i>
                        <p>
                            Districtions
                        </p>
                    </a>
                </li>
                @endcan

                @can('Order')
                <li class="nav-item">
                    <a href="{{url(route('order.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                @endcan

                @can('Offer')
                <li class="nav-item">
                    <a href="{{url(route('offer.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-gift"></i>
                        <p>
                            Offers
                        </p>
                    </a>
                </li>
                @endcan

                @can('Restaurant')
                <li class="nav-item">
                    <a href="{{url(route('restaurant.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-bookmark"></i>
                        <p>
                            Restaurants
                        </p>
                    </a>
                </li>
                @endcan

                @can('Contacts')
                <li class="nav-item">
                    <a href="{{url(route('contact.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-phone"></i>
                        <p>
                            contacts
                        </p>
                    </a>
                </li>
                @endcan

                @can('Payment')
                <li class="nav-item">
                    <a href="{{url(route('payment.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            payments
                        </p>
                    </a>
                </li>
                @endcan

                @can('Paid')
                <li class="nav-item">
                    <a href="{{url(route('paid.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            paid

                        </p>
                    </a>
                </li>
                @endcan

                @can('User')
                    <li class="nav-item">
                        <a href="{{url(route('users.index'))}}" class="nav-link">
                            <i class="fa fa-user"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endcan

                @can('Role')
                    <li class="nav-item">
                        <a href="{{url(route('roles.index'))}}" class="nav-link">
                            <i class="fa fa-list"></i>
                            <p>Roles</p>
                        </a>
                    </li>

                @endcan

        @can('changePassword')
                <li class="nav-item">
                    <a href="{{url(route('change-pass'))}}" class="nav-link">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>
                            Chang Password

                        </p>
                    </a>
                </li>
        @endcan

                @can('Settings')
                <li class="nav-item">
                    <a href="{{url(route('setting.index'))}}" class="nav-link">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            settings
                        </p>
                    </a>
                </li>
                @endcan

               </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>
