@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        <div class="card my-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h5 class="mb-0">Users Management</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Filtre par rôle -->
                    <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
                        <select name="role" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                    {{ $role->label }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Barre de recherche -->
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by name, email..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                            @if(request('search') || request('role'))
                                <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="bx bx-x"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($users->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table table-sm mb-0">
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
                        <tbody class="table-border-bottom-0">
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
                                                <span class="badge bg-label-warning">{{ $user->userStatus->label ?? 'Suspended' }}</span>
                                                @break
                                            @case('disabled')
                                                <span class="badge bg-label-secondary">{{ $user->userStatus->label ?? 'Disabled' }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-label-light">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td class="text-start">
                                        @if ($user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                @switch($role->name)
                                                    @case('super_admin')
                                                        <span class="badge bg-label-success me-1">{{ $role->label }}</span>
                                                        @break
                                                    @case('admin')
                                                        <span class="badge bg-label-primary me-1">{{ $role->label }}</span>
                                                        @break
                                                    @case('staff')
                                                        <span class="badge bg-label-danger me-1">{{ $role->label }}</span>
                                                        @break
                                                    @case('teller')
                                                        <span class="badge bg-label-warning me-1">{{ $role->label }}</span>
                                                        @break
                                                    @case('student')
                                                        <span class="badge bg-label-info me-1">{{ $role->label }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-label-light me-1">{{ $role->label }}</span>
                                                @endswitch
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary">No roles</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ $user->avatar() }}" alt="Avatar" 
                                                 class="rounded-circle" width="32" height="32">
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
                                                <a class="dropdown-item" href="{{ route('super_adminuser.roles.edit', $user) }}">
                                                    <i class="bx bx-user-check me-1"></i>Assign Role</a>
                                                <a class="dropdown-item" href="{{ route('activate_accountpending_users.edit', $user) }}">
                                                    <i class="bx bx-edit me-1"></i>Edit Status</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                                      style="display: inline;" 
                                                      onsubmit="return confirm('Are you sure?');">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5 mb-0">
                    <h5>No users found</h5>
                    <p class="mb-0 text-muted">Try adjusting your search or filter criteria</p>
                </div>
            @endif
        </div>
    </div>
@endsection