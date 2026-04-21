<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
        data-bs-auto-close="outside" aria-expanded="false">
        <i class="icon-base bx bx-grid-alt icon-md"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end p-0">
        <div class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
                <h6 class="mb-0 me-auto">Admin Shortcuts</h6>
            </div>
        </div>
        <div class="dropdown-shortcuts-list scrollable-container ps">
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-home icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('residences.index') }}" class="stretched-link">Residences</a>
                    <small>Manage residences</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-food-menu icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('contracts.index') }}" class="stretched-link">Contracts</a>
                    <small>Manage contracts</small>
                </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-money icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('payments.index') }}" class="stretched-link">Payments</a>
                    <small>Track payments</small>
                </div>
                <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                        <i class="icon-base bx bx-user icon-26px text-heading"></i>
                    </span>
                    <a href="{{ route('users.index') }}" class="stretched-link">Users</a>
                    <small>User supervision</small>
                </div>
            </div>
        </div>
    </div>
</li>
