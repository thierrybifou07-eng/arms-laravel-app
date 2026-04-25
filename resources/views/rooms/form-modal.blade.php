@props(['floor', 'room' => null, 'statuses'])

@php
    $isEdit = isset($room) && $room;
    $modalName = $isEdit ? 'edit-room-' . $room->id : 'create-room';
    $title = $isEdit ? 'Edit Room' : 'Create Room';
    $submitText = $isEdit ? 'Update' : 'Create';
    $formAction = $isEdit ? route('floors.rooms.update', [$floor, $room]) : route('floors.rooms.store', $floor);
    $formMethod = $isEdit ? 'PUT' : 'POST';
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="{{ $formAction }}" id="room-form-{{ $modalName }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="modal-body">
            <div class="row mb-3">
                <label class="form-label">Room Number <span class="text-danger">*</span></label>
                <input type="number" name="number" class="form-control @error('number') is-invalid @enderror"
                    value="{{ old('number', $room?->number ?? '') }}" placeholder="Room number" required>
                @error('number')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Capacity (rooms) <span class="text-danger">*</span></label>
                <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                    value="{{ old('capacity', $room?->capacity ?? '') }}" placeholder="Number of persons" required>
                @error('capacity')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Monthly Rent (FCFA) <span class="text-danger">*</span></label>
                <input type="number" name="rent" class="form-control @error('rent') is-invalid @enderror"
                    value="{{ old('rent', $room?->rent ?? '') }}" placeholder="Rent amount" required>
                @error('rent')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="room_status_id" class="form-select @error('room_status_id') is-invalid @enderror" required>
                    <option value="">Select status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('room_status_id', $room?->room_status_id ?? '') == $status->id ? 'selected' : '' }}>
                            {{ $status->label ?? $status->code }}
                        </option>
                    @endforeach
                </select>
                @error('room_status_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
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
