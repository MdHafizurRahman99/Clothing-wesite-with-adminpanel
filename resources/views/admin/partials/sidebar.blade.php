<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-briefcase" aria-hidden="true"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">MPC Clothing</div>
    </a>

    {{-- @if (Auth::user()->can('staff.view'))
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff"
                aria-expanded="true" aria-controls="collapseStaff">
                <span>Staff informations</span>
            </a>

            <div id="collapseStaff" class="collapse" aria-labelledby="headingStaff" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('staff.index') }}">List</a>
                </div>
            </div>

        </li>
    @endif --}}
    <!-- Divider -->
    {{-- @if (Auth::user()->can('shift.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShift"
                aria-expanded="true" aria-controls="collapseShift">
                <span>Shifts</span>
            </a>
            <div id="collapseShift" class="collapse" aria-labelledby="headingShift" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('shift.index') }}">List</a>
                </div>
            </div>

        </li>
    @endif --}}
    {{-- @if (Auth::user()->can('staffschedule.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaffSchedule"
                aria-expanded="true" aria-controls="collapseStaffSchedule">
                <span>Schedules</span>
            </a>
            <div id="collapseStaffSchedule" class="collapse" aria-labelledby="headingStaffSchedule"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('staffschedule.index') }}">List</a>
                </div>
            </div>
        </li>
    @endif --}}

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}

    <!-- Divider -->
    {{-- @if (Auth::user()->can('client.add'))
        <hr class="sidebar-divider">
        <!-- Heading -->
        @if (Auth::user()->hasRole('Super Admin'))
            <div class="sidebar-heading">
                Client side
            </div>
        @endif
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                aria-expanded="true" aria-controls="collapseUser">
                <span>Request informations</span>
            </a>
            <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('client.add'))
                        <a class="collapse-item" href="{{ route('client.create') }}">Request Form</a>
                    @endif
                    <a class="collapse-item" href="{{ route('user.index') }}">My Requests</a>

                </div>
            </div>

        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('client_request.view'))
        <hr class="sidebar-divider">
        <!-- Heading -->
        @if (Auth::user()->hasRole('Super Admin'))
            <div class="sidebar-heading">
                Accountant side
            </div>
        @endif
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientRequest"
                aria-expanded="true" aria-controls="collapseClientRequest">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Client</span>
            </a>
            <div id="collapseClientRequest" class="collapse" aria-labelledby="headingClientRequest"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('client_request.add'))
                        <a class="collapse-item" href="{{ route('client_request.create') }}"> Add Client </a>
                    @endif

                    <a class="collapse-item" href="{{ route('client_request.index') }}"> List</a>

                </div>
            </div>
        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('client.view'))

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClient"
                aria-expanded="true" aria-controls="collapseClient">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Submited Requests</span>
            </a>
            <div id="collapseClient" class="collapse" aria-labelledby="headingClient" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('client.index') }}">Client Requests</a>
                </div>
            </div>
        </li>
 @endif --}}
    {{-- @if (Auth::user()->can('business.view'))
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBusiness"
                aria-expanded="true" aria-controls="collapseBusiness">
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <span>Business</span>
            </a>
            <div id="collapseBusiness" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('business.add'))
                        <a class="collapse-item" href="{{ route('business.create') }}">Add Business Profile</a>
                    @endif

                    <a class="collapse-item" href="{{ route('business.index') }}">Business Profile List</a>
                </div>
            </div>
        </li>
 @endif --}}

    @if (Auth::user()->can('product.view'))
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
                aria-expanded="true" aria-controls="collapseProduct">
                <span>Product</span>
            </a>
            <div id="collapseProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}


                    @if (Auth::user()->can('product.add'))
                        <a class="collapse-item" href="{{ route('pattern.index') }}">Patterns</a>
                    @endif
                    <a class="collapse-item" href="{{ route('product.index') }}">All Product </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('category.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
                aria-expanded="true" aria-controls="collapseCategory">
                <span>Category</span>
            </a>
            <div id="collapseCategory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('category.add'))
                        <a class="collapse-item" href="{{ route('category.create') }}">Add Category </a>
                    @endif
                    <a class="collapse-item" href="{{ route('category.index') }}">All Category </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif
    @if (Auth::user()->can('color.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseColor"
                aria-expanded="true" aria-controls="collapseColor">
                <span>Color</span>
            </a>
            <div id="collapseColor" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('color.add'))
                        <a class="collapse-item" href="{{ route('color.create') }}">Add Color </a>
                    @endif
                    <a class="collapse-item" href="{{ route('color.index') }}">All Color </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('product.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProductInventory"
                aria-expanded="true" aria-controls="collapseProductInventory">
                <span>Product Stock</span>
            </a>
            <div id="collapseProductInventory" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('product.add'))
                        <a class="collapse-item" href="{{ route('product.inventory.list') }}">Inventory</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('order.view'))
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders"
            aria-expanded="true" aria-controls="collapseOrders">
            <span>Orders</span>
        </a>
        <div id="collapseOrders" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}

                <a class="collapse-item" href="{{ route('admin-order.index') }}"> Orders </a>

                <a class="collapse-item" href="{{ route('custom-order.index') }}"> Custom Order </a>
                {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
            </div>
        </div>
    </li>
@endif

    @if (Auth::user()->can('permission.view'))
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePermission"
                aria-expanded="true" aria-controls="collapsePermission">
                <span>Permission</span>
            </a>
            <div id="collapsePermission" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('permission.add'))
                        <a class="collapse-item" href="{{ route('permission.create') }}">Add Permission </a>
                    @endif
                    <a class="collapse-item" href="{{ route('permission.index') }}">All Permission </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('role.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole"
                aria-expanded="true" aria-controls="collapseRole">
                <span>Role</span>
            </a>
            <div id="collapseRole" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('role.add'))
                        <a class="collapse-item" href="{{ route('role.create') }}">Add Role </a>
                    @endif

                    <a class="collapse-item" href="{{ route('role.index') }}">All Roles </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('roles_permission.view'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolesPermissions"
                aria-expanded="true" aria-controls="collapseRolesPermissions">
                <span>Roles Permissions</span>
            </a>
            <div id="collapseRolesPermissions" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Auth::user()->can('roles_permission.add'))
                        <a class="collapse-item" href="{{ route('roles-permission.create') }}">Add Roles Permissions
                        </a>
                    @endif

                    <a class="collapse-item" href="{{ route('roles-permission.index') }}">All Roles Permissions </a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('sales_representative.view'))
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseSalesRepresentative" aria-expanded="true"
                aria-controls="collapseSalesRepresentative">
                <span>Sales Representative</span>
            </a>
            <div id="collapseSalesRepresentative" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('sales_representative.add'))
                        <a class="collapse-item" href="{{ route('sales-representative.create') }}">Add Sales
                            Representative </a>
                    @endif
                    <a class="collapse-item" href="{{ route('sales-representative.index') }}">All Sales
                        Representatives </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->can('admin.view'))
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                aria-expanded="true" aria-controls="collapseAdmin">
                <span>Admin</span>
            </a>
            <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                    @if (Auth::user()->can('admin.add'))
                        <a class="collapse-item" href="{{ route('admin.create') }}">Add Admin </a>
                    @endif
                    <a class="collapse-item" href="{{ route('admin.index') }}">All Admins </a>
                    {{-- <a class="collapse-item" href="cards.html">Cards</a> --}}
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
