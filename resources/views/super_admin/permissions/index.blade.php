@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Manage permissions</h1>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary">New permission</a>
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
                            <th>Roles</th>
                            <th class="text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->label }}</td>
                                <td class="d-flex-wrap">
                                    @forelse($permission->roles as $role)
                                        <div><span class="badge bg-secondary me-1 mb-1">{{ $role->label }}</span></div>
                                    @empty
                                        <span class="text-muted">No role</span>
                                    @endforelse
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('permissions.show', $permission) }}">
                                                <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                            <a class="dropdown-item" href="{{ route('permissions.edit', $permission) }}"><i
                                                    class="icon-base bx bx-edit me-1"></i>Edit status</a>
                                            <hr class="dropdown-divider">
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this permissions ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item"><i
                                                        class="icon-base bx bx-trash me-1"></i>Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No permission found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection