@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Payment Details</h5>

        <div class="card-body">

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label>Contract</label>
                    <input class="form-control" value="Contract #{{ $payment->contract->id }}" readonly>
                </div>

                <div class="col-md-6">
                    <label>Status</label>
                    <input class="form-control" value="{{ $payment->status->label ?? '' }}" readonly>
                </div>

                <div class="col-md-6">
                    <label>Expected</label>
                    <input class="form-control" value="{{ $payment->expected_amount }} FCFA" readonly>
                </div>

                <div class="col-md-6">
                    <label>Paid</label>
                    <input class="form-control" value="{{ $payment->paid_amount }} FCFA" readonly>
                </div>
            </div>

            {{-- PAY --}}
            <form method="POST" action="{{ route('payments.pay', $payment) }}">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label>Amount</label>
                        <input type="number" name="paid_amount" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Method</label>
                        <select name="payment_method_id" class="form-select">
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Pay</button>
                </div>
            </form>

            {{-- VALIDATE --}}
            <form method="POST" action="{{ route('payments.validate', $payment) }}" class="mt-3">
                @csrf
                <button class="btn btn-success">Validate</button>
            </form>

            {{-- CANCEL --}}
            <form method="POST" action="{{ route('payments.cancel', $payment) }}" class="mt-2">
                @csrf
                <button class="btn btn-danger">Cancel</button>
            </form>

        </div>
    </div>
@endsection