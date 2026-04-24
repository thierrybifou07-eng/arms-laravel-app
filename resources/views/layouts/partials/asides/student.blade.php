<ul class="menu-inner py-1">
    <li class="{{ $menuItemClass('dashboard') }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-pie-chart-alt-2"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    <li class="{{ $menuTreeClass('profile.show', 'profile.edit', 'profile.update') }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-user"></i>
            <div data-i18n="Account">Account</div>
        </a>
        <ul class="menu-sub">
            <li class="{{ $menuItemClass('profile.show') }}">
                <a href="{{ route('profile.show') }}" class="menu-link">
                    <div data-i18n="My Profile">My Profile</div>
                </a>
            </li>
            <li class="{{ $menuItemClass('profile.edit', 'profile.update') }}">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <div data-i18n="Settings">Settings</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
