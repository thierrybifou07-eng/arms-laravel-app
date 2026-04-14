@props(['payment' => null])

@php
    $modalName = 'payment-show-' . ($payment?->id ?? 'new');
@endphp

<x-modal name="{{ $modalName }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        @if ($payment)
        <div class="mb-3">
            <label class="form-label"><strong>Contract</strong></label>
            <p class="form-control-plaintext">#{{ $payment->contract->id }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Student</strong></label>
            <p class="form-control-plaintext">{{ $payment->contract->user->firstname }} {{
                $payment->contract->user->lastname }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Due Amount</strong></label>
            <p class="form-control-plaintext">{{ number_format($payment->expected_amount, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Paid Amount</strong></label>
            <p class="form-control-plaintext">{{ number_format($payment->paid_amount, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Status</strong></label>
            <p class="form-control-plaintext">
                <a href="" class="">
                    @php $status = $payment->status->code ?? '' @endphp

                    @if ($payment->isOverdue())
                    <span class="badge bg-danger">Overdue</span>
                    @else
                    @switch($payment->status->code)
                    @case('pending')
                    <span class="badge bg-label-warning">{{ $payment->status->label }}</span>
                    @break

                    @case('validated')
                    <span class="badge bg-label-success">{{ $payment->status->label }}</span>
                    @break

                    @case('cancelled')
                    <span class="badge bg-label-secondary">{{ $payment->status->label }}</span>
                    @break

                    @case('processing')
                    <span class="badge bg-label-info">{{ $payment->status->label }}</span>
                    @break

                    @default
                    <span class="badge bg-label-dark">{{ $payment->status->label ?? 'Unknown' }}</span>
                    @endswitch
                    @endif
                </a>
            </p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Created</strong></label>
            <p class="form-control-plaintext">{{ $payment->created_at?->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Last Updated</strong></label>
            <p class="form-control-plaintext">{{ $payment->updated_at?->format('d/m/Y H:i') }}</p>
        </div>
        @endif
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</x-modal>