<ul class="menu-inner py-1">
    <li class="menu-item active">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-pie-chart-alt-2"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="{{ route('residences.index') }}" class="menu-link">
            <i class="menu-icon icon-base bx bx-home"></i>
            <div data-i18n="Residences">Residences</div>
        </a>
    </li>
{{--     <li class="menu-item">
        <a href="{{ route('residences.rooms',$residence) }}" class="menu-link">
            <i class="menu-icon icon-base bx bx-room"></i>
            <div data-i18n="Rooms">Rooms</div>
        </a>
    </li> --}}
    <li class="menu-item">
        <a href="{{ route('contracts.index') }}" class="menu-link">
            <i class="menu-icon icon-base bx bx-food-menu"></i>
            <div data-i18n="Contracts">Contracts</div>
        </a>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-money"></i>
            <div data-i18n="Finance">Finance</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('payments.index') }}" class="menu-link">
                    <div data-i18n="Payments">Payments</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('payment_histories.index') }}" class="menu-link">
                    <div data-i18n="Payment Histories">Payment Histories</div>
                </a>
            </li>
{{--             <li class="menu-item">
                <a href="{{ route('event_payment_types.index') }}" class="menu-link">
                    <div data-i18n="Event Payment Types">Event Payment Types</div>
                </a>
            </li> --}}
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-user"></i>
            <div data-i18n="Users">Users</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <div data-i18n="Users List">Users List</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('activate_accountpending_users.index') }}" class="menu-link">
                    <div data-i18n="Pending Users">Pending Users</div>
                </a>
            </li>
        </ul>
    </li>
{{--     <li class="menu-item">
        <a href="{{ route('roles.index') }}" class="menu-link">
            <i class="menu-icon icon-base bx bx-check-shield"></i>
            <div data-i18n="Roles">Roles</div>
        </a>
    </li> --}}
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-lock-open-alt"></i>
            <div data-i18n="Account">Account</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('profile.show') }}" class="menu-link">
                    <div data-i18n="My Profile">My Profile</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <div data-i18n="Settings">Settings</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
