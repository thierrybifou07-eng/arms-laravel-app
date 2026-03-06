<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold">
                {{ __('Permission Details: ' . $permission->label) }}
            </h2>
            <div>
                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">
                    ✏️ Edit
                </a>
                <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-secondary">
                    ⬅️ Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-lg py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Permission Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Name:</strong><br>
                            <code>{{ $permission->name }}</code>
                        </p>
                        <p class="mb-2">
                            <strong>Label:</strong><br>
                            {{ $permission->label }}
                        </p>
                        <p class="mb-0">
                            <strong>Created:</strong><br>
                            {{ $permission->created_at->format('M d, Y H:i') }}
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
                        <p class="mb-0">
                            <strong>Assigned to Roles:</strong><br>
                            <span class="badge bg-warning fs-6">{{ $permission->roles->count() }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Roles with this Permission ({{ $permission->roles->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($permission->roles->count() > 0)
                            <div class="row">
                                @foreach ($permission->roles as $role)
                                    <div class="col-md-4 mb-3">
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-1">{{ $role->label }}</h6>
                                            <code class="text-muted">{{ $role->name }}</code>
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-link mt-2">View Role →</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">This permission is not assigned to any role yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
