@php
    $selectedPermissions = old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : []);
@endphp

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name ?? '') }}">
    @error('name')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Label</label>
    <input type="text" name="label" class="form-control" value="{{ old('label', $role->label ?? '') }}">
    @error('label')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label d-block">Permissions</label>
    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                        id="permission_{{ $permission->id }}" @checked(in_array($permission->id, $selectedPermissions))>
                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                        {{ $permission->label }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    @error('permissions')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>