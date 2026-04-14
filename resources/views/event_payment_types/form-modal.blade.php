@props(['eventPaymentType' => null])

@php
    $isEdit = isset($eventPaymentType) && $eventPaymentType;
    $modalName = $isEdit ? 'edit-event-payment-type-' . $eventPaymentType->id : 'create-event-payment-type';
    $title = $isEdit ? 'Éditer Type de Paiement d\'Événement' : 'Créer Type de Paiement d\'Événement';
    $submitText = $isEdit ? 'Mettre à Jour' : 'Créer';
    $formAction = $isEdit ? route('event_payment_types.update', $eventPaymentType) : route('event_payment_types.store');
    $formMethod = $isEdit ? 'PUT' : 'POST';
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <form method="POST" action="{{ $formAction }}" id="event-payment-type-form-{{ $modalName }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="modal-body">
            <div class="row mb-4">
                <label class="col-form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $eventPaymentType?->name ?? '') }}" placeholder="Ex: Frais de dossier" required>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-4">
                <label class="col-form-label">Montant (DZD) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    value="{{ old('amount', $eventPaymentType?->amount ?? '') }}" placeholder="Ex: 5000" required>
                @error('amount')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row mb-4">
                <label class="col-form-label">Code <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                    value="{{ old('code', $eventPaymentType?->code ?? '') }}" placeholder="Ex: fee_001" required>
                @error('code')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="modal-footer border-top">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-check me-1"></i>{{ $submitText }}
            </button>
        </div>
    </form>
</x-modal>
