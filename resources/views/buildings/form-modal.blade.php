@props(['residence', 'building' => null, 'statuses'])

@php
    $isEdit = isset($building) && $building;
    $modalName = $isEdit ? 'edit-building-' . $building->id : 'create-building';
    $title = $isEdit ? 'Edit Building' : 'Create Building';
    $submitText = $isEdit ? 'Update' : 'Create';
    $formAction = $isEdit ? route('residences.buildings.update', [$residence, $building]) : route('residences.buildings.store', $residence);
    $formMethod = $isEdit ? 'PUT' : 'POST';
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="{{ $formAction }}" id="building-form-{{ $modalName }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="modal-body">
            <div class="row mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $building?->name ?? '') }}" placeholder="Building name" required>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Address <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $building?->address ?? '') }}" placeholder="Ex: PK-17 Station Neptune" required>
                @error('address')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Capacity (floors) <span class="text-danger">*</span></label>
                <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                    value="{{ old('capacity', $building?->capacity ?? '') }}" placeholder="Number of floors" required>
                @error('capacity')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="building_status_id" class="form-select @error('building_status_id') is-invalid @enderror" required>
                    <option value="">Select status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('building_status_id', $building?->building_status_id ?? '') == $status->id ? 'selected' : '' }}>
                            {{ $status->label ?? $status->code }}
                        </option>
                    @endforeach
                </select>
                @error('building_status_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
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
