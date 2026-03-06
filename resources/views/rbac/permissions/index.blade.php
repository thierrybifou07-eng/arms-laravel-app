<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold">
                {{ __('Permissions Management') }}
            </h2>
            <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-success">
                ➕ Create New Permission
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

        @if ($permissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Permission Name</th>
                            <th>Label</th>
                            <th>Roles Using It</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    <code>{{ $permission->name }}</code>
                                </td>
                                <td>
                                    <strong>{{ $permission->label }}</strong>
                                </td>
                                <td>
                                    @if ($permission->roles->count() > 0)
                                        <span class="badge bg-primary">{{ $permission->roles->count() }}</span>
                                    @else
                                        <span class="badge bg-secondary">0</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-info">
                                        👁️ View
                                    </a>
                                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $permissions->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No permissions found</h5>
                <p class="mb-0"><a href="{{ route('permissions.create') }}" class="btn btn-sm btn-success mt-2">Create the first permission</a></p>
            </div>
        @endif
    </div>
</x-app-layout>
