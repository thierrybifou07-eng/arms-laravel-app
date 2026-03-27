<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name ?? '') }}">
    @error('name')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Label</label>
    <input type="text" name="label" class="form-control" value="{{ old('label', $permission->label ?? '') }}">
    @error('label')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>