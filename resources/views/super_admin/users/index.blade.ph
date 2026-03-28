@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pending users</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>phone</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingUsers as $user)
                        <tr>
                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ $user->userStatus?->label ?? 'Pending' }}
                                </span>
                            </td>
                            <td>
                                @forelse($user->roles as $role)
                                    <span class="badge bg-secondary me-1">{{ $role->label }}</span>
                                @empty
                                    <span class="text-muted">No user</span>
                                @endforelse
                            </td>
                            <td class="text-end">
                                <a href="{{ route('super_admin.pending_users.show', $user) }}"
                                   class="btn btn-sm btn-info">
                                    Voir
                                </a>
                                <a href="{{ route('super_admin.pending_users.edit', $user) }}"
                                   class="btn btn-sm btn-primary">
                                    Activer
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No user in pending.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection