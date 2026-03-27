@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Manage permissions</h1>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary">Nouvelle permission</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Label</th>
                    <th>Roles</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->label }}</td>
                        <td>
                            @forelse($permission->roles as $role)
                                <span class="badge bg-secondary me-1 mb-1">{{ $role->label }}</span>
                            @empty
                                <span class="text-muted">No one</span>
                            @endforelse
                        </td>
                        <td class="text-end">
                            <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-info">See</a>
                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm Edit
                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this permission ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No one permission found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection