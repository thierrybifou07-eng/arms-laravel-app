<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
        data-bs-auto-close="outside" aria-expanded="false">
        <i class="icon-base bx bx-grid-alt icon-md"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end p-0">
        <div class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
                <h6 class="mb-0 me-auto">Student Shortcuts</h6>
            </div>
        </div>
        <div class="dropdown-shortcuts-list scrollable-container ps">
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-pie-chart-alt-2 icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('dashboard') }}" class="stretched-link">Dashboard</a>
                    <small>My overview</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-user icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('profile.show') }}" class="stretched-link">Profile</a>
                    <small>My account</small>
                </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-cog icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('profile.edit') }}" class="stretched-link">Settings</a>
                    <small>Update profile</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-lock-alt icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('password.request') }}" class="stretched-link">Security</a>
                    <small>Password recovery</small>
                </div>
            </div>
        </div>
    </div>
</li>
