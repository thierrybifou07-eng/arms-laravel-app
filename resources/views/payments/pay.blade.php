@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <h5 class="card-header">PAYMENT — FORMULAIRE DE PAIEMENT</h5>
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" action="{{ route('payments.pay') }}">
                @csrf
                <div class="row g-6">
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Expected Amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="PhoneNumber" value="{{ $payment->expected_amount }}" disabled
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Paid amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="number" id="PhoneNumber" name="paid_amount" required
                                value="{{ old('paid_amount') }}" class="form-control" placeholder="50000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="payment_method_id" class="form-label">Payment Methods</label>
                        <div class="position-relative"><select name="payment_method_id" id="resident"
                                class="select2 form-select" tabindex="-1" aria-hidden="true" required>
                                @foreach($PaymentMethods as $PaymentMethod)
                                    <option value="{{ $PaymentMethod->id }}">{{ $PaymentMethod->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <form action="{{ route('payments.validate', $payment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary me-3">Validate</button>
                        </form>
                        <form action="{{ route('payments.cancel', $payment->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-label-secondary" type="submit">Cancel</button>
                        </form>
                    </div>
                    <input type="hidden">
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            console.log($.fn.select2);
            console.log("Select2 init");
            $(document).ready(function () {

                $('#resident').select2({
                    placeholder: "Select resident",
                    allowClear: true,
                    width: '100%'
                });

                $('#room').select2({
                    placeholder: "Select room",
                    allowClear: true,
                    width: '100%'
                });

                /*                  $('#billing_period').select2({
                                    placeholder: "Select billing period",
                                    allowClear: true,
                                    width: '100%'
                                }); */
            });

        </script>
    @endpush
@endsection