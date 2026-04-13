@props(['building' => null, 'floor' => null])

@php
    $modalName = 'floor-show-' . ($floor?->id ?? 'new');
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Floor Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        @if ($floor)
            <div class="mb-3">
                <label class="form-label"><strong>Building</strong></label>
                <p class="form-control-plaintext">{{ $building?->name ?? $floor->building?->name ?? 'N/A' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Floor Number</strong></label>
                <p class="form-control-plaintext">{{ $floor->number }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Capacity</strong></label>
                <p class="form-control-plaintext">{{ $floor->capacity }} room(s)</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Status</strong></label>
                <p class="form-control-plaintext">
                    <span class="badge bg-label-primary">{{ $floor->status->label ?? 'Unknown' }}</span>
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Created</strong></label>
                <p class="form-control-plaintext">{{ $floor->created_at?->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Last Updated</strong></label>
                <p class="form-control-plaintext">{{ $floor->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        @endif
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</x-modal>
