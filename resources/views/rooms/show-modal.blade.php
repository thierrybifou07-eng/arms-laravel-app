@props(['floor' => null, 'room' => null])

@php
    $modalName = 'room-show-' . ($room?->id ?? 'new');
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Room Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        @if ($room)
            <div class="mb-3">
                <label class="form-label"><strong>Floor</strong></label>
                <p class="form-control-plaintext">Floor #{{ $floor?->number ?? ($room->floor?->number ?? 'N/A') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Room Number</strong></label>
                <p class="form-control-plaintext">{{ $room->number }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Capacity</strong></label>
                <p class="form-control-plaintext">{{ $room->capacity }} room(s)</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Monthly Rent</strong></label>
                <p class="form-control-plaintext">{{ number_format($room->rent, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Status</strong></label>
                <p class="form-control-plaintext">
                    @switch($room->status->code ?? '')
                        @case('busy')
                            <span class="badge bg-label-primary">{{ $room->status->label ?? 'Busy' }}</span>
                        @break

                        @case('available')
                            <span class="badge bg-label-success">{{ $room->status->label ?? 'Available' }}</span>
                        @break

                        @case('closed')
                            <span class="badge bg-label-secondary">{{ $room->status->label ?? 'Closed' }}</span>
                        @break

                        @default
                            <span class="badge bg-label-light">Unknown</span>
                    @endswitch
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Created</strong></label>
                <p class="form-control-plaintext">{{ $room->created_at?->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Last Updated</strong></label>
                <p class="form-control-plaintext">{{ $room->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        @endif
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</x-modal>
