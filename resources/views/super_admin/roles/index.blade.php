@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Roles Management</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card my-5">
            <div class="table-responsive text-nowrap table-hover align-middle">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Label</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th class="text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                                <td class="d-flex-wrap">
                                    @forelse($role->permissions as $permission)
                                        <div><span class="badge bg-secondary me-1 mb-1">{{ $permission->label }}</span>
                                        </div>
                                    @empty
                                        <span class="text-muted">No permission</span>
                                    @endforelse
                                </td>
                                <td>{{ $role->users_count ?? $role->users->count() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('roles.show', $role) }}">
                                                <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No role found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection