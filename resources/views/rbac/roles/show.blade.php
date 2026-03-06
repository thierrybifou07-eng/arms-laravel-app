<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold">
                {{ __('Role Details: ' . $role->label) }}
            </h2>
            <div>
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">
                    ✏️ Edit
                </a>
                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">
                    ⬅️ Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-lg py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Role Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Name:</strong><br>
                            <code>{{ $role->name }}</code>
                        </p>
                        <p class="mb-2">
                            <strong>Label:</strong><br>
                            {{ $role->label }}
                        </p>
                        <p class="mb-0">
                            <strong>Created:</strong><br>
                            {{ $role->created_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Total Permissions:</strong><br>
                            <span class="badge bg-success fs-6">{{ $role->permissions->count() }}</span>
                        </p>
                        <p class="mb-0">
                            <strong>Total Users:</strong><br>
                            <span class="badge bg-warning fs-6">{{ $role->users->count() }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Assigned Permissions ({{ $role->permissions->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($role->permissions->count() > 0)
                            <div class="row">
                                @foreach ($role->permissions as $permission)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-1">{{ $permission->label }}</h6>
                                            <code class="text-muted">{{ $permission->name }}</code>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No permissions assigned to this role.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Users with this Role ({{ $role->users->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($role->users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($role->users as $user)
                                            <tr>
                                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->userStatus)
                                                        <span class="badge bg-info">{{ $user->userStatus->label ?? 'Unknown' }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">No Status</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">No users have this role yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
