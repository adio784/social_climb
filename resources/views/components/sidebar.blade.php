<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item active ">
            <a href="index.html" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-stack"></i>
                <span>Users</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="{{ route('list-admins') }}">Admin</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('list-users') }}">Users</a>
                </li>
            </ul>
        </li>

        {{-- History route --}}
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-collection-fill"></i>
                <span>History</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="{{ route('funds-history') }}">Fund History</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('data-history') }}">Data History</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('airtime-history') }}">Airtime History</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('bill-history') }}">Bill History</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('cable-history') }}">Cable History</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('orders') }}">Orders</a>
                </li>
            </ul>
        </li>

        {{-- Pricing route --}}
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Pricing</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="{{ route('data-pricing') }}">Data Pricing</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('airtime-pricing') }}">Airtime Pricing</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('bill-pricing') }}">Bill Pricing</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('cable-pricing') }}">Cable Pricing</a>
                </li>
                <li class="submenu-item ">
                    <a href="{{ route('socio-pricing') }}">Social Pricing</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-title">Other Links &amp;</li>

        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-hexagon-fill"></i>
                <span>Settings</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="form-element-input.html">Services</a>
                </li>
                <li class="submenu-item ">
                    <a href="form-element-input-group.html">Notification</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item  ">
            <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-medical-fill"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-pencil"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</div>
