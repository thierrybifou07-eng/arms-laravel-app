<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-5 fw-bold">
            {{ __('RBAC System Test & Demonstration') }}
        </h2>
    </x-slot>

    <div class="container-lg py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- User Info Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Your Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Roles:</strong> <span class="badge bg-warning">{{ $roles->count() }}</span></p>
                                <p><strong>Total Permissions:</strong> <span class="badge bg-success">{{ $permissions->count() }}</span></p>
                                <p><strong>Account Status:</strong> 
                                    @if ($user->userStatus)
                                        <span class="badge bg-info">{{ $user->userStatus->label }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Status</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Roles -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Your Roles ({{ $roles->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if ($roles->count() > 0)
                            <div class="list-group">
                                @foreach ($roles as $role)
                                    <div class="list-group-item">
                                        <h6 class="mb-1">{{ $role->label }}</h6>
                                        <code class="text-muted">{{ $role->name }}</code>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                No roles assigned to your account.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Your Permissions -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Your Permissions ({{ $permissions->count() }})</h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @if ($permissions->count() > 0)
                            <div class="list-group">
                                @foreach ($permissions as $permission)
                                    <div class="list-group-item">
                                        <small>
                                            <span class="badge bg-success">✓</span>
                                            {{ $permission->label }}
                                        </small>
                                        <br>
                                        <code class="text-muted small">{{ $permission->name }}</code>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                No permissions assigned through your roles.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Actions -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Test Actions</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Use these buttons to test role and permission assignments:</p>
                        <div class="btn-group" role="group">
                            <form action="{{ route('rbac.test.assign-admin') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    ➕ Assign Admin Role
                                </button>
                            </form>
                            <form action="{{ route('rbac.test.remove-admin') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    ➖ Remove Admin Role
                                </button>
                            </form>
                            <form action="{{ route('rbac.test.assign-multiple') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    🔄 Assign Multiple Roles
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Roles -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">All System Roles ({{ $allRoles->count() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Role Name</th>
                                    <th>Label</th>
                                    <th>Permissions</th>
                                    <th>Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allRoles as $role)
                                    <tr>
                                        <td><code>{{ $role->name }}</code></td>
                                        <td>{{ $role->label }}</td>
                                        <td><span class="badge bg-info">{{ $role->permissions->count() }}</span></td>
                                        <td><span class="badge bg-warning">{{ $role->users->count() }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Users -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">All System Users ({{ $allUsers->count() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUsers as $testUser)
                                    <tr>
                                        <td><strong>{{ $testUser->firstname }} {{ $testUser->lastname }}</strong></td>
                                        <td>{{ $testUser->email }}</td>
                                        <td>
                                            @if ($testUser->roles->count() > 0)
                                                @foreach ($testUser->roles as $role)
                                                    <span class="badge bg-primary">{{ $role->label }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-secondary">No roles</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $testUser->getPermissions()->count() }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Examples -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">PHP Code Examples</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Check User Role</h6>
                                <pre><code>$user->hasRole('admin');
$user->hasAnyRole(['admin', 'staff']);
$user->hasAllRoles(['admin', 'staff']);</code></pre>
                            </div>
                            <div class="col-md-6">
                                <h6>Check User Permission</h6>
                                <pre><code>$user->hasPermission('create_residence');
$user->hasAnyPermission(['create', 'edit']);
$user->hasAllPermissions(['create', 'edit']);</code></pre>
                            </div>
                            <div class="col-md-6 mt-3">
                                <h6>Get User Permissions</h6>
                                <pre><code>$permissions = $user->getPermissions();

foreach ($permissions as $permission) {
    echo $permission->label;
}</code></pre>
                            </div>
                            <div class="col-md-6 mt-3">
                                <h6>Blade Template</h6>
                                <pre><code>@if (auth()->user()->hasRole('admin'))
    &lt;!-- Admin content --&gt;
@endif

@if (auth()->user()->hasPermission('edit'))
    &lt;!-- Edit content --&gt;
@endif</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
