@extends('layouts.app')

@section('content')
<div class="card mb-6">
    <h5 class="card-header">PAYMENT — Formulaire de paiement</h5>

    <div class="card-body pt-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-6 mb-4">
            <div class="col-md-6">
                <label class="form-label">Contract</label>
                <input type="text" class="form-control" value="Contract #{{ $payment->contract->id }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment status</label>
                <input type="text" class="form-control" value="{{ $payment->status->label ?? 'N/A' }}" readonly>
            </div>

            <div class="col-md-6">
                <label class="form-label">Expected Amount</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">FCFA</span>
                    <input type="text" class="form-control" value="{{ number_format($payment->expected_amount, 0, ',', ' ') }}" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Due date</label>
                <input type="text" class="form-control" value="{{ $payment->due_date?->format('d/m/Y') }}" readonly>
            </div>
        </div>

        <form method="POST" action="{{ route('payments.pay', $payment) }}">
            @csrf

            <div class="row g-6">
                <div class="col-md-6">
                    <label class="form-label" for="paid_amount">Paid Amount</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">FCFA</span>
                        <input type="number" id="paid_amount" name="paid_amount" required
                               value="{{ old('paid_amount', $payment->paid_amount ?? 0) }}"
                               class="form-control" placeholder="50000" min="0" step="1">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="payment_method_id" class="form-label">Payment Method</label>
                    <select name="payment_method_id" id="payment_method_id" class="select2 form-select" required>
                        <option value="" selected disabled>Select payment method</option>
                        @foreach($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->id }}" @selected(old('payment_method_id') == $paymentMethod->id)>
                                {{ $paymentMethod->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="btn btn-primary me-3">Submit payment</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>

        <div class="mt-4 d-flex gap-3">
            <form action="{{ route('payments.validate', $payment) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Validate</button>
            </form>

            <form action="{{ route('payments.cancel', $payment) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-label-danger">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection