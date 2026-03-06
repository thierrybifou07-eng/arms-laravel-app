<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-5 fw-bold">
            {{ __('Edit Role: ' . $role->label) }}
        </h2>
    </x-slot>

    <div class="container-lg py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Update Role Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <x-input-label for="name" :value="__('Role Name (System Name)')" />
                                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name', $role->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <small class="text-muted d-block mt-1">Use lowercase with underscores (e.g., super_admin)</small>
                            </div>

                            <div class="mb-3">
                                <x-input-label for="label" :value="__('Role Label (Display Name)')" />
                                <x-text-input id="label" class="form-control" type="text" name="label" :value="old('label', $role->label)" required />
                                <x-input-error :messages="$errors->get('label')" class="mt-2" />
                                <small class="text-muted d-block mt-1">User-friendly display name</small>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="permissions" :value="__('Assign Permissions')" />
                                <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                    @if ($permissions->count() > 0)
                                        @foreach ($permissions as $permission)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $permission->label }}
                                                    <small class="text-muted d-block">({{ $permission->name }})</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No permissions available. <a href="{{ route('permissions.create') }}">Create one</a></p>
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    ✅ Update Role
                                </button>
                                <a href="{{ route('roles.show', $role) }}" class="btn btn-secondary">
                                    ❌ Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
