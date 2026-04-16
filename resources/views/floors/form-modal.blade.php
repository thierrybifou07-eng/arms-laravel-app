@props(['building', 'floor' => null, 'statuses'])

@php
    $isEdit = isset($floor) && $floor;
    $modalName = $isEdit ? 'edit-floor-' . $floor->id : 'create-floor';
    $title = $isEdit ? 'Edit Floor' : 'Create Floor';
    $submitText = $isEdit ? 'Update' : 'Create';
    $formAction = $isEdit ? route('buildings.floors.update', [$building, $floor]) : route('buildings.floors.store', $building);
    $formMethod = $isEdit ? 'PUT' : 'POST';
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="{{ $formAction }}" id="floor-form-{{ $modalName }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="modal-body">
            <div class="row mb-3">
                <label class="form-label">Floor Number <span class="text-danger">*</span></label>
                <input type="number" name="number" class="form-control @error('number') is-invalid @enderror"
                    value="{{ old('number', $floor?->number ?? '') }}" placeholder="Floor number" required>
                @error('number')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Capacity (rooms) <span class="text-danger">*</span></label>
                <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                    value="{{ old('capacity', $floor?->capacity ?? '') }}" placeholder="Number of rooms" required>
                @error('capacity')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="floor_status_id" class="form-select @error('floor_status_id') is-invalid @enderror" required>
                    <option value="">Select status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('floor_status_id', $floor?->floor_status_id ?? '') == $status->id ? 'selected' : '' }}>
                            {{ $status->label ?? $status->code }}
                        </option>
                    @endforeach
                </select>
                @error('floor_status_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="modal-footer border-top">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-check me-1"></i>{{ $submitText }}
            </button>
        </div>
    </form>
</x-modal>
