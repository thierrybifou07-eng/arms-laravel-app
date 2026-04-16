@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                            @foreach ($paymentMethods as $method)
                                <option
                                    @if ($method->code === 'orange_money' || $method->code === 'mtn_money') id="mobile_fields"
                                @elseif ($method->code === 'bank_transfer') id="card_fields" @endif
                                    value="{{ $method->id }}">
                                    {{ $method->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Pay</button>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script>
            $('input[name="method"]').on('change', function() {

                $('#mobile_fields, #card_fields').addClass('d-none');

                if (this.value === 'mobile') {
                    $('#mobile_fields').removeClass('d-none');
                }

                if (this.value === 'card') {
                    $('#card_fields').removeClass('d-none');
                }
            });
        </script>
    @endpush
@endsection
