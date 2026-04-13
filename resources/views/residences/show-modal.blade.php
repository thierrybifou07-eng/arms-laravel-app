@props(['residence' => null])

@php
    $modalName = 'residence-show-' . ($residence?->id ?? 'new');
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Residence Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        @if ($residence)
            <div class="mb-3">
                <label class="form-label"><strong>Name</strong></label>
                <p class="form-control-plaintext">{{ $residence->name }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>City</strong></label>
                <p class="form-control-plaintext">{{ $residence->city ?? 'N/A' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Address</strong></label>
                <p class="form-control-plaintext">{{ $residence->address ?? 'N/A' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Capacity</strong></label>
                <p class="form-control-plaintext">{{ $residence->capacity }} building(s)</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Status</strong></label>
                <p class="form-control-plaintext">
                    <span class="badge bg-label-primary">{{ $residence->status->label ?? 'Unknown' }}</span>
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Created</strong></label>
                <p class="form-control-plaintext">{{ $residence->created_at?->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Last Updated</strong></label>
                <p class="form-control-plaintext">{{ $residence->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        @endif
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</x-modal>
