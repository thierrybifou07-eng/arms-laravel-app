@props(['payment', 'paymentMethods'])

<x-modal name="pay-modal-{{ $payment->id }}" maxWidth="md">
    <div class="modal-header border-bottom">
        <h5 class="modal-title">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <label class="form-label"><strong>Contract</strong></label>
                <p class="form-control-plaintext">Contract #{{ $payment->contract->id }}</p>
            </div>

            <div class="col-md-6">
                <label class="form-label"><strong>Status</strong></label>
                <p class="form-control-plaintext">
                    <span class="badge bg-label-warning">{{ $payment->status->label ?? '' }}</span>
                </p>
            </div>

            <div class="col-md-6">
                <label class="form-label"><strong>Expected</strong></label>
                <p class="form-control-plaintext">{{ number_format($payment->expected_amount, 0, ',', ' ') }} FCFA</p>
            </div>

            <div class="col-md-6">
                <label class="form-label"><strong>Already Paid</strong></label>
                <p class="form-control-plaintext">{{ number_format($payment->paid_amount, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <hr class="my-4">

        <form method="POST" action="{{ route('payments.pay', $payment) }}" id="pay-form-{{ $payment->id }}">
            @csrf

            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                    <input type="number" name="paid_amount" class="form-control" placeholder="Enter amount" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                    <select name="payment_method_id" class="form-select" required>
                        <option value="">Select a payment method</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-footer border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="pay-form-{{ $payment->id }}" class="btn btn-primary">
            <i class="bx bx-check me-1"></i> Pay Now
        </button>
    </div>
</x-modal>
