@extends('layouts.app')
@section('content')
    <h5 class="mb-3">Users Management</h5>
    <div class="card my-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header">
            <form method="GET" action="{{ route('users.index') }}" x-data>
                <div class="row mx-3 my-0 justify-content-between align-items-end gap-3">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="user-status" class="form-label">Status
                                <select name="status" id="user-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>
                                        Disabled</option>
                                </select>
                            </label>
                            <label for="user-roles" class="form-label">Roles
                                <select name="role" id="user-roles"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="teller" {{ request('role') === 'teller' ? 'selected' : '' }}>Teller
                                    </option>
                                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff
                                    </option>
                                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student
                                    </option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0 gap-2 flex-wrap">

                        <div>
                            <label for="user-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="user-search" class="form-control form-control-sm"
                                placeholder="Name, email..." value="{{ request('search') }}"
                                @input.debounce.750ms="$el.form.submit()">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if ($users->count() > 0)
            <div class="table-responsive text-nowrap table-hover">
                <table class="table table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th class="text-start" style="width: 15%">Name</th>
                            <th class="text-start" style="width: 20%">Email</th>
                            <th class="text-start" style="width: 15%">Phone</th>
                            <th class="text-start" style="width: 12%">Status</th>
                            <th class="text-start" style="width: 18%">Roles</th>
                            <th class="text-center" style="width: 8%">Avatar</th>
                            <th class="text-center" style="width: 7%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">
                                    <span class="text-muted small">{{ $user->id }}</span>
                                </td>
                                <td class="text-start">
                                    <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                                </td>
                                <td class="text-start">
                                    <small>{{ $user->email }}</small>
                                </td>
                                <td class="text-start">
                                    <small>{{ $user->phone ?? 'N/A' }}</small>
                                </td>
                                <td class="text-start">
                                    @switch($user->userStatus->code ?? '')
                                        @case('pending')
                                            <span class="badge bg-label-info">{{ $user->userStatus->label ?? 'Pending' }}</span>
                                        @break

                                        @case('active')
                                            <span class="badge bg-label-success">{{ $user->userStatus->label ?? 'Active' }}</span>
                                        @break

                                        @case('suspended')
                                            <span
                                                class="badge bg-label-warning">{{ $user->userStatus->label ?? 'Suspended' }}</span>
                                        @break

                                        @case('disabled')
                                            <span
                                                class="badge bg-label-secondary">{{ $user->userStatus->label ?? 'Disabled' }}</span>
                                        @break

                                        @default
                                            <span class="badge bg-label-light">Unknown</span>
                                    @endswitch
                                </td>
                                <td class="text-start">
                                    @php
                                        $userRole = $user->getRole();
                                    @endphp

                                    @if ($userRole)
                                        @switch($userRole->name)
                                            @case('super_admin')
                                                <span class="badge bg-label-success">{{ $userRole->label }}</span>
                                            @break

                                            @case('admin')
                                                <span class="badge bg-label-primary">{{ $userRole->label }}</span>
                                            @break

                                            @case('staff')
                                                <span class="badge bg-label-danger">{{ $userRole->label }}</span>
                                            @break

                                            @case('teller')
                                                <span class="badge bg-label-warning">{{ $userRole->label }}</span>
                                            @break

                                            @case('student')
                                                <span class="badge bg-label-info">{{ $userRole->label }}</span>
                                            @break

                                            @default
                                                <span class="badge bg-label-light">{{ $userRole->label }}</span>
                                        @endswitch
                                    @else
                                        <span class="badge bg-label-secondary">No role</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ $user->avatar() }}" alt="Avatar" class="rounded-circle"
                                            width="32" height="32">
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('users.show', $user) }}">
                                                <i class="bx bx-show-alt me-1"></i>View</a>
                                            <a class="dropdown-item"
                                                href="{{ route('super_admin.user.roles.edit', $user) }}">
                                                <i class="bx bx-user-check me-1"></i>Assign Role</a>
                                            <a class="dropdown-item"
                                                href="{{ route('activate_accountpending_users.edit', $user) }}">
                                                <i class="bx bx-edit me-1"></i>Edit Status</a>
                                            <hr class="dropdown-divider">
                                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="row mx-3 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info" aria-live="polite" role="status">Showing {{ $users->firstItem() ?? 0 }}
                        to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- Previous Button --}}
                                <li class="dt-paging-button page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $users->previousPageUrl() }}"
                                        {{ $users->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                        <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li class="dt-paging-button page-item active">
                                            <span class="page-link" aria-current="page">{{ $page }}</span>
                                        </li>
                                    @elseif (
                                        $page == 1 ||
                                            $page == $users->lastPage() ||
                                            ($page >= $users->currentPage() - 2 && $page <= $users->currentPage() + 2))
                                        <li class="dt-paging-button page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @elseif ($page == 2 || $page == $users->lastPage() - 1)
                                        <li class="dt-paging-button page-item disabled">
                                            <span class="page-link ellipsis">…</span>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                <li class="dt-paging-button page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link next" href="{{ $users->nextPageUrl() }}"
                                        {{ !$users->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                        <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center py-5 mb-0">
                <h5>No users found</h5>
                <p class="mb-0 text-muted">Try adjusting your search or filter criteria</p>
            </div>
        @endif
    </div>
@endsection
