<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-5 fw-bold">
            {{ __('Edit Permission: ' . $permission->label) }}
        </h2>
    </x-slot>

    <div class="container-lg py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Update Permission Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permissions.update', $permission) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <x-input-label for="name" :value="__('Permission Name (System Name)')" />
                                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name', $permission->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <small class="text-muted d-block mt-1">Use lowercase with underscores (e.g., create_residence)</small>
                            </div>

                            <div class="mb-3">
                                <x-input-label for="label" :value="__('Permission Label (Display Name)')" />
                                <x-text-input id="label" class="form-control" type="text" name="label" :value="old('label', $permission->label)" required />
                                <x-input-error :messages="$errors->get('label')" class="mt-2" />
                                <small class="text-muted d-block mt-1">User-friendly display name</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    ✅ Update Permission
                                </button>
                                <a href="{{ route('permissions.show', $permission) }}" class="btn btn-secondary">
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
