@props(['residence' => null, 'building' => null])

@php
    $modalName = 'building-show-' . ($building?->id ?? 'new');
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Building Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        @if ($building)
            <div class="mb-3">
                <label class="form-label"><strong>Residence</strong></label>
                <p class="form-control-plaintext">{{ $residence?->name ?? ($building->residence?->name ?? 'N/A') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Name</strong></label>
                <p class="form-control-plaintext">{{ $building->name }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Address</strong></label>
                <p class="form-control-plaintext">{{ $building->address ?? 'N/A' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Capacity</strong></label>
                <p class="form-control-plaintext">{{ $building->capacity }} floor(s)</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Status</strong></label>
                <p class="form-control-plaintext">
                    @switch($building->status->code ?? '')
                        @case('active')
                            <span class="badge bg-label-primary">{{ $building->status->label ?? 'Open' }}</span>
                        @break

                        @case('closed')
                            <span class="badge bg-label-secondary">{{ $building->status->label ?? 'Closed' }}</span>
                        @break

                        @default
                            <span class="badge bg-label-light">Unknown</span>
                    @endswitch
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Created</strong></label>
                <p class="form-control-plaintext">{{ $building->created_at?->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Last Updated</strong></label>
                <p class="form-control-plaintext">{{ $building->updated_at?->format('d/m/Y H:i') }}</p>
            </div>
        @endif
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</x-modal>
