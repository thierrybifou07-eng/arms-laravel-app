<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold">
                {{ __('User Details: ' . $user->firstname . ' ' . $user->lastname) }}
            </h2>
            <div>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                    ✏️ Manage Roles
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
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
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Name:</strong><br>
                            {{ $user->firstname }} {{ $user->lastname }}
                        </p>
                        <p class="mb-2">
                            <strong>Email:</strong><br>
                            {{ $user->email }}
                        </p>
                        <p class="mb-2">
                            <strong>Phone:</strong><br>
                            {{ $user->phone ?? 'N/A' }}
                        </p>
                        <p class="mb-0">
                            <strong>Status:</strong><br>
                            @if ($user->userStatus)
                                <span class="badge bg-info">{{ $user->userStatus->label ?? 'Unknown' }}</span>
                            @else
                                <span class="badge bg-secondary">No Status</span>
                            @endif
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
                            <strong>Total Roles:</strong><br>
                            <span class="badge bg-primary fs-6">{{ $user->roles->count() }}</span>
                        </p>
                        <p class="mb-0">
                            <strong>Total Permissions:</strong><br>
                            <span class="badge bg-success fs-6">{{ $permissions->count() }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Assigned Roles ({{ $user->roles->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($user->roles->count() > 0)
                            <div class="row">
                                @foreach ($user->roles as $role)
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-1">{{ $role->label }}</h6>
                                            <code class="text-muted">{{ $role->name }}</code>
                                            <p class="mb-0 mt-2 small">
                                                <strong>Permissions: {{ $role->permissions->count() }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                No roles assigned to this user.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">All Permissions ({{ $permissions->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($permissions->count() > 0)
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-4 mb-2">
                                        <small>
                                            <span class="badge bg-success">
                                                ✓ {{ $permission->label }}
                                            </span>
                                        </small>
                                        <br>
                                        <code class="text-muted d-block small mt-1">{{ $permission->name }}</code>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">User has no permissions through their roles.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
