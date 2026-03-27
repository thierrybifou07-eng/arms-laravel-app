@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Roles Management</h1>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Nouveau rôle</a>
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
                        <th>Permissions</th>
                        <th>Users</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->label }}</td>
                            <td>
                                @forelse($role->permissions as $permission)
                                    <span class="badge bg-secondary me-1 mb-1">{{ $permission->label }}</span>
                                @empty
                                    <span class="text-muted">No permission</span>
                                @endforelse
                            </td>
                            <td>{{ $role->users_count ?? $role->users->count() }}</td>
                            <td class="text-end">
                                <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Supprimer ce rôle ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
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
@endsection