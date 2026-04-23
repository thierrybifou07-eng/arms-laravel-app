<ul class="menu-inner py-1">
    <li class="menu-item active">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-pie-chart-alt-2"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
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
    <li class="menu-item">
        <a href="{{ route('super_adminaudits.index') }}" class="menu-link">
            <i class="menu-icon icon-base bx bx-history"></i>
            <div data-i18n="Audit Logs">Audit Logs</div>
        </a>
    </li>
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
