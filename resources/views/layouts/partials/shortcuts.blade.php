                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="icon-base bx bx-grid-alt icon-md"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0">
                        <div class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h6 class="mb-0 me-auto">Shortcuts</h6>
                            </div>
                        </div>
                        <div class="dropdown-shortcuts-list scrollable-container ps">
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-user icon-26px text-heading"></i>
                                    </span>
                                    <a href="{{ route('users.index') }}" class="stretched-link">Users</a>
                                    <small>Manage Users</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-check-shield icon-26px text-heading"></i>
                                    </span>
                                    <a href="{{ route('super_adminroles.index') }}" class="stretched-link">Role
                                        Management</a>
                                    <small>Permission</small>
                                </div>
                            </div>
                            <div class="row row-bordered overflow-visible g-0">
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-pie-chart-alt-2 icon-26px text-heading"></i>
                                    </span>
                                    <a href="{{ route('dashboard') }}" class="stretched-link">Dashboard</a>
                                    <small>User Dashboard</small>
                                </div>
                                <div class="dropdown-shortcuts-item col">
                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                        <i class="icon-base bx bx-cog icon-26px text-heading"></i>
                                    </span>
                                    <a href="{{ route('profile.update') }}" class="stretched-link">Setting</a>
                                    <small>Account Settings</small>
                                </div>
                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                            </div>
                        </div>
                    </div>
                </li>