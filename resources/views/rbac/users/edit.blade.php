<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-5 fw-bold">
            {{ __('Manage Roles for: ' . $user->firstname . ' ' . $user->lastname) }}
        </h2>
    </x-slot>

    <div class="container-lg py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Assign Roles</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <p class="text-muted mb-3">Select roles to assign to this user:</p>
                                <div class="border rounded p-3" style="max-height: 500px; overflow-y: auto;">
                                    @if ($roles->count() > 0)
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    <strong>{{ $role->label }}</strong>
                                                    <small class="text-muted d-block">({{ $role->name }}) - {{ $role->permissions->count() }} permissions</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No roles available. <a href="{{ route('roles.create') }}">Create one</a></p>
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    ✅ Update Roles
                                </button>
                                <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                    ❌ Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                @if ($user->roles->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Current Roles & Permissions</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($user->roles as $role)
                                <div class="mb-4">
                                    <h6 class="mb-2">
                                        <span class="badge bg-primary">{{ $role->label }}</span>
                                    </h6>
                                    <div class="ps-3">
                                        @if ($role->permissions->count() > 0)
                                            <p class="text-muted small mb-2">Permissions in this role:</p>
                                            <div class="row">
                                                @foreach ($role->permissions as $permission)
                                                    <div class="col-md-6">
                                                        <small><span class="badge bg-light text-dark">{{ $permission->label }}</span></small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted small mb-0">No permissions in this role</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
