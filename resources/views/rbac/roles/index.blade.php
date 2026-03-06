<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold">
                {{ __('Roles Management') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">
                ➕ Create New Role
            </a>
        </div>
    </x-slot>

    <div class="container-lg py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($roles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Role Name</th>
                            <th>Label</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <code>{{ $role->name }}</code>
                                </td>
                                <td>
                                    <strong>{{ $role->label }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $role->permissions->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $role->users->count() }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info">
                                        👁️ View
                                    </a>
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </a>
                                    @if (!in_array($role->name, ['super_admin', 'admin']))
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No roles found</h5>
                <p class="mb-0"><a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary mt-2">Create the first role</a></p>
            </div>
        @endif
    </div>
</x-app-layout>
