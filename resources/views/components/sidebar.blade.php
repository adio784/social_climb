<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item active ">
            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if ($permissions->contains('view users'))
            <li class="sidebar-item  has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-stack"></i>
                    <span>Users</span>
                </a>
                <ul class="submenu ">
                    @if ($permissions->contains('view users'))
                        <li class="submenu-item ">
                            <a href="{{ route('list-admins') }}">Admin</a>
                        </li>
                    @endif
                    @if ($permissions->contains('view admins'))
                        <li class="submenu-item ">
                            <a href="{{ route('list-users') }}">Users</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if ($permissions->contains('view histories'))
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
        @endif

        {{-- Pricing route --}}
        @if ($permissions->contains('view pricings'))
            <li class="sidebar-item  has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Pricing</span>
                </a>
                <ul class="submenu ">
                    @if ($permissions->contains('data pricings'))
                        <li class="submenu-item ">
                            <a href="{{ route('data-pricing') }}">Data Pricing</a>
                        </li>
                    @endif

                    @if ($permissions->contains('airtime pricings'))
                        <li class="submenu-item ">
                            <a href="{{ route('airtime-pricing') }}">Airtime Pricing</a>
                        </li>
                    @endif

                    @if ($permissions->contains('bill pricings'))
                        <li class="submenu-item ">
                            <a href="{{ route('bill-pricing') }}">Bill Pricing</a>
                        </li>
                    @endif

                    @if ($permissions->contains('cable pricings'))
                        <li class="submenu-item ">
                            <a href="{{ route('cable-pricing') }}">Cable Pricing</a>
                        </li>
                    @endif

                    @if ($permissions->contains('socio pricings'))
                        <li class="submenu-item ">
                            <a href="{{ route('socio-pricing') }}">Social Pricing</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="sidebar-title">Other Links &amp;</li>

        @if ($permissions->contains('services') || $permissions->contains('notifications'))
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-hexagon-fill"></i>
                <span>Settings</span>
            </a>
            <ul class="submenu ">
                @if ($permissions->contains('services'))
                    <li class="submenu-item ">
                        <a href="{{ route('service.index') }}">Services</a>
                    </li>
                @endif

                @if ($permissions->contains('notifications'))
                    <li class="submenu-item ">
                        <a href="{{ route('notification.index') }}">Notification</a>
                    </li>
                @endif
            </ul>
        </li>
        @endif

        <li class="sidebar-item  ">
            <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-medical-fill"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="sidebar-item">

            {{-- Authentication --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();"
                    class='sidebar-link'>
                    <i class="bi bi-pencil"></i>
                    <span>{{ __('Log Out') }}</span>
                </a>
            </form>

            {{-- <a href="#" class='sidebar-link'>

                <span>Logout</span>
            </a> --}}
        </li>

    </ul>
</div>
